<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LiveSession;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\AdditionalCoursesSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoRosterSeeder;
use Database\Seeders\LiveLearningDemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class StudentLearningExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_only_the_students_active_learning_and_progress(): void
    {
        $studentRole = Role::create(['name' => 'student', 'label' => 'Student']);
        $student = User::factory()->create(['name' => 'Jordan Lee', 'timezone' => 'Asia/Kolkata']);
        $student->roles()->attach($studentRole);

        $teacher = User::factory()->create(['name' => 'Maya Chen']);
        $category = Category::create(['name' => 'Design', 'slug' => 'design', 'sort_order' => 1]);
        $course = Course::create([
            'category_id' => $category->id,
            'created_by' => $teacher->id,
            'title' => 'Product Design Sprint',
            'slug' => 'product-design-sprint',
            'status' => 'published',
        ]);
        $course->mentors()->attach($teacher->id, ['title' => 'Lead mentor']);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => 'Find the signal', 'position' => 1]);
        $completedLesson = Lesson::create(['course_module_id' => $module->id, 'title' => 'Start with people', 'position' => 1]);
        Lesson::create(['course_module_id' => $module->id, 'title' => 'Frame the problem', 'position' => 2]);
        DB::table('lesson_progress')->insert([
            'user_id' => $student->id,
            'lesson_id' => $completedLesson->id,
            'watched_seconds' => 180,
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $cohort = Cohort::create([
            'course_id' => $course->id,
            'name' => 'Autumn Studio',
            'timezone' => 'Asia/Kolkata',
            'status' => 'active',
        ]);
        Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'cohort_id' => $cohort->id,
            'status' => 'active',
            'payment_status' => 'paid',
        ]);
        LiveSession::create([
            'cohort_id' => $cohort->id,
            'teacher_id' => $teacher->id,
            'title' => 'Live studio',
            'starts_at' => now()->addDays(2),
            'duration_minutes' => 60,
            'status' => 'scheduled',
        ]);
        DB::table('assignments')->insert([
            'course_id' => $course->id,
            'title' => 'Share your problem frame',
            'instructions' => 'Describe one user need.',
            'due_at' => now()->addDays(4),
            'max_points' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($student)->get('/learn')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('StudentDashboard')
            ->where('student.firstName', 'Jordan')
            ->where('courses.0.title', 'Product Design Sprint')
            ->where('courses.0.progress', 50)
            ->where('courses.0.next', 'Frame the problem')
            ->where('courses.0.mentor', 'Maya Chen')
            ->where('sessions.0.title', 'Live studio')
            ->where('assignments.0.title', 'Share your problem frame')
        );
    }

    public function test_student_cannot_access_a_course_they_are_not_enrolled_in(): void
    {
        $role = Role::create(['name' => 'student', 'label' => 'Student']);
        $student = User::factory()->create();
        $student->roles()->attach($role);
        $category = Category::create(['name' => 'Design', 'slug' => 'design', 'sort_order' => 1]);
        $course = Course::create([
            'category_id' => $category->id,
            'title' => 'Private cohort',
            'slug' => 'private-cohort',
            'status' => 'published',
        ]);

        $this->actingAs($student)->get('/learn/courses/private-cohort')->assertForbidden();
    }

    public function test_demo_roster_seeder_is_repeatable_and_populates_realistic_student_activity(): void
    {
        $this->seed(DatabaseSeeder::class);
        $student = User::factory()->create([
            'name' => 'Alex Morgan',
            'email' => 'student@northstar.test',
            'timezone' => 'Asia/Kolkata',
        ]);
        $student->roles()->sync(Role::where('name', 'student')->pluck('id'));

        $this->seed(LiveLearningDemoSeeder::class);
        $this->seed(DemoRosterSeeder::class);
        $this->seed(AdditionalCoursesSeeder::class);
        $this->seed(AdditionalCoursesSeeder::class);
        $this->seed(DemoRosterSeeder::class);

        $jordan = User::where('email', 'jordan.lee@northstar.test')->firstOrFail();
        $course = Course::where('slug', 'product-design-sprint')->firstOrFail();
        $assignmentId = DB::table('assignments')->where('course_id', $course->id)->value('id');

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $jordan->id,
            'course_id' => $course->id,
            'status' => 'active',
        ]);
        $this->assertSame(1, DB::table('enrollments')->where('user_id', $jordan->id)->where('course_id', $course->id)->count());
        $this->assertSame(5, DB::table('lesson_progress')->where('user_id', $jordan->id)->count());
        $this->assertDatabaseHas('assignment_submissions', [
            'assignment_id' => $assignmentId,
            'user_id' => $jordan->id,
            'status' => 'graded',
            'score' => 88,
        ]);
        $this->assertSame(4, Course::where('status', 'published')->count());
        $this->assertSame(1, DB::table('live_sessions')->where('title', 'Live API code review')->count());
        $this->assertSame(1, DB::table('assignments')->where('title', 'Build a documented resource API')->count());

        $this->get('/')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('courses', 3)
            ->where('courses.0.slug', 'product-design-sprint')
            ->where('courses.1.slug', 'laravel-api-engineering')
            ->where('courses.2.slug', 'brand-voice-content-strategy')
            ->where('stats.programs', 6)
            ->where('nextSession.title', 'From insight to first prototype')
        );

        $this->get('/courses')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Courses/Index')
            ->has('courses', 6)
            ->where('courses.4.slug', 'design-research-field-lab')
        );
        $this->get('/courses/laravel-api-engineering')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Courses/Show')
            ->where('course.title', 'Laravel API Engineering')
            ->where('course.curriculum.0.title', 'Shape a dependable API')
            ->where('course.curriculum.0.lessons.0', 'Routes, resources, and response shapes')
        );
    }
}
