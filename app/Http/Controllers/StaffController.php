<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LiveSession;
use App\Models\User;
use App\Notifications\PlatformNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StaffController extends Controller
{
    public function gradebook(Request $request): Response
    {
        $data = $this->gradebookData($request);

        return Inertia::render('Staff/Gradebook', $data);
    }

    public function exportGradebook(Request $request): StreamedResponse
    {
        $data = $this->gradebookData($request);
        abort_if(! $data['selectedCourse'], 404);
        $course = $data['selectedCourse'];

        return response()->streamDownload(function () use ($data): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Learner', 'Email', 'Cohort', ...array_map(fn ($assignment) => $assignment['title'].' / '.$assignment['maxPoints'], $data['assignments']), 'Graded points', 'Graded percentage']);
            foreach ($data['learners'] as $learner) {
                fputcsv($output, [
                    $learner['name'], $learner['email'], $learner['cohort'] ?? '',
                    ...array_map(fn ($assignment) => $learner['grades'][$assignment['id']]['score'] ?? $learner['grades'][$assignment['id']]['status'], $data['assignments']),
                    $learner['gradedPoints'].' / '.$learner['gradedPossible'], $learner['gradePercent'] === null ? 'Not graded' : $learner['gradePercent'].'%',
                ]);
            }
            fclose($output);
        }, str($course['slug'])->slug().'-gradebook.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function gradebookData(Request $request): array
    {
        $courseIds = $this->courseIdsFor($request);
        $courses = Course::query()->whereIn('id', $courseIds)->orderBy('title')->get(['id', 'title', 'slug']);
        $selectedCourse = $courses->firstWhere('id', (int) $request->query('course')) ?? $courses->first();
        if (! $selectedCourse) {
            return ['courses' => $courses, 'selectedCourse' => null, 'assignments' => [], 'learners' => []];
        }

        $assignments = DB::table('assignments')->where('course_id', $selectedCourse->id)->orderBy('due_at')->orderBy('id')->get(['id', 'title', 'max_points', 'due_at'])
            ->map(fn ($assignment) => ['id' => $assignment->id, 'title' => $assignment->title, 'maxPoints' => (float) $assignment->max_points, 'dueAt' => $assignment->due_at])->values();
        $learners = DB::table('enrollments')->join('users', 'users.id', '=', 'enrollments.user_id')
            ->leftJoin('cohorts', 'cohorts.id', '=', 'enrollments.cohort_id')
            ->where('enrollments.course_id', $selectedCourse->id)->where('enrollments.status', 'active')
            ->orderBy('users.name')->get(['users.id', 'users.name', 'users.email', 'cohorts.name as cohort'])->map(fn ($row) => [
                'id' => $row->id, 'name' => $row->name, 'email' => $row->email, 'cohort' => $row->cohort,
            ])->values();
        $submissionRows = $assignments->isEmpty() || $learners->isEmpty() ? collect() : DB::table('assignment_submissions')
            ->whereIn('assignment_id', $assignments->pluck('id'))->whereIn('user_id', $learners->pluck('id'))->get()
            ->keyBy(fn ($submission) => $submission->user_id.':'.$submission->assignment_id);
        $learners = $learners->map(function ($learner) use ($assignments, $submissionRows) {
            $gradedPoints = 0.0;
            $gradedPossible = 0.0;
            $grades = [];
            foreach ($assignments as $assignment) {
                $submission = $submissionRows->get($learner['id'].':'.$assignment['id']);
                $graded = $submission && $submission->status === 'graded' && $submission->score !== null;
                if ($graded) {
                    $gradedPoints += (float) $submission->score;
                    $gradedPossible += $assignment['maxPoints'];
                }
                $grades[$assignment['id']] = [
                    'status' => $graded ? 'graded' : ($submission?->status ?? 'missing'),
                    'score' => $graded ? (float) $submission->score : null,
                ];
            }

            return [...$learner, 'grades' => $grades, 'gradedPoints' => $gradedPoints, 'gradedPossible' => $gradedPossible,
                'gradePercent' => $gradedPossible > 0 ? (int) round($gradedPoints / $gradedPossible * 100) : null];
        });

        return ['courses' => $courses, 'selectedCourse' => ['id' => $selectedCourse->id, 'title' => $selectedCourse->title, 'slug' => $selectedCourse->slug], 'assignments' => $assignments, 'learners' => $learners];
    }

    public function dashboard(Request $request): Response
    {
        $user = $request->user();
        $isAdmin = $user->hasRole('admin');
        $isTeacher = $user->hasRole('teacher');
        $courseIds = $this->courseIdsFor($request);
        $cohortIds = $isAdmin || $user->hasRole('social_manager')
            ? DB::table('cohorts')->pluck('id')
            : $user->taughtCohorts()->pluck('cohorts.id');
        $activeEnrollments = DB::table('enrollments')->where('status', 'active')->whereIn('course_id', $courseIds);
        $learners = (clone $activeEnrollments)->distinct()->count('user_id');
        $liveThisWeek = LiveSession::query()->whereIn('cohort_id', $cohortIds)->where('status', 'scheduled')
            ->whereBetween('starts_at', [now(), now()->endOfWeek()])->count();
        $pendingQuery = $this->pendingSubmissionsQuery($courseIds);
        $pendingCount = (clone $pendingQuery)->count();

        $totalActivities = DB::table('enrollments')
            ->join('course_modules', 'course_modules.course_id', '=', 'enrollments.course_id')
            ->join('lessons', 'lessons.course_module_id', '=', 'course_modules.id')
            ->where('enrollments.status', 'active')->whereIn('enrollments.course_id', $courseIds)->count();
        $completedActivities = DB::table('lesson_progress')
            ->join('lessons', 'lessons.id', '=', 'lesson_progress.lesson_id')
            ->join('course_modules', 'course_modules.id', '=', 'lessons.course_module_id')
            ->join('enrollments', function ($join) {
                $join->on('enrollments.user_id', '=', 'lesson_progress.user_id')
                    ->on('enrollments.course_id', '=', 'course_modules.course_id');
            })
            ->where('enrollments.status', 'active')->whereNotNull('lesson_progress.completed_at')
            ->whereIn('enrollments.course_id', $courseIds)->count();
        $completion = $totalActivities ? (int) round($completedActivities / $totalActivities * 100) : 0;

        $sessions = LiveSession::query()->with(['cohort.course', 'teacher'])->whereIn('cohort_id', $cohortIds)
            ->where('status', 'scheduled')->where('starts_at', '>=', now())->orderBy('starts_at')->limit(5)->get()
            ->map(fn (LiveSession $session) => [
                'id' => $session->id,
                'title' => $session->title,
                'course' => $session->cohort->course->title,
                'teacher' => $session->teacher?->name ?? 'Teaching team',
                'startsAt' => $session->starts_at->format('D, M j · g:i A'),
                'learners' => DB::table('enrollments')->where('cohort_id', $session->cohort_id)->where('status', 'active')->count(),
            ])->values();

        $submissions = $isAdmin || $isTeacher ? (clone $pendingQuery)->orderBy('assignment_submissions.submitted_at')
            ->limit(6)->get()->map(fn ($submission) => [
                'id' => $submission->id,
                'title' => $submission->assignment_title,
                'course' => $submission->course_title,
                'student' => $submission->student_name,
                'submittedAt' => $submission->submitted_at,
            ])->values() : collect();

        return Inertia::render('StaffDashboaod', [
            'staff' => ['name' => $user->name, 'role' => $isAdmin ? 'Administrator' : ($isTeacher ? 'Teacher' : 'Social media manager')],
            'overview' => [
                'Active learners' => number_format($learners),
                'Live this week' => number_format($liveThisWeek),
                'Pending reviews' => number_format($pendingCount),
                'Completion rate' => $completion.'%',
            ],
            'sessions' => $sessions,
            'submissions' => $submissions,
            'canReview' => $isAdmin || $isTeacher,
            'canPublish' => $isAdmin || $user->hasRole('social_manager'),
            'canManage' => $isAdmin,
        ]);
    }

    public function reviews(Request $request): Response
    {
        $courseIds = $this->courseIdsFor($request);
        $submissions = $this->pendingSubmissionsQuery($courseIds)->orderBy('assignment_submissions.submitted_at')->orderBy('assignment_submissions.id')
            ->paginate(25)->withQueryString()->through(fn ($submission) => [
                'id' => $submission->id,
                'title' => $submission->assignment_title,
                'course' => $submission->course_title,
                'student' => $submission->student_name,
                'submittedAt' => $submission->submitted_at,
                'dueAt' => $submission->due_at,
            ]);

        return Inertia::render('Staff/Reviews', ['submissions' => $submissions]);
    }

    public function review(Request $request, int $submissionId): Response
    {
        $submission = $this->submissionForStaff($request, $submissionId);

        return Inertia::render('Staff/ReviewSubmission', ['submission' => [
            'id' => $submission->id,
            'title' => $submission->assignment_title,
            'course' => $submission->course_title,
            'student' => $submission->student_name,
            'email' => $submission->student_email,
            'response' => $submission->response,
            'submittedAt' => $submission->submitted_at,
            'dueAt' => $submission->due_at,
            'maxPoints' => (float) $submission->max_points,
        ]]);
    }

    public function grade(Request $request, int $submissionId): RedirectResponse
    {
        $submission = $this->submissionForStaff($request, $submissionId);
        $validated = $request->validate([
            'score' => ['required', 'numeric', 'min:0', 'max:'.$submission->max_points],
            'feedback' => ['required', 'string', 'min:5', 'max:10000'],
        ]);
        DB::table('assignment_submissions')->where('id', $submission->id)->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'status' => 'graded',
            'graded_by' => $request->user()->id,
            'graded_at' => now(),
            'updated_at' => now(),
        ]);
        $student = User::query()->find($submission->student_id);
        $student?->notify(new PlatformNotification(
            'Your assignment has been reviewed',
            'Feedback is ready for “'.$submission->assignment_title.'”. Score: '.$validated['score'].' / '.$submission->max_points.'.',
            route('learn.assignments.show', ['assignmentId' => $submission->assignment_id], false),
            'assignment',
        ));

        return to_route('staff.reviews', [], false)->with('success', 'Feedback has been shared with the learner.');
    }

    private function courseIdsFor(Request $request)
    {
        $user = $request->user();
        if ($user->hasRole('admin') || $user->hasRole('social_manager')) {
            return DB::table('courses')->pluck('id');
        }

        $mentorCourses = DB::table('course_mentors')->where('user_id', $user->id)->pluck('course_id');
        $cohortCourses = $user->taughtCohorts()->pluck('cohorts.course_id');

        return $mentorCourses->merge($cohortCourses)->unique()->values();
    }

    private function pendingSubmissionsQuery($courseIds)
    {
        return DB::table('assignment_submissions')
            ->join('assignments', 'assignments.id', '=', 'assignment_submissions.assignment_id')
            ->join('courses', 'courses.id', '=', 'assignments.course_id')
            ->join('users', 'users.id', '=', 'assignment_submissions.user_id')
            ->whereIn('assignments.course_id', $courseIds)->where('assignment_submissions.status', 'submitted')
            ->select(
                'assignment_submissions.id', 'assignment_submissions.response', 'assignment_submissions.submitted_at',
                'assignments.id as assignment_id', 'assignments.title as assignment_title', 'assignments.due_at', 'assignments.max_points',
                'courses.id as course_id', 'courses.title as course_title',
                'users.id as student_id', 'users.name as student_name', 'users.email as student_email',
            );
    }

    private function submissionForStaff(Request $request, int $submissionId): object
    {
        abort_unless($request->user()->hasRole('admin') || $request->user()->hasPermission('assessments.grade'), 403);
        $courseIds = $this->courseIdsFor($request);

        $submission = $this->pendingSubmissionsQuery($courseIds)->where('assignment_submissions.id', $submissionId)->first();
        abort_if(! $submission, 404);

        return $submission;
    }
}










