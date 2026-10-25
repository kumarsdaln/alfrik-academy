<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Enrollment;
use App\Models\LiveSession;
use App\Models\Role;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LiveLearningDemoSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = User::updateOrCreate(['email' => 'maya@northstar.test'], [
            'name' => 'Maya Chen', 'password' => 'password', 'timezone' => 'Asia/Kolkata',
            'bio' => 'Product designer and cohort mentor.',
        ]);
        $teacher->roles()->sync(Role::where('name', 'teacher')->pluck('id'));

        $student = User::where('email', 'student@northstar.test')->first();
        if (! $student) {
            return;
        }

        $category = Category::updateOrCreate(['slug' => 'design'], ['name' => 'Design', 'sort_order' => 1]);
        $course = Course::updateOrCreate(['slug' => 'product-design-sprint'], [
            'category_id' => $category->id,
            'created_by' => $teacher->id,
            'title' => 'Product Design Sprint',
            'subtitle' => 'From the first sketch to a testable prototype.',
            'description' => 'A practical cohort for building confidence in product design.',
            'level' => 'intermediate',
            'duration_weeks' => 4,
            'price_minor' => 149000,
            'currency' => 'USD',
            'status' => 'published',
            'published_at' => now(),
        ]);
        $course->mentors()->syncWithoutDetaching([$teacher->id => ['title' => 'Lead mentor']]);

        $syllabus = [
            ['title' => 'Find the signal', 'description' => 'Learn to frame a useful product problem.', 'lessons' => [
                ['title' => 'Start with the people', 'summary' => 'A short introduction to useful user research.', 'body' => "Good design begins with curiosity.\n\nStart by writing down what you know, what you assume, and what you still need to learn.", 'duration' => 480],
                ['title' => 'Frame the problem', 'summary' => 'Turn observations into a focused design opportunity.', 'body' => 'Use evidence from conversations to describe a specific need and the moment where it appears.', 'duration' => 620],
            ]],
            ['title' => 'Make it tangible', 'description' => 'Explore ideas, build a prototype, and learn from feedback.', 'lessons' => [
                ['title' => 'Sketch a few directions', 'summary' => 'Explore several possible solutions before committing.', 'body' => 'Generate options quickly. Compare them against the needs and constraints you uncovered in the first module.', 'duration' => 540],
                ['title' => 'Build a testable flow', 'summary' => 'Connect your strongest idea into a clear user journey.', 'body' => 'Map the steps from the starting point to the user’s goal. Keep the first prototype focused on one valuable task.', 'duration' => 720],
            ]],
        ];

        $lessons = collect();
        foreach ($syllabus as $moduleIndex => $moduleData) {
            $module = CourseModule::updateOrCreate(
                ['course_id' => $course->id, 'position' => $moduleIndex + 1],
                ['title' => $moduleData['title'], 'description' => $moduleData['description']],
            );
            foreach ($moduleData['lessons'] as $lessonIndex => $lessonData) {
                $lesson = $module->lessons()->updateOrCreate(
                    ['position' => $lessonIndex + 1],
                    [
                        'title' => $lessonData['title'], 'summary' => $lessonData['summary'],
                        'body' => $lessonData['body'], 'type' => 'lesson',
                        'duration_seconds' => $lessonData['duration'], 'is_preview' => false,
                    ],
                );
                $lessons->push($lesson);
            }
        }

        $cohort = Cohort::updateOrCreate(['course_id' => $course->id, 'name' => 'Autumn Studio · 2026'], [
            'timezone' => 'Asia/Kolkata', 'capacity' => 24,
            'starts_on' => CarbonImmutable::now()->subWeek()->toDateString(),
            'ends_on' => CarbonImmutable::now()->addWeeks(3)->toDateString(),
            'status' => 'active',
        ]);
        $cohort->teachers()->syncWithoutDetaching([$teacher->id]);
        Enrollment::updateOrCreate(['user_id' => $student->id, 'course_id' => $course->id], [
            'cohort_id' => $cohort->id, 'status' => 'active', 'payment_status' => 'paid', 'enrolled_at' => now()->subWeek(),
        ]);

        if ($lessons->isNotEmpty()) {
            DB::table('lesson_progress')->updateOrInsert(
                ['user_id' => $student->id, 'lesson_id' => $lessons->first()->id],
                ['watched_seconds' => 480, 'completed_at' => now()->subDay(), 'created_at' => now()->subDay(), 'updated_at' => now()],
            );
        }

        LiveSession::updateOrCreate(['cohort_id' => $cohort->id, 'title' => 'Studio kickoff: find the signal'], [
            'lesson_id' => $lessons->first()?->id,
            'teacher_id' => $teacher->id,
            'description' => 'Bring one product experience you would like to make easier. We will turn observations into a first problem frame together.',
            'starts_at' => CarbonImmutable::now()->subDays(4)->setTime(18, 30),
            'duration_minutes' => 75,
            'provider' => 'Online classroom',
            'recording_url' => 'https://example.com/replays/studio-kickoff',
            'status' => 'completed',
        ]);
        LiveSession::updateOrCreate(['cohort_id' => $cohort->id, 'title' => 'From insight to first prototype'], [
            'lesson_id' => $lessons->last()?->id,
            'teacher_id' => $teacher->id,
            'description' => 'A guided working session to choose a direction, map the core flow, and get feedback from your cohort.',
            'starts_at' => CarbonImmutable::now()->addDays(2)->setTime(18, 30),
            'duration_minutes' => 90,
            'provider' => 'Online classroom',
            'status' => 'scheduled',
        ]);

        DB::table('assignments')->updateOrInsert(
            ['course_id' => $course->id, 'title' => 'Share your first problem frame'],
            ['lesson_id' => $lessons->get(1)?->id, 'instructions' => 'Describe the person, the moment, and the need you want to improve. Bring your draft to the next live studio.', 'due_at' => now()->addDays(5), 'max_points' => 100, 'created_at' => now(), 'updated_at' => now()],
        );

        $quizId = DB::table('quizzes')->where('course_id', $course->id)->where('title', 'Problem framing: a quick check')->value('id');
        $quizData = [
            'lesson_id' => $lessons->get(1)?->id,
            'pass_percent' => 70,
            'time_limit_minutes' => null,
            'attempt_limit' => 3,
            'published' => true,
            'updated_at' => now(),
        ];
        if ($quizId) {
            DB::table('quizzes')->where('id', $quizId)->update($quizData);
        } else {
            $quizId = DB::table('quizzes')->insertGetId($quizData + [
                'course_id' => $course->id,
                'title' => 'Problem framing: a quick check',
                'created_at' => now(),
            ]);
        }

        $quizQuestions = [
            ['prompt' => 'What is the most useful first step when framing a product problem?', 'points' => 1, 'options' => [
                ['body' => 'Start by listing every feature the team could build.', 'correct' => false],
                ['body' => 'Understand a person, their context, and the need they have.', 'correct' => true],
                ['body' => 'Choose the visual style before speaking with anyone.', 'correct' => false],
            ]],
            ['prompt' => 'A strong problem statement should be grounded in…', 'points' => 1, 'options' => [
                ['body' => 'Evidence and observations from real people.', 'correct' => true],
                ['body' => 'The solution the team already prefers.', 'correct' => false],
                ['body' => 'A long list of unrelated requirements.', 'correct' => false],
            ]],
            ['prompt' => 'Why is it useful to keep the problem separate from a proposed solution?', 'points' => 1, 'options' => [
                ['body' => 'It lets the team explore more than one useful response.', 'correct' => true],
                ['body' => 'It removes the need to validate the idea.', 'correct' => false],
                ['body' => 'It guarantees the first solution will be faster to ship.', 'correct' => false],
            ]],
        ];
        foreach ($quizQuestions as $position => $questionData) {
            $questionId = DB::table('quiz_questions')->where('quiz_id', $quizId)->where('prompt', $questionData['prompt'])->value('id');
            $attributes = ['points' => $questionData['points'], 'position' => $position + 1, 'type' => 'single_choice', 'updated_at' => now()];
            if ($questionId) {
                DB::table('quiz_questions')->where('id', $questionId)->update($attributes);
            } else {
                $questionId = DB::table('quiz_questions')->insertGetId($attributes + [
                    'quiz_id' => $quizId,
                    'prompt' => $questionData['prompt'],
                    'created_at' => now(),
                ]);
            }
            foreach ($questionData['options'] as $optionPosition => $optionData) {
                DB::table('quiz_options')->updateOrInsert(
                    ['quiz_question_id' => $questionId, 'body' => $optionData['body']],
                    ['is_correct' => $optionData['correct'], 'position' => $optionPosition + 1],
                );
            }
        }
    }
}
