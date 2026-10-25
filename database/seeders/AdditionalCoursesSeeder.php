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

class AdditionalCoursesSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'category' => ['name' => 'Design', 'slug' => 'design', 'sort_order' => 1],
                'mentor_email' => 'maya@northstar.test',
                'mentor' => ['name' => 'Maya Chen', 'title' => 'Product design lead · ex-Figma'],
                'slug' => 'design-research-field-lab',
                'title' => 'Design Research Field Lab',
                'subtitle' => 'Learn to ask better questions and turn what you hear into useful product direction.',
                'description' => 'A live, small-cohort research lab for people who want to understand customers beyond assumptions. Practice interview planning, facilitation, synthesis, and sharing evidence with a team.',
                'level' => 'beginner', 'duration_weeks' => 6, 'price_minor' => 17900,
                'cover_image' => '/images/learning/product-design.png',
                'modules' => [
                    ['title' => 'Listen with intention', 'description' => 'Prepare research that gives people room to tell the real story.', 'lessons' => ['Choose a research question', 'Write an interview guide', 'Practice a thoughtful interview']],
                    ['title' => 'Find the useful signal', 'description' => 'Turn notes into patterns, opportunities, and a clear readout.', 'lessons' => ['Make sense of field notes', 'Spot patterns without jumping to solutions', 'Share a research readout']],
                ],
                'assignment' => 'Interview guide and research plan',
                'assignment_instructions' => 'Choose one product question, write a short interview guide, and explain who you need to hear from and why.',
                'session' => 'Live interview practice studio',
                'session_description' => 'Practice open questions in pairs and get live mentor feedback on your interview guide.',
            ],
            [
                'category' => ['name' => 'Development', 'slug' => 'development', 'sort_order' => 2],
                'mentor_email' => 'ethan@northstar.test',
                'mentor' => ['name' => 'Ethan Brooks', 'title' => 'Staff engineer · ex-Stripe'],
                'slug' => 'laravel-api-engineering',
                'title' => 'Laravel API Engineering',
                'subtitle' => 'Build reliable APIs with Laravel, PostgreSQL, and a team that can help you get unstuck.',
                'description' => 'Build an API from its first route to a production-ready service. In live code reviews, you will practice validation, authentication, database design, queues, and clear API documentation.',
                'level' => 'intermediate', 'duration_weeks' => 8, 'price_minor' => 22900,
                'cover_image' => '/images/learning/web-development.png',
                'modules' => [
                    ['title' => 'Shape a dependable API', 'description' => 'Design clear contracts and model data with intention.', 'lessons' => ['Routes, resources, and response shapes', 'Validation and useful errors', 'PostgreSQL data modeling']],
                    ['title' => 'Make it production-ready', 'description' => 'Protect, test, and operate the service you have built.', 'lessons' => ['Authentication and authorization', 'Queues, caching, and background work', 'Testing and API documentation']],
                ],
                'assignment' => 'Build a documented resource API',
                'assignment_instructions' => 'Create a small Laravel API resource with validation, authorization, and a concise example request and response.',
                'session' => 'Live API code review',
                'session_description' => 'Bring one endpoint to the studio. We will review its contract, validation, and edge cases together.',
            ],
            [
                'category' => ['name' => 'Business', 'slug' => 'business', 'sort_order' => 3],
                'mentor_email' => 'olivia@northstar.test',
                'mentor' => ['name' => 'Olivia Park', 'title' => 'Founder · Good Things Studio'],
                'slug' => 'brand-voice-content-strategy',
                'title' => 'Brand Voice & Content Strategy',
                'subtitle' => 'Build a practical voice and content system that sounds unmistakably like your brand.',
                'description' => 'Find the language behind a distinctive brand and turn it into a useful content plan. Through live writing rooms and critique, develop voice principles, message themes, and a repeatable editorial rhythm.',
                'level' => 'beginner', 'duration_weeks' => 6, 'price_minor' => 16900,
                'cover_image' => '/images/learning/brand-strategy.png',
                'modules' => [
                    ['title' => 'Find your point of view', 'description' => 'Ground the brand voice in people, purpose, and a clear position.', 'lessons' => ['Collect the words customers use', 'Define voice principles', 'Write your message pillars']],
                    ['title' => 'Turn voice into a system', 'description' => 'Create flexible guidance and a content plan your team can use.', 'lessons' => ['Build a voice guide', 'Plan useful content themes', 'Edit together in a live writing room']],
                ],
                'assignment' => 'First draft of your voice guide',
                'assignment_instructions' => 'Write three voice principles, show how each sounds in practice, and bring one piece of copy for a live critique.',
                'session' => 'Live brand voice writing room',
                'session_description' => 'Bring a draft and a real audience question. We will make the writing clearer and more recognizably yours.',
            ],
        ];

        foreach ($courses as $index => $data) {
            $category = Category::updateOrCreate(['slug' => $data['category']['slug']], $data['category']);
            $mentor = User::firstOrCreate(['email' => $data['mentor_email']], [
                'name' => $data['mentor']['name'],
                'password' => 'NorthstarDemo!26',
                'timezone' => 'Asia/Kolkata',
                'bio' => $data['mentor']['title'],
            ]);
            $mentor->roles()->syncWithoutDetaching(Role::where('name', 'teacher')->pluck('id'));

            $course = Course::updateOrCreate(['slug' => $data['slug']], [
                'category_id' => $category->id,
                'created_by' => $mentor->id,
                'title' => $data['title'],
                'subtitle' => $data['subtitle'],
                'description' => $data['description'],
                'level' => $data['level'],
                'duration_weeks' => $data['duration_weeks'],
                'price_minor' => $data['price_minor'],
                'currency' => 'USD',
                'status' => 'published',
                'cover_image' => $data['cover_image'],
                'published_at' => now(),
            ]);
            $course->mentors()->syncWithoutDetaching([$mentor->id => ['title' => $data['mentor']['title']]]);

            $lessons = collect();
            foreach ($data['modules'] as $moduleIndex => $moduleData) {
                $module = CourseModule::updateOrCreate(
                    ['course_id' => $course->id, 'position' => $moduleIndex + 1],
                    ['title' => $moduleData['title'], 'description' => $moduleData['description']],
                );

                foreach ($moduleData['lessons'] as $lessonIndex => $title) {
                    $lessons->push($module->lessons()->updateOrCreate(
                        ['position' => $lessonIndex + 1],
                        [
                            'title' => $title,
                            'summary' => $moduleData['description'],
                            'body' => $moduleData['description'],
                            'type' => 'lesson',
                            'duration_seconds' => 600,
                            'is_preview' => false,
                        ],
                    ));
                }
            }

            $cohort = Cohort::updateOrCreate(['course_id' => $course->id, 'name' => 'Live Studio · 2026'], [
                'timezone' => 'Asia/Kolkata', 'capacity' => 18,
                'starts_on' => CarbonImmutable::now()->addWeek()->toDateString(),
                'ends_on' => CarbonImmutable::now()->addWeeks($data['duration_weeks'] + 1)->toDateString(),
                'status' => 'open',
            ]);
            $cohort->teachers()->syncWithoutDetaching([$mentor->id]);

            LiveSession::updateOrCreate(['cohort_id' => $cohort->id, 'title' => $data['session']], [
                'lesson_id' => $lessons->first()?->id,
                'teacher_id' => $mentor->id,
                'description' => $data['session_description'],
                'starts_at' => CarbonImmutable::now()->addDays(2 + ($index * 2))->setTime(18, 30),
                'duration_minutes' => 90,
                'provider' => 'Online classroom',
                'status' => 'scheduled',
            ]);

            DB::table('assignments')->updateOrInsert(
                ['course_id' => $course->id, 'title' => $data['assignment']],
                [
                    'lesson_id' => $lessons->get(1)?->id,
                    'instructions' => $data['assignment_instructions'],
                    'due_at' => now()->addDays(7 + $index),
                    'max_points' => 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );

            $students = User::whereHas('roles', fn ($query) => $query->where('name', 'student'))->get();
            foreach ($students as $student) {
                Enrollment::updateOrCreate(['user_id' => $student->id, 'course_id' => $course->id], [
                    'cohort_id' => $cohort->id,
                    'status' => 'active',
                    'payment_status' => 'paid',
                    'enrolled_at' => now(),
                ]);

                if ($student->email === 'jordan.lee@northstar.test' && $lessons->isNotEmpty()) {
                    DB::table('lesson_progress')->updateOrInsert(
                        ['user_id' => $student->id, 'lesson_id' => $lessons->first()->id],
                        ['watched_seconds' => 600, 'completed_at' => now()->subDay(), 'created_at' => now()->subDay(), 'updated_at' => now()],
                    );
                }
            }

        }
    }
}
