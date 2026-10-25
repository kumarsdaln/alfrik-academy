<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LiveSession;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\NotificationDemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PaginationAndNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_assignment_filter_is_paginated_on_the_database_and_keeps_its_query(): void
    {
        $student = $this->student();
        $course = $this->course('Design Sprint');
        Enrollment::create(['user_id' => $student->id, 'course_id' => $course->id, 'status' => 'active']);

        for ($i = 1; $i <= 16; $i++) {
            DB::table('assignments')->insert([
                'course_id' => $course->id,
                'title' => "Assignment {$i}",
                'instructions' => 'Write a concise project response.',
                'due_at' => now()->addDays($i),
                'max_points' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->actingAs($student)->get('/learn/assignments?status=all&page=2')
            ->assertOk()->assertInertia(fn (Assert $page) => $page
                ->component('Learning/Assignments')
                ->where('activeFilter', 'all')
                ->where('assignments.current_page', 2)
                ->where('assignments.per_page', 15)
                ->where('assignments.total', 16)
                ->has('assignments.data', 1)
                ->where('assignments.data.0.title', 'Assignment 16')
                ->where('assignments.next_page_url', null)
            );
    }

    public function test_class_schedule_uses_stable_offset_pages(): void
    {
        $student = $this->student();
        $course = $this->course('Research Lab');
        $cohort = Cohort::create(['course_id' => $course->id, 'name' => 'Autumn cohort', 'timezone' => 'UTC', 'status' => 'open']);
        Enrollment::create(['user_id' => $student->id, 'course_id' => $course->id, 'cohort_id' => $cohort->id, 'status' => 'active']);

        for ($i = 1; $i <= 16; $i++) {
            LiveSession::create([
                'cohort_id' => $cohort->id,
                'title' => "Studio {$i}",
                'starts_at' => now()->addDays($i),
                'duration_minutes' => 60,
                'status' => 'scheduled',
            ]);
        }

        $this->actingAs($student)->get('/learn/schedule?view=upcoming&page=2')
            ->assertOk()->assertInertia(fn (Assert $page) => $page
                ->component('Learning/Schedule')
                ->where('activeView', 'upcoming')
                ->where('sessions.current_page', 2)
                ->where('sessions.total', 16)
                ->has('sessions.data', 1)
                ->where('sessions.data.0.title', 'Studio 16')
            );
    }

    public function test_enrolled_courses_are_batched_and_paginated(): void
    {
        $student = $this->student();
        for ($i = 1; $i <= 13; $i++) {
            $course = $this->course("Course {$i}");
            Enrollment::create(['user_id' => $student->id, 'course_id' => $course->id, 'status' => 'active']);
        }

        $this->actingAs($student)->get('/learn/courses?page=2')
            ->assertOk()->assertInertia(fn (Assert $page) => $page
                ->component('Learning/Courses')
                ->where('courses.current_page', 2)
                ->where('courses.total', 13)
                ->has('courses.data', 1)
                ->where('courses.data.0.title', 'Course 1')
            );
    }

    public function test_public_events_return_a_cursor_paginated_infinite_scroll_feed(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('webinar_events')->insert([
                'title' => "Open workshop {$i}",
                'slug' => "open-workshop-{$i}",
                'summary' => 'A practical workshop for the community.',
                'description' => 'A longer description of this learning event.',
                'starts_at' => now()->addDays($i),
                'timezone' => 'UTC',
                'duration_minutes' => 60,
                'host_name' => 'Maya Chen',
                'event_type' => 'webinar',
                'price_minor' => 0,
                'currency' => 'usd',
                'status' => 'published',
                'published_at' => now()->subDay(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->get('/events')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Events/Index')
            ->where('upcomingCount', 10)
            ->has('upcoming.data', 9)
            ->has('upcoming.next_page_url')
        );
    }

    public function test_activity_feed_is_cursor_paginated_without_loading_a_full_history(): void
    {
        $student = $this->student();
        $course = $this->course('First Steps');
        Enrollment::create(['user_id' => $student->id, 'course_id' => $course->id, 'status' => 'active']);

        $this->actingAs($student)->get('/learn/activity')
            ->assertOk()->assertInertia(fn (Assert $page) => $page
                ->component('Learning/Activity')
                ->has('activity.data', 1)
                ->where('activity.data.0.title', 'Joined First Steps')
                ->where('activity.next_page_url', null)
            );
    }

    public function test_notification_filters_and_offsets_return_only_the_requested_page(): void
    {
        $student = $this->student();
        for ($i = 1; $i <= 27; $i++) {
            $id = sprintf('f2342c90-4dd8-4a9d-a001-%012d', $i);
            DB::table('notifications')->insert([
                'id' => $id,
                'type' => 'sample',
                'notifiable_type' => User::class,
                'notifiable_id' => $student->id,
                'data' => json_encode(['title' => "Update {$i}", 'body' => 'Sample update', 'url' => '/learn', 'category' => 'learning']),
                'read_at' => $i % 2 === 0 ? now() : null,
                'created_at' => now()->subMinutes($i),
                'updated_at' => now()->subMinutes($i),
            ]);
        }

        $this->actingAs($student)->get('/notifications?filter=read&page=2')
            ->assertOk()->assertInertia(fn (Assert $page) => $page
                ->component('Notifications/Index')
                ->where('activeFilter', 'read')
                ->where('counts.all', 27)
                ->where('counts.read', 13)
                ->has('notifications.data', 0)
            );

        $this->actingAs($student)->get('/notifications?filter=unread')
            ->assertOk()->assertInertia(fn (Assert $page) => $page
                ->where('counts.unread', 14)
                ->has('notifications.data', 14)
            );
    }

    public function test_local_notification_demo_seeder_is_repeatable_and_has_read_and_unread_examples(): void
    {
        $student = User::factory()->create(['email' => 'student@northstar.test']);
        $previousEnvironment = $this->app->environment();
        $this->app->detectEnvironment(fn () => 'local');

        $this->seed(NotificationDemoSeeder::class);
        $this->seed(NotificationDemoSeeder::class);

        $this->assertSame(4, $student->notifications()->count());
        $this->assertSame(2, $student->unreadNotifications()->count());
        $this->assertSame(2, $student->readNotifications()->count());

        $this->app->detectEnvironment(fn () => $previousEnvironment);
    }

    public function test_open_notification_accepts_legacy_same_site_urls_and_redirects_to_a_relative_path(): void
    {
        $student = $this->student();
        $id = (string) str()->uuid();
        $host = parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'localhost';
        DB::table('notifications')->insert([
            'id' => $id,
            'type' => 'sample',
            'notifiable_type' => User::class,
            'notifiable_id' => $student->id,
            'data' => json_encode(['title' => 'Schedule update', 'url' => "http://{$host}:8765/learn/schedule?view=upcoming"]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($student)->post("/notifications/{$id}/open")
            ->assertRedirect('/learn/schedule?view=upcoming');

        $this->assertNotNull($student->notifications()->findOrFail($id)->read_at);
    }

    public function test_open_notification_rejects_external_urls(): void
    {
        $student = $this->student();
        $id = (string) str()->uuid();
        DB::table('notifications')->insert([
            'id' => $id,
            'type' => 'sample',
            'notifiable_type' => User::class,
            'notifiable_id' => $student->id,
            'data' => json_encode(['title' => 'Unsafe link', 'url' => 'https://example.com/learn']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($student)->post("/notifications/{$id}/open")->assertNotFound();
    }
    private function student(): User
    {
        $role = Role::firstOrCreate(['name' => 'student'], ['label' => 'Student']);
        $student = User::factory()->create(['timezone' => 'UTC']);
        $student->roles()->attach($role);

        return $student;
    }

    private function course(string $title): Course
    {
        $category = Category::firstOrCreate(['slug' => 'testing'], ['name' => 'Testing', 'sort_order' => 1]);

        return Course::create([
            'category_id' => $category->id,
            'title' => $title,
            'slug' => str($title)->slug().'-'.str()->random(6),
            'status' => 'published',
        ]);
    }
}

