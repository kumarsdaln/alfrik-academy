<?php

namespace Database\Seeders;

use App\Models\User;
use App\Notifications\PlatformNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        $student = User::query()->where('email', 'student@northstar.test')->first();
        if (! $student) {
            return;
        }

        $now = now();
        $samples = [
            ['id' => 'e2342c90-4dd8-4a9d-a001-000000000001', 'title' => 'Your next live class is coming up', 'body' => 'Product Design Sprint begins tomorrow at 6:30 PM. Bring your latest prototype for mentor feedback.', 'url' => route('learn.schedule', [], false), 'category' => 'session', 'minutes_ago' => 35, 'read' => false],
            ['id' => 'e2342c90-4dd8-4a9d-a001-000000000002', 'title' => 'Mentor feedback is ready', 'body' => 'Maya Chen reviewed your first problem frame. Open the assignment to read the feedback and next steps.', 'url' => route('learn.assignments.index', [], false), 'category' => 'assignment', 'minutes_ago' => 180, 'read' => false],
            ['id' => 'e2342c90-4dd8-4a9d-a001-000000000003', 'title' => 'New workshop added to the calendar', 'body' => 'A practical portfolio clinic is now open for registration. Explore the session details and reserve a seat.', 'url' => route('events.index', [], false), 'category' => 'event', 'minutes_ago' => 1440, 'read' => true],
            ['id' => 'e2342c90-4dd8-4a9d-a001-000000000004', 'title' => 'Welcome to your learning space', 'body' => 'Your courses, class schedule, assignments, and learning activity are ready whenever you are.', 'url' => route('learn', [], false), 'category' => 'learning', 'minutes_ago' => 4320, 'read' => true],
        ];

        foreach ($samples as $sample) {
            $createdAt = $now->copy()->subMinutes($sample['minutes_ago']);

            DB::table('notifications')->updateOrInsert(
                ['id' => $sample['id']],
                [
                    'type' => PlatformNotification::class,
                    'notifiable_type' => User::class,
                    'notifiable_id' => $student->getKey(),
                    'data' => json_encode([
                        'title' => $sample['title'],
                        'body' => $sample['body'],
                        'url' => $sample['url'],
                        'category' => $sample['category'],
                    ], JSON_THROW_ON_ERROR),
                    'read_at' => $sample['read'] ? $createdAt->copy()->addMinutes(10) : null,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ],
            );
        }
    }
}


