<?php

namespace Database\Seeders;

use App\Data\PublicCatalog;
use App\Models\Category;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\LiveSession;
use App\Models\Role;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PurchasableCatalogSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PublicCatalog::courses() as $entry) {
            $course = Course::query()->where('slug', $entry['slug'])->first();
            if ($course) {
                $cohort = $course->cohorts()->where('status', 'open')->orderBy('starts_on')->first();
                if ($cohort && ! $cohort->sessions()->exists()) {
                    $teacher = $course->mentors()->first();
                    $lessonIds = $course->modules()->with('lessons')->get()->flatMap->lessons->pluck('id')->all();
                    $this->seedLiveSessions($entry, $cohort, $teacher?->id, $lessonIds);
                }

                continue;
            }

            $category = Category::updateOrCreate(['slug' => $entry['category_slug']], [
                'name' => $entry['category'],
            ]);
            $mentorSlug = Str::slug($entry['mentor']);
            $mentor = User::firstOrCreate(['email' => $mentorSlug.'@northstar.test'], [
                'name' => $entry['mentor'],
                'password' => Hash::make(Str::random(48)),
                'timezone' => 'Asia/Kolkata',
                'bio' => $entry['mentor_title'],
            ]);
            $mentor->roles()->syncWithoutDetaching([Role::firstOrCreate(['name' => 'teacher'], ['label' => 'Teacher'])->id]);

            $course = Course::create([
                'category_id' => $category->id,
                'created_by' => $mentor->id,
                'title' => $entry['title'],
                'slug' => $entry['slug'],
                'subtitle' => $entry['summary'],
                'description' => $entry['description'],
                'level' => Str::slug($entry['level']),
                'duration_weeks' => $entry['weeks'],
                'price_minor' => (int) round(((float) $entry['price']) * 100),
                'currency' => 'USD',
                'status' => 'published',
                'cover_image' => $entry['image'],
                'published_at' => now(),
            ]);
            $course->mentors()->syncWithoutDetaching([$mentor->id => ['title' => $entry['mentor_title']]]);

            foreach ($entry['curriculum'] as $moduleIndex => $moduleData) {
                $module = CourseModule::create([
                    'course_id' => $course->id,
                    'title' => $moduleData['title'],
                    'description' => $moduleData['summary'],
                    'position' => $moduleIndex + 1,
                ]);

                foreach ($moduleData['lessons'] as $lessonIndex => $title) {
                    $module->lessons()->create([
                        'title' => $title,
                        'summary' => $moduleData['summary'],
                        'body' => $moduleData['summary'],
                        'type' => 'lesson',
                        'duration_seconds' => 900,
                        'is_preview' => false,
                        'position' => $lessonIndex + 1,
                    ]);
                }
            }

            $startsOn = CarbonImmutable::parse($entry['next_start'], 'Asia/Kolkata');
            $cohort = Cohort::create([
                'course_id' => $course->id,
                'name' => 'Live Studio · '.$startsOn->format('F Y'),
                'timezone' => 'Asia/Kolkata',
                'capacity' => (int) (preg_match('/\d+/', $entry['class_size'], $matches) ? $matches[0] : 18),
                'starts_on' => $startsOn->toDateString(),
                'ends_on' => $startsOn->addWeeks((int) $entry['weeks'])->toDateString(),
                'status' => 'open',
            ]);
            $cohort->teachers()->syncWithoutDetaching([$mentor->id]);
            $lessonIds = $course->modules()->with('lessons')->get()->flatMap->lessons->pluck('id')->all();
            $this->seedLiveSessions($entry, $cohort, $mentor->id, $lessonIds);
        }
    }

    private function seedLiveSessions(array $entry, Cohort $cohort, ?int $teacherId, array $lessonIds): void
    {
        $startsOn = $cohort->starts_on
            ? CarbonImmutable::parse($cohort->starts_on->toDateString(), $cohort->timezone)->startOfDay()
            : CarbonImmutable::now($cohort->timezone)->addWeek()->startOfWeek();
        $weekdays = [
            'monday' => CarbonImmutable::MONDAY,
            'tuesday' => CarbonImmutable::TUESDAY,
            'wednesday' => CarbonImmutable::WEDNESDAY,
            'thursday' => CarbonImmutable::THURSDAY,
            'friday' => CarbonImmutable::FRIDAY,
            'saturday' => CarbonImmutable::SATURDAY,
            'sunday' => CarbonImmutable::SUNDAY,
        ];
        preg_match_all('/\b(Mondays?|Tuesdays?|Wednesdays?|Thursdays?|Fridays?|Saturdays?|Sundays?)\b/i', $entry['schedule'], $matches);
        $scheduledDays = collect($matches[1])->map(fn ($day) => $weekdays[Str::lower(rtrim($day, 's'))] ?? null)->filter()->values();
        if ($scheduledDays->isEmpty()) {
            $scheduledDays = collect([$startsOn->dayOfWeekIso]);
        }

        $hour = 18;
        $minute = 30;
        if (preg_match('/(\d{1,2})(?::(\d{2}))?\s*(AM|PM)/i', $entry['schedule'], $time)) {
            $hour = (int) $time[1] % 12 + (strtoupper($time[3]) === 'PM' ? 12 : 0);
            $minute = (int) ($time[2] ?? 0);
        }

        $totalDays = max(1, (int) $entry['weeks'] * 7);
        $lessonCount = max(1, count($lessonIds));
        for ($offset = 0; $offset < $totalDays; $offset++) {
            $date = $startsOn->addDays($offset);
            if (! $scheduledDays->contains($date->dayOfWeekIso)) {
                continue;
            }

            $week = intdiv($offset, 7) + 1;
            $title = 'Week '.$week.' · Live cohort studio';
            if ($cohort->sessions()->where('title', $title)->exists()) {
                continue;
            }

            LiveSession::create([
                'cohort_id' => $cohort->id,
                'lesson_id' => $lessonIds[$offset % $lessonCount] ?? null,
                'teacher_id' => $teacherId,
                'title' => $title,
                'description' => $entry['summary'],
                'starts_at' => $date->setTime($hour, $minute),
                'duration_minutes' => 90,
                'provider' => 'Online classroom',
                'status' => 'scheduled',
            ]);
        }
    }
}
