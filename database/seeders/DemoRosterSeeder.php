<?php

namespace Database\Seeders;

use App\Models\Cohort;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoRosterSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Jordan Lee', 'email' => 'jordan.lee@northstar.test', 'role' => 'student'],
            ['name' => 'Priya Shah', 'email' => 'priya.shah@northstar.test', 'role' => 'student'],
            ['name' => 'Samira Patel', 'email' => 'samira.patel@northstar.test', 'role' => 'student'],
            ['name' => 'Ethan Brooks', 'email' => 'ethan@northstar.test', 'role' => 'teacher'],
            ['name' => 'Olivia Park', 'email' => 'olivia@northstar.test', 'role' => 'social_manager'],
        ];

        $course = Course::where('slug', 'product-design-sprint')->first();
        $cohort = $course ? Cohort::where('course_id', $course->id)->where('name', 'Autumn Studio · 2026')->first() : null;
        $assignment = $course ? DB::table('assignments')->where('course_id', $course->id)->orderBy('id')->first() : null;
        $lessonIds = $course
            ? DB::table('lessons')
                ->join('course_modules', 'course_modules.id', '=', 'lessons.course_module_id')
                ->where('course_modules.course_id', $course->id)
                ->orderBy('course_modules.position')->orderBy('lessons.position')
                ->pluck('lessons.id')
            : collect();
        $grader = User::firstOrCreate(['email' => 'ethan@northstar.test'], [
            'name' => 'Ethan Brooks', 'password' => 'NorthstarDemo!26', 'timezone' => 'Asia/Kolkata',
        ]);
        $graderId = $grader->id;

        foreach ($accounts as $account) {
            $user = User::firstOrCreate(['email' => $account['email']], [
                'name' => $account['name'],
                'password' => 'NorthstarDemo!26',
                'timezone' => 'Asia/Kolkata',
            ]);
            if (! $user->hasVerifiedEmail()) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }

            $role = Role::where('name', $account['role'])->firstOrFail();
            $user->roles()->sync([$role->id]);

            if ($account['role'] === 'student' && $course && $cohort) {
                Enrollment::firstOrCreate(
                    ['user_id' => $user->id, 'course_id' => $course->id],
                    [
                        'cohort_id' => $cohort->id,
                        'status' => 'active',
                        'payment_status' => 'paid',
                        'enrolled_at' => now(),
                    ],
                );

                $completedLessons = match ($account['email']) {
                    'jordan.lee@northstar.test' => 2,
                    'priya.shah@northstar.test' => 1,
                    default => 0,
                };

                foreach ($lessonIds->take($completedLessons) as $lessonId) {
                    DB::table('lesson_progress')->updateOrInsert(
                        ['user_id' => $user->id, 'lesson_id' => $lessonId],
                        ['watched_seconds' => 600, 'completed_at' => now()->subDay(), 'created_at' => now()->subDay(), 'updated_at' => now()],
                    );
                }

                if ($assignment && $account['email'] !== 'samira.patel@northstar.test') {
                    $isGraded = $account['email'] === 'jordan.lee@northstar.test';
                    DB::table('assignment_submissions')->updateOrInsert(
                        ['assignment_id' => $assignment->id, 'user_id' => $user->id],
                        [
                            'response' => $isGraded
                                ? 'I focused on the moment people decide whether a product feels trustworthy. My first opportunity is to make the next action clearer.'
                                : 'My first draft describes the person, the moment, and one need to explore further with the cohort.',
                            'status' => $isGraded ? 'graded' : 'submitted',
                            'score' => $isGraded ? 88 : null,
                            'feedback' => $isGraded ? 'Clear observation and a focused opportunity. Keep testing the wording with learners.' : null,
                            'graded_by' => $isGraded ? $graderId : null,
                            'submitted_at' => now()->subDay(),
                            'graded_at' => $isGraded ? now() : null,
                            'created_at' => now()->subDay(),
                            'updated_at' => now(),
                        ],
                    );
                }
            }
        }
    }
}
