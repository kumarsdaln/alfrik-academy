<?php

namespace App\Http\Controllers;

use App\Data\PublicCatalog;
use App\Models\Course;
use App\Models\Insight;
use App\Models\JobPost;
use App\Models\LiveSession;
use App\Models\WebinarEvent;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $publishedCourses = Course::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        $mapCourse = static function (Course $course): array {
            $mentor = $course->mentors->first();

            return [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
                'subtitle' => $course->subtitle,
                'description' => $course->description,
                'category' => $course->category?->name ?? 'General',
                'category_slug' => $course->category?->slug ?? 'general',
                'mentor' => $mentor?->name ?? 'Your teaching team',
                'cover_image' => $course->cover_image,
                'level' => $course->level,
                'duration_weeks' => $course->duration_weeks,
                'price' => number_format($course->price_minor / 100, 2, '.', ''),
                'currency' => strtoupper($course->currency),
            ];
        };

        // Prefer explicitly featured courses.
        $featured = (clone $publishedCourses)
            ->with(['category', 'mentors'])
            ->where('featured', true)
            ->orderBy('title')
            ->limit(3)
            ->get();

        // If fewer than three courses are featured, fill the remaining
        // positions with other published courses without duplicating them.
        if ($featured->count() < 3) {
            $featuredIds = $featured->modelKeys();

            $additionalCourses = (clone $publishedCourses)
                ->with(['category', 'mentors'])
                ->when(
                    ! empty($featuredIds),
                    fn ($query) => $query->whereNotIn('id', $featuredIds)
                )
                ->orderBy('title')
                ->limit(3 - $featured->count())
                ->get();

            $featured = $featured->concat($additionalCourses);
        }

        $featured = $featured
            ->map($mapCourse)
            ->values();

        $session = LiveSession::query()
            ->with(['cohort.course', 'teacher'])
            ->where('status', 'scheduled')
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->first();

        $timezone = $session?->cohort?->timezone ?? 'Asia/Kolkata';

        $upcomingEvents = WebinarEvent::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->limit(3)
            ->get([
                'id',
                'title',
                'slug',
                'event_type',
                'summary',
                'cover_image',
                'starts_at',
                'timezone',
                'duration_minutes',
                'host_name',
                'host_title',
            ]);

        $publishedInsights = fn () => Insight::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        $insights = $publishedInsights()
            ->where(function ($query) {
                $query->whereNull('type')
                    ->orWhereNotIn('type', ['survey', 'report']);
            })
            ->latest('published_at')
            ->limit(3)
            ->get([
                'id',
                'title',
                'slug',
                'type',
                'category',
                'excerpt',
                'cover_image',
                'reading_minutes',
                'published_at',
            ]);

        $surveys = $publishedInsights()
            ->where('type', 'survey')
            ->latest('published_at')
            ->limit(1)
            ->get([
                'id',
                'title',
                'slug',
                'category',
                'excerpt',
                'cover_image',
                'reading_minutes',
                'published_at',
            ]);

        $reports = $publishedInsights()
            ->where('type', 'report')
            ->latest('published_at')
            ->limit(1)
            ->get([
                'id',
                'title',
                'slug',
                'category',
                'excerpt',
                'cover_image',
                'reading_minutes',
                'published_at',
            ]);

        $insightTopics = Insight::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, COUNT(*) AS stories_count')
            ->groupBy('category')
            ->orderByDesc('stories_count')
            ->orderBy('category')
            ->limit(6)
            ->get();

        $opportunities = JobPost::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->latest('published_at')
            ->limit(3)
            ->get([
                'id',
                'title',
                'slug',
                'company',
                'location',
                'workplace_type',
                'employment_type',
                'summary',
                'salary_range',
                'published_at',
            ]);

        $stats = [
            'programs' => (clone $publishedCourses)->count(),

            'mentors' => DB::table('course_mentors')
                ->join('courses', 'courses.id', '=', 'course_mentors.course_id')
                ->where('courses.status', 'published')
                ->whereNotNull('courses.published_at')
                ->where('courses.published_at', '<=', now())
                ->distinct()
                ->count('course_mentors.user_id'),

            'cohortSize' => '18–20',
        ];

        return Inertia::render('Welcome', [
            'courses' => $featured,
            'stats' => $stats,

            'nextSession' => $session ? [
                'title' => $session->title,
                'course' => $session->cohort?->course?->title
                    ?? 'Live cohort class',
                'courseSlug' => $session->cohort?->course?->slug,
                'mentor' => $session->teacher?->name ?? 'Your mentor',
                'date' => $session->starts_at
                    ->timezone($timezone)
                    ->format('D, M j'),
                'time' => $session->starts_at
                    ->timezone($timezone)
                    ->format('g:i A T'),
            ] : null,

            'mentors' => PublicCatalog::mentors(),
            'story' => PublicCatalog::stories()[0] ?? null,
            'insights' => $insights,
            'surveys' => $surveys,
            'reports' => $reports,
            'insightTopics' => $insightTopics,
            'opportunities' => $opportunities,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}