<?php

namespace App\Http\Controllers;

use App\Models\LiveSession;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Notifications\PlatformNotification;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class StudentLearningController extends Controller
{
    public function dashboard(Request $request): Response
    {
        $user = $request->user();
        $timezone = $this->timezone($user->timezone);
        $enrollments = $user->enrollments()
            ->where('status', 'active')
            ->with(['course.mentors', 'cohort'])
            ->get();
        $courseIds = $enrollments->pluck('course_id');
        $cohortIds = $enrollments->pluck('cohort_id')->filter();
        $completedLessonIds = DB::table('lesson_progress')
            ->where('user_id', $user->id)->whereNotNull('completed_at')->pluck('lesson_id')->all();
        $submittedAssignments = DB::table('assignment_submissions')->where('user_id', $user->id)->count();
        $attendedSessions = DB::table('session_attendance')->where('user_id', $user->id)->whereNotNull('joined_at')->count();
        $coursePurchases = $user->payments()->where('status', 'paid')->count();
        $eventPurchases = $user->webinarRegistrations()->whereIn('payment_status', ['paid', 'bypassed'])->count();

        $courses = $enrollments->map(function ($enrollment) use ($completedLessonIds) {
            $course = $enrollment->course;
            $lessons = DB::table('lessons')
                ->join('course_modules', 'course_modules.id', '=', 'lessons.course_module_id')
                ->where('course_modules.course_id', $course->id)
                ->orderBy('course_modules.position')->orderBy('lessons.position')
                ->select('lessons.id', 'lessons.title')->get();
            $done = $lessons->whereIn('id', $completedLessonIds)->count();
            $mentor = $course->mentors->first();

            return [
                'title' => $course->title,
                'mentor' => $mentor?->name ?? 'Your teaching team',
                'progress' => $lessons->isEmpty() ? 0 : (int) round($done / $lessons->count() * 100),
                'next' => $lessons->first(fn ($lesson) => ! in_array($lesson->id, $completedLessonIds, true))?->title ?? 'Course complete',
                'slug' => $course->slug,
                'cohort' => $enrollment->cohort?->name,
            ];
        })->values();

        $sessions = LiveSession::query()
            ->with(['cohort.course', 'teacher'])
            ->whereIn('cohort_id', $cohortIds)
            ->where('status', 'scheduled')
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')->limit(4)->get()
            ->map(fn (LiveSession $session) => $this->sessionCard($session, $timezone));

        $replays = LiveSession::query()
            ->with(['cohort.course', 'teacher'])
            ->whereIn('cohort_id', $cohortIds)
            ->whereNotNull('recording_url')->where('starts_at', '<', now())
            ->orderByDesc('starts_at')->limit(3)->get()
            ->map(fn (LiveSession $session) => $this->sessionCard($session, $timezone));

        $assignments = DB::table('assignments')
            ->join('courses', 'courses.id', '=', 'assignments.course_id')
            ->leftJoin('assignment_submissions', function ($join) use ($user) {
                $join->on('assignment_submissions.assignment_id', '=', 'assignments.id')
                    ->where('assignment_submissions.user_id', '=', $user->id);
            })
            ->whereIn('assignments.course_id', $courseIds)
            ->whereNull('assignment_submissions.id')
            ->where(fn ($query) => $query->whereNull('assignments.due_at')->orWhere('assignments.due_at', '>=', now()))
            ->orderByRaw('assignments.due_at is null')
            ->orderBy('assignments.due_at')->limit(3)
            ->get(['assignments.id', 'assignments.title', 'assignments.due_at', 'courses.title as course']);

        return Inertia::render('StudentDashboard', [
            'student' => [
                'name' => $user->name,
                'firstName' => str($user->name)->before(' ')->toString(),
                'initials' => collect(explode(' ', $user->name))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode(''),
                'timezone' => $timezone,
            ],
            'sessions' => $sessions,
            'courses' => $courses,
            'replays' => $replays,
            'assignments' => $assignments,
            'learningStats' => [
                'activeCourses' => $enrollments->count(),
                'completedLessons' => count($completedLessonIds),
                'submittedAssignments' => $submittedAssignments,
                'purchases' => $coursePurchases + $eventPurchases,
                'attendedSessions' => $attendedSessions,
            ],
            'today' => CarbonImmutable::now($timezone)->isoFormat('dddd, MMMM D, YYYY'),
        ]);
    }

    public function schedule(Request $request): Response
    {
        $user = $request->user();
        $timezone = $this->timezone($user->timezone);
        $view = $request->query('view', 'upcoming');
        if (! in_array($view, ['upcoming', 'past'], true)) {
            $view = 'upcoming';
        }

        $now = now();
        $cohortIds = $user->enrollments()->where('status', 'active')->whereNotNull('cohort_id')->pluck('cohort_id');
        $query = LiveSession::query()
            ->whereIn('cohort_id', $cohortIds)
            ->where('status', '!=', 'cancelled');
        $counts = [
            'upcoming' => (clone $query)->where('starts_at', '>=', $now)->count(),
            'past' => (clone $query)->where('starts_at', '<', $now)->count(),
        ];

        $sessionsQuery = (clone $query)->with(['cohort.course', 'teacher']);
        if ($view === 'upcoming') {
            $sessionsQuery->where('starts_at', '>=', $now)->orderBy('starts_at')->orderBy('id');
        } else {
            $sessionsQuery->where('starts_at', '<', $now)->orderByDesc('starts_at')->orderByDesc('id');
        }

        $sessions = $sessionsQuery->paginate(15)->withQueryString()->through(fn (LiveSession $session) => $this->sessionCard($session, $timezone));

        return Inertia::render('Learning/Schedule', [
            'sessions' => $sessions,
            'activeView' => $view,
            'counts' => $counts,
            'timezone' => $timezone,
        ]);
    }
    public function courses(Request $request): Response
    {
        $user = $request->user();
        $enrollments = $user->enrollments()->where('status', 'active')->with(['course.mentors', 'cohort'])
            ->orderByDesc('created_at')->orderByDesc('id')->paginate(12)->withQueryString();
        $courseIds = $enrollments->getCollection()->pluck('course_id');
        $lessons = DB::table('lessons')->join('course_modules', 'course_modules.id', '=', 'lessons.course_module_id')
            ->whereIn('course_modules.course_id', $courseIds)
            ->orderBy('course_modules.position')->orderBy('lessons.position')
            ->get(['lessons.id', 'lessons.title', 'course_modules.course_id'])->groupBy('course_id');
        $completedLessonIds = DB::table('lesson_progress')->where('user_id', $user->id)
            ->whereNotNull('completed_at')->whereIn('lesson_id', $lessons->flatten()->pluck('id'))
            ->pluck('lesson_id')->all();

        $courses = $enrollments->through(function ($enrollment) use ($lessons, $completedLessonIds) {
            $course = $enrollment->course;
            $courseLessons = $lessons->get($course->id, collect());
            $completed = $courseLessons->whereIn('id', $completedLessonIds)->count();

            return [
                'slug' => $course->slug,
                'title' => $course->title,
                'subtitle' => $course->subtitle,
                'image' => $course->cover_image,
                'mentor' => $course->mentors->first()?->name ?? 'Your teaching team',
                'cohort' => $enrollment->cohort?->name,
                'progress' => $courseLessons->isEmpty() ? 0 : (int) round($completed / $courseLessons->count() * 100),
                'completedLessons' => $completed,
                'totalLessons' => $courseLessons->count(),
                'nextLesson' => $courseLessons->first(fn ($lesson) => ! in_array($lesson->id, $completedLessonIds, true))?->title,
            ];
        });

        return Inertia::render('Learning/Courses', ['courses' => $courses]);
    }
    public function assignments(Request $request): Response
    {
        $user = $request->user();
        $filter = $request->query('status', 'to-do');
        if (! in_array($filter, ['to-do', 'submitted', 'all'], true)) {
            $filter = 'to-do';
        }

        $courseIds = $user->enrollments()->where('status', 'active')->select('course_id');
        $query = DB::table('assignments')
            ->join('courses', 'courses.id', '=', 'assignments.course_id')
            ->leftJoin('assignment_submissions', function ($join) use ($user) {
                $join->on('assignment_submissions.assignment_id', '=', 'assignments.id')
                    ->where('assignment_submissions.user_id', '=', $user->id);
            })
            ->whereIn('assignments.course_id', $courseIds);

        $counts = [
            'to-do' => (clone $query)->whereNull('assignment_submissions.status')->count('assignments.id'),
            'submitted' => (clone $query)->whereNotNull('assignment_submissions.status')->count('assignments.id'),
            'all' => (clone $query)->count('assignments.id'),
        ];

        if ($filter === 'to-do') {
            $query->whereNull('assignment_submissions.status');
        } elseif ($filter === 'submitted') {
            $query->whereNotNull('assignment_submissions.status');
        }

        $assignments = $query
            ->orderByRaw('assignments.due_at is null')
            ->orderBy('assignments.due_at')->orderBy('assignments.id')
            ->paginate(15, [
                'assignments.id', 'assignments.title', 'assignments.instructions', 'assignments.due_at',
                'courses.title as course_title', 'courses.slug as course_slug',
                'assignment_submissions.status as submission_status', 'assignment_submissions.submitted_at',
                'assignment_submissions.score', 'assignment_submissions.feedback',
            ])->withQueryString()->through(fn ($assignment) => [
                'id' => $assignment->id,
                'title' => $assignment->title,
                'instructions' => $assignment->instructions,
                'dueAt' => $assignment->due_at,
                'course' => $assignment->course_title,
                'courseSlug' => $assignment->course_slug,
                'status' => $assignment->submission_status ?? 'to-do',
                'submittedAt' => $assignment->submitted_at,
                'score' => $assignment->score,
                'feedback' => $assignment->feedback,
            ]);

        return Inertia::render('Learning/Assignments', [
            'assignments' => $assignments,
            'activeFilter' => $filter,
            'counts' => $counts,
        ]);
    }
    public function course(Request $request, Course $course): Response
    {
        $this->authorizeCourse($request, $course);
        $course->load(['modules.lessons', 'mentors']);
        $completedIds = DB::table('lesson_progress')->where('user_id', $request->user()->id)
            ->whereNotNull('completed_at')->pluck('lesson_id')->all();
        $lessons = $course->modules->flatMap->lessons;

        return Inertia::render('Learning/Course', [
            'course' => [
                'title' => $course->title,
                'subtitle' => $course->subtitle,
                'cover' => $course->cover_image,
                'progress' => $lessons->isEmpty() ? 0 : (int) round($lessons->whereIn('id', $completedIds)->count() / $lessons->count() * 100),
                'mentor' => $course->mentors->first()?->name ?? 'Your teaching team',
                'modules' => $course->modules->map(fn ($module) => [
                    'id' => $module->id,
                    'title' => $module->title,
                    'description' => $module->description,
                    'lessons' => $module->lessons->map(fn ($lesson) => [
                        'id' => $lesson->id,
                        'title' => $lesson->title,
                        'type' => $lesson->type,
                        'duration' => $lesson->duration_seconds,
                        'completed' => in_array($lesson->id, $completedIds, true),
                    ])->values(),
                ])->values(),
                'quizzes' => DB::table('quizzes')->where('course_id', $course->id)->where('published', true)
                    ->orderBy('id')->get()->map(function ($quiz) use ($request) {
                        $attempts = DB::table('quiz_attempts')->where('quiz_id', $quiz->id)
                            ->where('user_id', $request->user()->id)->whereNotNull('submitted_at');

                        return [
                            'id' => $quiz->id,
                            'title' => $quiz->title,
                            'questionCount' => DB::table('quiz_questions')->where('quiz_id', $quiz->id)->count(),
                            'attemptLimit' => $quiz->attempt_limit,
                            'attemptsUsed' => (clone $attempts)->count(),
                            'latestScore' => (clone $attempts)->orderByDesc('submitted_at')->value('score_percent'),
                        ];
                    })->values(),
            ],
        ]);
    }

    public function quiz(Request $request, int $quizId): Response
    {
        $quiz = DB::table('quizzes')->where('id', $quizId)->where('published', true)->first();
        abort_if(! $quiz, 404);
        abort_unless($request->user()->enrollments()->where('status', 'active')->where('course_id', $quiz->course_id)->exists(), 403);

        $questions = DB::table('quiz_questions')->where('quiz_id', $quiz->id)->orderBy('position')->get();
        $latestAttempt = DB::table('quiz_attempts')->where('quiz_id', $quiz->id)
            ->where('user_id', $request->user()->id)->whereNotNull('submitted_at')->orderByDesc('submitted_at')->first();
        $attemptsUsed = DB::table('quiz_attempts')->where('quiz_id', $quiz->id)
            ->where('user_id', $request->user()->id)->whereNotNull('submitted_at')->count();
        $reviewAnswers = $latestAttempt ? DB::table('quiz_answers')->where('quiz_attempt_id', $latestAttempt->id)->get()->keyBy('quiz_question_id') : collect();

        return Inertia::render('Learning/Quiz', [
            'quiz' => [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'courseId' => $quiz->course_id,
                'courseTitle' => DB::table('courses')->where('id', $quiz->course_id)->value('title'),
                'courseSlug' => DB::table('courses')->where('id', $quiz->course_id)->value('slug'),
                'passPercent' => $quiz->pass_percent,
                'attemptLimit' => $quiz->attempt_limit,
                'attemptsUsed' => $attemptsUsed,
                'remainingAttempts' => $quiz->attempt_limit === null ? null : max(0, $quiz->attempt_limit - $attemptsUsed),
                'canAttempt' => $quiz->attempt_limit === null || $attemptsUsed < $quiz->attempt_limit,
                'questions' => $questions->map(fn ($question) => [
                    'id' => $question->id,
                    'prompt' => $question->prompt,
                    'points' => (float) $question->points,
                    'options' => DB::table('quiz_options')->where('quiz_question_id', $question->id)->orderBy('position')
                        ->get(['id', 'body'])->map(fn ($option) => ['id' => $option->id, 'body' => $option->body])->values(),
                ])->values(),
                'latestAttempt' => $latestAttempt ? [
                    'score' => (float) $latestAttempt->score_percent,
                    'passed' => (bool) $latestAttempt->passed,
                    'submittedAt' => $latestAttempt->submitted_at,
                    'answers' => $questions->map(function ($question) use ($reviewAnswers) {
                        $answer = $reviewAnswers->get($question->id);
                        $correctOption = DB::table('quiz_options')->where('quiz_question_id', $question->id)->where('is_correct', true)->value('id');

                        return [
                            'questionId' => $question->id,
                            'selectedOptionId' => $answer ? (int) json_decode($answer->answer, true) : null,
                            'correctOptionId' => $correctOption ? (int) $correctOption : null,
                            'isCorrect' => (bool) ($answer?->is_correct ?? false),
                        ];
                    })->values(),
                ] : null,
            ],
        ]);
    }

    public function submitQuiz(Request $request, int $quizId): RedirectResponse
    {
        $validated = $request->validate(['answers' => ['required', 'array']]);

        DB::transaction(function () use ($request, $quizId, $validated) {
            $quiz = DB::table('quizzes')->where('id', $quizId)->where('published', true)->lockForUpdate()->first();
            abort_if(! $quiz, 404);
            abort_unless($request->user()->enrollments()->where('status', 'active')->where('course_id', $quiz->course_id)->exists(), 403);

            $questions = DB::table('quiz_questions')->where('quiz_id', $quiz->id)->orderBy('position')->get();
            abort_if($questions->isEmpty(), 422, 'This quiz does not have any questions yet.');
            $questionIds = $questions->pluck('id')->map(fn ($id) => (string) $id)->all();
            $answers = $validated['answers'];
            $providedIds = array_map('strval', array_keys($answers));
            if (array_diff($questionIds, $providedIds) || array_diff($providedIds, $questionIds)) {
                throw ValidationException::withMessages(['answers' => 'Answer every question before submitting.']);
            }
            foreach ($questions as $question) {
                $optionId = filter_var($answers[$question->id] ?? null, FILTER_VALIDATE_INT);
                if (! $optionId || ! DB::table('quiz_options')->where('id', $optionId)->where('quiz_question_id', $question->id)->exists()) {
                    throw ValidationException::withMessages(['answers.'.$question->id => 'Choose one of the listed answers.']);
                }
            }

            $attemptsUsed = DB::table('quiz_attempts')->where('quiz_id', $quiz->id)
                ->where('user_id', $request->user()->id)->whereNotNull('submitted_at')->count();
            if ($quiz->attempt_limit !== null && $attemptsUsed >= $quiz->attempt_limit) {
                throw ValidationException::withMessages(['quiz' => 'You have used all attempts for this quiz.']);
            }

            $pointsAvailable = (float) $questions->sum('points');
            $pointsEarned = 0.0;
            $answerRows = [];
            foreach ($questions as $question) {
                $optionId = (int) $answers[$question->id];
                $correct = DB::table('quiz_options')->where('id', $optionId)->where('quiz_question_id', $question->id)->value('is_correct');
                $isCorrect = (bool) $correct;
                if ($isCorrect) {
                    $pointsEarned += (float) $question->points;
                }
                $answerRows[] = ['question_id' => $question->id, 'answer' => json_encode($optionId), 'is_correct' => $isCorrect];
            }
            $score = $pointsAvailable > 0 ? round($pointsEarned / $pointsAvailable * 100, 2) : 0;
            $attemptId = DB::table('quiz_attempts')->insertGetId([
                'quiz_id' => $quiz->id,
                'user_id' => $request->user()->id,
                'started_at' => now(),
                'submitted_at' => now(),
                'score_percent' => $score,
                'passed' => $score >= $quiz->pass_percent,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('quiz_answers')->insert(array_map(fn ($answer) => $answer + [
                'quiz_attempt_id' => $attemptId,
                'created_at' => now(),
                'updated_at' => now(),
            ], $answerRows));
        });

        return to_route('learn.quizzes.show', $quizId)->with('success', 'Your quiz has been submitted. Review your result below.');
    }

    public function lesson(Request $request, Lesson $lesson): Response
    {
        $lesson->load(['module.course']);
        $this->authorizeCourse($request, $lesson->module->course);
        $userId = $request->user()->id;
        $sequence = $lesson->module->course->modules()->with('lessons')->get()->flatMap->lessons->values();
        $completedIds = DB::table('lesson_progress')->where('user_id', $userId)
            ->whereNotNull('completed_at')->pluck('lesson_id')->all();
        $index = $sequence->search(fn ($item) => $item->id === $lesson->id);

        return Inertia::render('Learning/Lesson', [
            'course' => ['title' => $lesson->module->course->title, 'slug' => $lesson->module->course->slug],
            'module' => ['title' => $lesson->module->title],
            'lesson' => [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'summary' => $lesson->summary,
                'type' => $lesson->type,
                'duration' => $lesson->duration_seconds,
                'videoUrl' => $lesson->video_url,
                'body' => $lesson->body,
                'resourcePath' => $lesson->resource_path,
                'completed' => in_array($lesson->id, $completedIds, true),
                'previousId' => $index > 0 ? $sequence[$index - 1]->id : null,
                'nextId' => $index < $sequence->count() - 1 ? $sequence[$index + 1]->id : null,
            ],
        ]);
    }

    public function completeLesson(Request $request, Lesson $lesson): RedirectResponse
    {
        $lesson->load('module.course');
        $this->authorizeCourse($request, $lesson->module->course);
        DB::table('lesson_progress')->updateOrInsert(
            ['user_id' => $request->user()->id, 'lesson_id' => $lesson->id],
            ['completed_at' => now(), 'updated_at' => now(), 'created_at' => now()],
        );

        return back()->with('success', 'Lesson marked as complete.');
    }

    public function assignment(Request $request, int $assignmentId): Response
    {
        $assignment = DB::table('assignments')
            ->join('courses', 'courses.id', '=', 'assignments.course_id')
            ->where('assignments.id', $assignmentId)
            ->whereIn('assignments.course_id', $request->user()->enrollments()->where('status', 'active')->select('course_id'))
            ->first(['assignments.*', 'courses.title as course_title', 'courses.slug as course_slug']);
        abort_if(! $assignment, 404);
        $submission = DB::table('assignment_submissions')->where('assignment_id', $assignmentId)
            ->where('user_id', $request->user()->id)->first();

        return Inertia::render('Learning/Assignment', [
            'assignment' => [
                'id' => $assignment->id,
                'title' => $assignment->title,
                'instructions' => $assignment->instructions,
                'dueAt' => $assignment->due_at,
                'course' => $assignment->course_title,
                'courseSlug' => $assignment->course_slug,
                'submission' => $submission ? [
                    'response' => $submission->response,
                    'status' => $submission->status,
                    'score' => $submission->score,
                    'feedback' => $submission->feedback,
                    'submittedAt' => $submission->submitted_at,
                ] : null,
            ],
        ]);
    }

    public function submitAssignment(Request $request, int $assignmentId): RedirectResponse
    {
        $assignment = DB::table('assignments')->where('id', $assignmentId)->first();
        abort_if(! $assignment, 404);
        abort_unless($request->user()->enrollments()->where('status', 'active')->where('course_id', $assignment->course_id)->exists(), 404);
        $alreadySubmitted = DB::table('assignment_submissions')->where('assignment_id', $assignmentId)
            ->where('user_id', $request->user()->id)->exists();
        if ($alreadySubmitted) {
            throw ValidationException::withMessages(['response' => 'This assignment has already been submitted.']);
        }

        $validated = $request->validate(['response' => ['required', 'string', 'min:5', 'max:20000']]);
        DB::table('assignment_submissions')->insert([
            'assignment_id' => $assignmentId,
            'user_id' => $request->user()->id,
            'response' => $validated['response'],
            'status' => 'submitted',
            'submitted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $courseName = DB::table('courses')->where('id', $assignment->course_id)->value('title') ?? 'your course';
        $courseMentorIds = DB::table('course_mentors')->where('course_id', $assignment->course_id)->pluck('user_id');
        $cohortTeacherIds = DB::table('cohorts')->join('cohort_teachers', 'cohort_teachers.cohort_id', '=', 'cohorts.id')
            ->where('cohorts.course_id', $assignment->course_id)->pluck('cohort_teachers.user_id');
        $reviewers = User::query()->where(function ($query) use ($courseMentorIds, $cohortTeacherIds) {
            $query->whereIn('id', $courseMentorIds->merge($cohortTeacherIds)->unique())
                ->orWhereHas('roles', fn ($roles) => $roles->where('name', 'admin')
                    ->orWhereHas('permissions', fn ($permissions) => $permissions->where('name', 'assessments.grade')));
        })->where('id', '!=', $request->user()->id)->get();
        foreach ($reviewers as $reviewer) {
            $reviewer->notify(new PlatformNotification(
                'Learner work is ready to review',
                $request->user()->name.' submitted “'.$assignment->title.'” for '.$courseName.'.',
                route('staff.reviews', [], false),
                'assignment',
            ));
        }

        return back()->with('success', 'Your work has been submitted.');
    }

    public function session(Request $request, LiveSession $liveSession): Response
    {
        $this->authorizeEnrollment($request, $liveSession);
        $session = $liveSession->load(['cohort.course', 'teacher']);
        $timezone = $this->timezone($request->user()->timezone);

        return Inertia::render('Learning/Session', [
            'session' => array_merge($this->sessionCard($session, $timezone), [
                'description' => $session->description,
                'joinUrl' => $session->starts_at->addMinutes($session->duration_minutes)->isFuture() ? $session->join_url : null,
                'recordingUrl' => $session->starts_at->addMinutes($session->duration_minutes)->isPast() ? $session->recording_url : null,
                'provider' => $session->provider,
            ]),
        ]);
    }

    public function calendar(Request $request): HttpResponse
    {
        $user = $request->user();
        $cohortIds = $user->enrollments()->where('status', 'active')->whereNotNull('cohort_id')->pluck('cohort_id');
        $sessions = LiveSession::query()->with('cohort.course')
            ->whereIn('cohort_id', $cohortIds)
            ->whereBetween('starts_at', [now()->subDays(30), now()->addMonths(6)])
            ->where('status', '!=', 'cancelled')->orderBy('starts_at')->get();

        $events = $sessions->map(function (LiveSession $session) {
            $start = $session->starts_at->utc();
            $end = $start->addMinutes($session->duration_minutes);
            $description = $session->description ?? $session->cohort->course->title;

            return implode("\r\n", [
                'BEGIN:VEVENT',
                'UID:session-'.$session->id.'@kanram-academy',
                'DTSTAMP:'.now()->utc()->format('Ymd\THis\Z'),
                'DTSTART:'.$start->format('Ymd\THis\Z'),
                'DTEND:'.$end->format('Ymd\THis\Z'),
                'SUMMARY:'.$this->escapeIcs($session->title),
                'DESCRIPTION:'.$this->escapeIcs($description),
                $session->join_url ? 'URL:'.$this->escapeIcs($session->join_url) : '',
                'END:VEVENT',
            ]);
        })->implode("\r\n");

        return response("BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Kanram Academy//Live Learning//EN\r\nCALSCALE:GREGORIAN\r\nMETHOD:PUBLISH\r\n".$events."\r\nEND:VCALENDAR\r\n", 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="kanram-academy-classes.ics"',
        ]);
    }

    private function authorizeEnrollment(Request $request, LiveSession $session): void
    {
        abort_unless($request->user()->enrollments()->where('status', 'active')->where('cohort_id', $session->cohort_id)->exists(), 403);
    }

    private function authorizeCourse(Request $request, Course $course): void
    {
        abort_unless($request->user()->enrollments()->where('status', 'active')->where('course_id', $course->id)->exists(), 403);
    }

    private function sessionCard(LiveSession $session, string $timezone): array
    {
        $startsAt = $session->starts_at->timezone($timezone);

        return [
            'id' => $session->id,
            'title' => $session->title,
            'course' => $session->cohort?->course?->title ?? 'Live class',
            'teacher' => $session->teacher?->name ?? 'Teaching team',
            'date' => $startsAt->format('D, M j'),
            'day' => $startsAt->format('D'),
            'dayNumber' => $startsAt->format('j'),
            'time' => $startsAt->format('g:i A'),
            'startsAt' => $startsAt->toIso8601String(),
            'duration' => $session->duration_minutes,
            'joinable' => filled($session->join_url) && $session->starts_at->addMinutes($session->duration_minutes)->isFuture(),
            'hasReplay' => filled($session->recording_url) && $session->starts_at->addMinutes($session->duration_minutes)->isPast(),
        ];
    }

    private function timezone(?string $timezone): string
    {
        return $timezone && in_array($timezone, timezone_identifiers_list(), true) ? $timezone : 'UTC';
    }

    private function escapeIcs(string $value): string
    {
        return str_replace(["\\", ";", ",", "\r\n", "\n"], ["\\\\", "\\;", "\\,", "\\n", "\\n"], $value);
    }
}






