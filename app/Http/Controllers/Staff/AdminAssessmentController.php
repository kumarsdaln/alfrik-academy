<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AdminAssessmentController extends Controller
{
    public function index(): Response
    {
        $courses = Course::query()->select('id', 'title')->with(['modules:id,course_id,title', 'modules.lessons:id,course_module_id,title'])->orderBy('title')->get();

        return Inertia::render('Staff/Manage/Assessments', [
            'courses' => $courses,
            'assignments' => DB::table('assignments')->join('courses', 'courses.id', '=', 'assignments.course_id')->leftJoin('lessons', 'lessons.id', '=', 'assignments.lesson_id')->orderByDesc('assignments.created_at')->orderByDesc('assignments.id')->paginate(20, ['assignments.*', 'courses.title as course_title', 'lessons.title as lesson_title'], 'assignmentPage')->withQueryString(),
            'quizzes' => DB::table('quizzes')->join('courses', 'courses.id', '=', 'quizzes.course_id')->leftJoin('quiz_questions', 'quiz_questions.quiz_id', '=', 'quizzes.id')->select('quizzes.id', 'quizzes.title', 'quizzes.course_id', 'quizzes.pass_percent', 'quizzes.attempt_limit', 'quizzes.published', 'courses.title as course_title', DB::raw('count(quiz_questions.id) as questions_count'))->groupBy('quizzes.id', 'courses.title', 'quizzes.created_at')->orderByDesc('quizzes.created_at')->orderByDesc('quizzes.id')->paginate(20, ['quizzes.id', 'quizzes.title', 'quizzes.course_id', 'quizzes.pass_percent', 'quizzes.attempt_limit', 'quizzes.published', 'courses.title as course_title', DB::raw('count(quiz_questions.id) as questions_count')], 'quizPage')->withQueryString(),
        ]);
    }

    public function storeAssignment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses,id'], 'lesson_id' => ['nullable', 'exists:lessons,id'],
            'title' => ['required', 'string', 'max:180'], 'instructions' => ['required', 'string', 'max:20000'],
            'due_at' => ['nullable', 'date'], 'max_points' => ['required', 'numeric', 'min:1', 'max:100000'],
        ]);
        if (! empty($data['lesson_id'])) {
            abort_unless(DB::table('lessons')->join('course_modules', 'course_modules.id', '=', 'lessons.course_module_id')->where('lessons.id', $data['lesson_id'])->where('course_modules.course_id', $data['course_id'])->exists(), 422, 'Choose a lesson from the selected course.');
        }
        DB::table('assignments')->insert([...$data, 'created_at' => now(), 'updated_at' => now()]);

        return back()->with('success', 'Assignment published to the course workspace.');
    }

    public function updateAssignment(Request $request, int $assignmentId): RedirectResponse
    {
        $assignment = DB::table('assignments')->where('id', $assignmentId)->first();
        abort_if(! $assignment, 404);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'], 'instructions' => ['required', 'string', 'max:20000'],
            'due_at' => ['nullable', 'date'], 'max_points' => ['required', 'numeric', 'min:1', 'max:100000'],
        ]);
        DB::table('assignments')->where('id', $assignment->id)->update([...$data, 'updated_at' => now()]);

        return back()->with('success', 'Assignment details updated.');
    }

    public function storeQuiz(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses,id'], 'lesson_id' => ['nullable', 'exists:lessons,id'],
            'title' => ['required', 'string', 'max:180'], 'pass_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'attempt_limit' => ['nullable', 'integer', 'min:1', 'max:100'], 'published' => ['required', 'boolean'],
            'questions' => ['required', 'array', 'min:1', 'max:30'], 'questions.*.prompt' => ['required', 'string', 'max:2000'],
            'questions.*.options' => ['required', 'array', 'min:2', 'max:8'], 'questions.*.options.*' => ['required', 'string', 'max:1000'],
            'questions.*.answer' => ['required', 'integer', 'min:0'],
        ]);
        if (! empty($data['lesson_id'])) {
            abort_unless(DB::table('lessons')->join('course_modules', 'course_modules.id', '=', 'lessons.course_module_id')->where('lessons.id', $data['lesson_id'])->where('course_modules.course_id', $data['course_id'])->exists(), 422, 'Choose a lesson from the selected course.');
        }
        foreach ($data['questions'] as $question) {
            abort_if($question['answer'] >= count($question['options']), 422, 'A correct answer must be selected for each question.');
        }

        DB::transaction(function () use ($data) {
            $quizId = DB::table('quizzes')->insertGetId([
                'course_id' => $data['course_id'], 'lesson_id' => $data['lesson_id'] ?? null, 'title' => $data['title'],
                'pass_percent' => $data['pass_percent'], 'attempt_limit' => $data['attempt_limit'] ?? null,
                'published' => $data['published'], 'created_at' => now(), 'updated_at' => now(),
            ]);
            foreach ($data['questions'] as $index => $question) {
                $questionId = DB::table('quiz_questions')->insertGetId([
                    'quiz_id' => $quizId, 'prompt' => $question['prompt'], 'type' => 'single_choice',
                    'points' => 1, 'position' => $index + 1, 'created_at' => now(), 'updated_at' => now(),
                ]);
                foreach ($question['options'] as $optionIndex => $option) {
                    DB::table('quiz_options')->insert([
                        'quiz_question_id' => $questionId, 'body' => $option, 'is_correct' => $optionIndex === $question['answer'], 'position' => $optionIndex + 1,
                    ]);
                }
            }
        });

        return back()->with('success', 'Quiz and answer key created.');
    }

    public function updateQuiz(Request $request, int $quizId): RedirectResponse
    {
        $data = $request->validate(['published' => ['required', 'boolean']]);
        DB::table('quizzes')->where('id', $quizId)->update(['published' => $data['published'], 'updated_at' => now()]);

        return back()->with('success', $data['published'] ? 'Quiz is now available to enrolled learners.' : 'Quiz unpublished.');
    }
}

