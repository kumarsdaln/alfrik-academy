<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AuditEvent;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\LiveSession;
use App\Models\Role;
use App\Models\User;
use App\Support\Images\ImageUpload;
use App\Notifications\PlatformNotification;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AdminOperationsController extends Controller
{
    public function audit(): Response
    {
        return Inertia::render('Staff/Manage/Audit', [
            'events' => AuditEvent::query()->with('actor:id,name,email')->latest('created_at')->paginate(40),
        ]);
    }

    public function index(): Response
    {
        return Inertia::render('Staff/Manage/Index', ['counts' => [
            'Courses' => Course::query()->count(), 'Learners & staff' => User::query()->count(),
            'Cohorts' => Cohort::query()->count(), 'Live sessions' => LiveSession::query()->count(),
            'Course reviews' => CourseReview::query()->count(), 'Contact requests' => DB::table('contact_inquiries')->count(),
        ]]);
    }

    public function users(Request $request): Response
    {
        $search = $request->string('q')->trim()->toString();
        $users = User::query()->with('roles:id,name,label')->when($search, fn ($query) => $query->where(fn ($q) => $q->where('name', 'ilike', "%{$search}%")->orWhere('email', 'ilike', "%{$search}%")))->orderBy('name')->paginate(25)->withQueryString();

        return Inertia::render('Staff/Manage/Users', ['users' => $users, 'roles' => Role::query()->orderBy('label')->get(['id', 'name', 'label']), 'filters' => ['q' => $search]]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'], 'role' => ['required', 'exists:roles,name'],
        ]);
        $role = $data['role'];
        unset($data['role']);
        $user = User::query()->create($data + ['is_active' => true]);
        $user->roles()->sync(Role::query()->where('name', $role)->value('id'));
        $user->sendEmailVerificationNotification();

        return back()->with('success', 'User account created. Share the temporary password securely.');
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', 'exists:roles,name'], 'is_active' => ['required', 'boolean'],
            'bio' => ['nullable', 'string', 'max:4000'], 'avatar_path' => ['nullable', 'string', 'max:2048'],
            'avatar_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
        if ($path = ImageUpload::store($request, 'avatar_upload', 'avatars', 400, 400)) {
            ImageUpload::deleteManaged($user->getRawOriginal('avatar_path'), 'avatars');
            $data['avatar_path'] = $path;
        } else {
            $data['avatar_path'] = $user->getRawOriginal('avatar_path');
        }
        unset($data['avatar_upload']);
        abort_if($user->is($request->user()) && (! $data['is_active'] || $data['role'] !== 'admin'), 422, 'You cannot remove your own administrator access.');
        DB::transaction(function () use ($user, $data) {
            $user->update(['is_active' => $data['is_active'], 'bio' => $data['bio'] ?? null, 'avatar_path' => $data['avatar_path'] ?? null]);
            $user->roles()->sync(Role::query()->where('name', $data['role'])->value('id'));
        });

        return back()->with('success', 'User access updated.');
    }

    public function sessions(Request $request): Response
    {
        $user = $request->user();
        $isAdmin = $user->hasRole('admin');
        $cohortIds = $isAdmin ? Cohort::query()->pluck('id') : $user->taughtCohorts()->pluck('cohorts.id');

        return Inertia::render('Staff/Manage/Sessions', [
            'cohorts' => Cohort::query()->with('course:id,title')->withCount('enrollments')->whereIn('id', $cohortIds)->orderByDesc('starts_on')->get(),
            'sessions' => LiveSession::query()->with(['cohort.course:id,title', 'teacher:id,name'])->whereIn('cohort_id', $cohortIds)->orderByDesc('starts_at')->limit(100)->get(),
            'courses' => $isAdmin ? Course::query()->where('status', 'published')->orderBy('title')->get(['id', 'title']) : collect(),
            'teachers' => $isAdmin ? User::query()->whereHas('roles', fn ($query) => $query->whereIn('name', ['teacher', 'admin']))->orderBy('name')->get(['id', 'name']) : collect(),
            'canManageCohorts' => $isAdmin,
            'staffUserId' => $user->id,
        ]);
    }

    public function storeCohort(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses,id'], 'name' => ['required', 'string', 'max:180'],
            'timezone' => ['required', 'timezone'], 'capacity' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'starts_on' => ['nullable', 'date'], 'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'status' => ['required', Rule::in(['open', 'in_progress', 'completed', 'closed'])], 'teacher_ids' => ['array'], 'teacher_ids.*' => ['exists:users,id'],
        ]);
        $teacherIds = $data['teacher_ids'] ?? [];
        $eligibleTeachers = User::query()->whereIn('id', $teacherIds)->whereHas('roles', fn ($query) => $query->whereIn('name', ['teacher', 'admin']))->count();
        abort_unless($eligibleTeachers === count($teacherIds), 422, 'Only teachers and administrators can teach a cohort.');
        unset($data['teacher_ids']);
        $cohort = Cohort::query()->create($data);
        $cohort->teachers()->sync($teacherIds);

        return back()->with('success', 'Cohort created.');
    }

    public function storeSession(Request $request): RedirectResponse
    {
        $user = $request->user();
        $isAdmin = $user->hasRole('admin');
        $data = $request->validate([
            'cohort_id' => ['required', 'exists:cohorts,id'], 'teacher_id' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:180'], 'description' => ['nullable', 'string', 'max:5000'],
            'starts_at' => ['required', 'date_format:Y-m-d\\TH:i'], 'duration_minutes' => ['required', 'integer', 'min:15', 'max:720'],
            'provider' => ['nullable', 'string', 'max:100'], 'join_url' => ['nullable', 'url', 'max:2048'],
        ]);
        $cohort = Cohort::query()->with('teachers')->findOrFail($data['cohort_id']);
        abort_unless($isAdmin || $cohort->teachers->contains('id', $user->id), 404);
        if (! $isAdmin) {
            $data['teacher_id'] = $user->id;
        }
        if (! empty($data['teacher_id'])) {
            $eligibleTeacher = User::query()->whereKey($data['teacher_id'])
                ->whereHas('roles', fn ($query) => $query->whereIn('name', ['teacher', 'admin']))->exists();
            $assignedToCohort = DB::table('cohort_teachers')->where('cohort_id', $cohort->id)->where('user_id', $data['teacher_id'])->exists();
            abort_unless($eligibleTeacher && ($isAdmin || $assignedToCohort), 422, 'Select a teacher assigned to this cohort.');
        }
        $timezone = Cohort::query()->whereKey($data['cohort_id'])->value('timezone') ?: 'UTC';
        $data['starts_at'] = CarbonImmutable::createFromFormat('Y-m-d\TH:i', $data['starts_at'], $timezone)->utc();
        $data['status'] = 'scheduled';
        $session = LiveSession::query()->create($data);
        $learnerIds = DB::table('enrollments')->where('cohort_id', $session->cohort_id)->where('status', 'active')->pluck('user_id');
        $timezone = DB::table('cohorts')->where('id', $session->cohort_id)->value('timezone') ?: 'UTC';
        foreach (User::query()->whereIn('id', $learnerIds)->get() as $learner) {
            $learner->notify(new PlatformNotification(
                'A new live class is on your calendar',
                $session->title.' · '.$session->starts_at->timezone($timezone)->format('D, M j · g:i A'),
                route('learn.sessions.show', ['liveSession' => $session->id], false),
                'session',
            ));
        }

        return back()->with('success', 'Live class scheduled.');
    }

    public function updateSession(Request $request, LiveSession $liveSession): RedirectResponse
    {
        abort_unless($request->user()->hasRole('admin') || $request->user()->taughtCohorts()->whereKey($liveSession->cohort_id)->exists(), 404);
        $data = $request->validate(['status' => ['required', Rule::in(['scheduled', 'completed', 'cancelled'])], 'recording_url' => ['nullable', 'url', 'max:2048']]);
        $statusChanged = $liveSession->status !== $data['status'];
        $replayAdded = blank($liveSession->recording_url) && filled($data['recording_url'] ?? null);
        $liveSession->update($data);
        if ($statusChanged || $replayAdded) {
            $learnerIds = DB::table('enrollments')->where('cohort_id', $liveSession->cohort_id)->where('status', 'active')->pluck('user_id');
            $cancelled = $data['status'] === 'cancelled';
            foreach (User::query()->whereIn('id', $learnerIds)->get() as $learner) {
                $learner->notify(new PlatformNotification(
                    $replayAdded ? 'A class replay is ready' : ($cancelled ? 'A live class has been cancelled' : 'A live class has been updated'),
                    $replayAdded ? 'The recording for “'.$liveSession->title.'” is now available.'
                        : $liveSession->title.($cancelled ? ' will no longer take place.' : ' is now marked '.$data['status'].'.'),
                    route('learn.sessions.show', ['liveSession' => $liveSession->id], false),
                    'session',
                ));
            }
        }

        return back()->with('success', 'Live class updated.');
    }

    public function attendance(Request $request, LiveSession $liveSession): Response
    {
        abort_unless($request->user()->hasRole('admin') || $request->user()->taughtCohorts()->whereKey($liveSession->cohort_id)->exists(), 404);
        $liveSession->load('cohort.course');
        $learners = DB::table('enrollments')->join('users', 'users.id', '=', 'enrollments.user_id')
            ->leftJoin('session_attendance', function ($join) use ($liveSession) {
                $join->on('session_attendance.user_id', '=', 'users.id')
                    ->where('session_attendance.live_session_id', '=', $liveSession->id);
            })
            ->where('enrollments.cohort_id', $liveSession->cohort_id)->where('enrollments.status', 'active')
            ->orderBy('users.name')->get([
                'users.id', 'users.name', 'users.email', 'session_attendance.status',
                'session_attendance.minutes_attended', 'session_attendance.joined_at',
            ])->map(fn ($learner) => [
                'id' => $learner->id, 'name' => $learner->name, 'email' => $learner->email,
                'status' => $learner->status && $learner->status !== 'registered' ? $learner->status : 'unmarked',
                'minutesAttended' => $learner->minutes_attended ?? 0,
                'joinedAt' => $learner->joined_at,
            ])->values();

        return Inertia::render('Staff/Attendance', [
            'session' => [
                'id' => $liveSession->id, 'title' => $liveSession->title,
                'course' => $liveSession->cohort->course->title, 'cohort' => $liveSession->cohort->name,
                'startsAt' => $liveSession->starts_at->toIso8601String(), 'timezone' => $liveSession->cohort->timezone,
            ],
            'learners' => $learners,
        ]);
    }

    public function updateAttendance(Request $request, LiveSession $liveSession): RedirectResponse
    {
        abort_unless($request->user()->hasRole('admin') || $request->user()->taughtCohorts()->whereKey($liveSession->cohort_id)->exists(), 404);
        $data = $request->validate([
            'attendance' => ['required', 'array', 'max:1000'],
            'attendance.*.user_id' => ['required', 'integer', 'distinct'],
            'attendance.*.status' => ['required', Rule::in(['present', 'late', 'absent', 'excused', 'unmarked'])],
            'attendance.*.minutes_attended' => ['nullable', 'integer', 'min:0', 'max:720'],
        ]);

        $rows = collect($data['attendance']);
        $learnerIds = DB::table('enrollments')->where('cohort_id', $liveSession->cohort_id)->where('status', 'active')->pluck('user_id');
        abort_if($rows->pluck('user_id')->diff($learnerIds)->isNotEmpty(), 422, 'Attendance can only be recorded for active learners in this cohort.');

        $now = now();
        $attendanceRows = $rows->map(fn ($row) => [
            'live_session_id' => $liveSession->id,
            'user_id' => $row['user_id'],
            'status' => $row['status'] === 'unmarked' ? 'registered' : $row['status'],
            'minutes_attended' => $row['minutes_attended'] ?? 0,
            'joined_at' => in_array($row['status'], ['present', 'late'], true) ? $now : null,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();
        if ($attendanceRows !== []) {
            DB::table('session_attendance')->upsert(
                $attendanceRows,
                ['live_session_id', 'user_id'],
                ['status', 'minutes_attended', 'joined_at', 'updated_at'],
            );
        }

        return back()->with('success', 'Attendance saved for this class.');
    }

    public function reviews(): Response
    {
        return Inertia::render('Staff/Manage/CourseReviews', [
            'reviews' => CourseReview::query()->with(['course:id,title,slug', 'user:id,name,email'])->latest()->paginate(30),
        ]);
    }

    public function updateReview(Request $request, CourseReview $review): RedirectResponse
    {
        $data = $request->validate(['is_published' => ['required', 'boolean']]);
        $review->update($data);

        return back()->with('success', 'Course review moderation updated.');
    }

    public function inquiries(): Response
    {
        return Inertia::render('Staff/Manage/Inquiries', ['inquiries' => DB::table('contact_inquiries')->latest()->paginate(30)]);
    }

    public function updateInquiry(Request $request, int $inquiryId): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(['new', 'in_progress', 'resolved'])]]);
        DB::table('contact_inquiries')->where('id', $inquiryId)->update([
            'status' => $data['status'], 'handled_at' => $data['status'] === 'resolved' ? now() : null, 'updated_at' => now(),
        ]);

        return back()->with('success', 'Contact request updated.');
    }
}




