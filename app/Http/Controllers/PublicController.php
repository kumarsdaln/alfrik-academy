<?php

namespace App\Http\Controllers;

use App\Data\PublicCatalog;
use App\Data\PublicPageDefaults;
use App\Models\LiveSession;
use App\Models\Course;
use App\Models\Payment;
use App\Models\LearnerStory;
use App\Models\Insight;
use App\Models\JobPost;
use App\Models\PublicPageContent;
use App\Models\WebinarEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    public function home(): Response
    {
        $catalog = collect(PublicCatalog::courses());
        $featured = collect(['product-design-sprint', 'laravel-api-engineering', 'brand-voice-content-strategy'])
            ->map(fn ($slug) => $catalog->firstWhere('slug', $slug))
            ->filter()
            ->values();

        if ($featured->count() < 3) {
            $featured = $catalog->take(3)->values();
        }

        $session = Schema::hasTable('live_sessions')
            ? LiveSession::query()->with(['cohort.course', 'teacher'])
                ->where('status', 'scheduled')->where('starts_at', '>=', now())
                ->orderBy('starts_at')->first()
            : null;
        $timezone = $session?->cohort?->timezone ?? 'Asia/Kolkata';
        $upcomingEvents = Schema::hasTable('webinar_events')
            ? WebinarEvent::query()->where('status', 'published')->where('published_at', '<=', now())->where('starts_at', '>=', now())
                ->orderBy('starts_at')->limit(3)->get(['id', 'title', 'slug', 'event_type', 'summary', 'cover_image', 'starts_at', 'timezone', 'duration_minutes', 'host_name', 'host_title'])
            : collect();
        $insights = Schema::hasTable('insights')
            ? Insight::query()->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())
                ->latest('published_at')->limit(3)->get(['id', 'title', 'slug', 'type', 'category', 'excerpt', 'cover_image', 'reading_minutes', 'published_at'])
            : collect();
        $surveys = Schema::hasTable('insights')
            ? Insight::query()->where('type', 'survey')->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())
                ->latest('published_at')->limit(1)->get(['id', 'title', 'slug', 'category', 'excerpt', 'cover_image', 'survey_url', 'reading_minutes', 'published_at'])
            : collect();
        $reports = Schema::hasTable('insights')
            ? Insight::query()->where('type', 'report')->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())
                ->latest('published_at')->limit(1)->get(['id', 'title', 'slug', 'category', 'excerpt', 'cover_image', 'reading_minutes', 'published_at'])
            : collect();
        $insightTopics = Schema::hasTable('insights')
            ? Insight::query()->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())
                ->whereNotNull('category')->where('category', '!=', '')
                ->selectRaw('category, count(*) as stories_count')->groupBy('category')
                ->orderByDesc('stories_count')->orderBy('category')->limit(6)->get()
            : collect();
        $opportunities = Schema::hasTable('job_posts')
            ? JobPost::query()->where('status', 'published')->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>=', now()))
                ->latest('published_at')->limit(3)->get(['id', 'title', 'slug', 'company', 'location', 'workplace_type', 'employment_type', 'summary', 'salary_range', 'published_at'])
            : collect();

        return Inertia::render('Welcome', [
            'courses' => $featured,
            'stats' => [
                'programs' => $catalog->count(),
                'mentors' => $catalog->pluck('mentor')->unique()->count(),
                'cohortSize' => '18–20',
            ],
            'nextSession' => $session ? [
                'title' => $session->title,
                'course' => $session->cohort?->course?->title ?? 'Live cohort class',
                'courseSlug' => $session->cohort?->course?->slug,
                'mentor' => $session->teacher?->name ?? 'Your mentor',
                'date' => $session->starts_at->timezone($timezone)->format('D, M j'),
                'time' => $session->starts_at->timezone($timezone)->format('g:i A T'),
            ] : null,
            'mentors' => PublicCatalog::mentors(),
            'story' => PublicCatalog::stories()[0],
            'insights' => $insights,
            'surveys' => $surveys,
            'reports' => $reports,
            'insightTopics' => $insightTopics,
            'opportunities' => $opportunities,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

    public function courses(Request $request): Response
    {
        $courses = collect(PublicCatalog::courses());
        $search = trim((string) $request->query('q', ''));
        $category = (string) $request->query('category', 'all');

        if ($search !== '') {
            $courses = $courses->filter(fn (array $course) => str_contains(strtolower($course['title'].' '.$course['category'].' '.$course['mentor']), strtolower($search)));
        }

        if ($category !== 'all') {
            $courses = $courses->where('category_slug', $category);
        }

        return Inertia::render('Courses/Index', [
            'courses' => $courses->values(),
            'categories' => collect(PublicCatalog::courses())->pluck('category', 'category_slug')->unique()->map(fn ($label, $slug) => ['slug' => $slug, 'label' => $label])->values(),
            'filters' => ['q' => $search, 'category' => $category],
        ]);
    }

    public function course(string $slug): Response
    {
        $catalog = collect(PublicCatalog::courses());
        $course = $catalog->firstWhere('slug', $slug);
        abort_if($course === null, 404);

        $databaseCourse = Course::query()->where('slug', $slug)->where('status', 'published')->first();
        $purchase = [
            'available' => false,
            'student' => false,
            'paymentsConfigured' => (bool) config('cashier.secret'),
            'priceMinor' => null,
            'currency' => 'USD',
            'cohorts' => [],
            'alreadyEnrolled' => false,
        ];
        if ($databaseCourse) {
            $availableCohorts = $databaseCourse->cohorts()->where('status', 'open')->withCount([
                'enrollments as active_enrollments_count' => fn ($query) => $query->where('status', 'active'),
            ])->get()->filter(function ($cohort) {
                if ($cohort->capacity === null) return true;
                $pending = Payment::query()->where('cohort_id', $cohort->id)->where('status', 'pending')->where('expires_at', '>', now())->count();
                return $cohort->active_enrollments_count + $pending < $cohort->capacity;
            })->map(fn ($cohort) => [
                'id' => $cohort->id,
                'name' => $cohort->name,
                'startsOn' => $cohort->starts_on?->toDateString(),
                'timezone' => $cohort->timezone,
            ])->values();

            $purchase = [
                'available' => $databaseCourse->price_minor > 0,
                'student' => request()->user()?->hasRole('student') ?? false,
                'paymentsConfigured' => (bool) config('cashier.secret'),
                'priceMinor' => $databaseCourse->price_minor,
                'currency' => strtoupper($databaseCourse->currency),
                'cohorts' => $availableCohorts,
                'alreadyEnrolled' => request()->user()?->enrollments()->where('course_id', $databaseCourse->id)->where('status', 'active')->exists() ?? false,
            ];
            $course['price'] = number_format($databaseCourse->price_minor / 100, 2, '.', '');
            $course['currency'] = strtoupper($databaseCourse->currency);
        }

        return Inertia::render('Courses/Show', [
            'course' => $course,
            'purchase' => $purchase,
            'related' => $catalog->where('slug', '!=', $slug)->take(2)->values(),
        ]);
    }

    public function howItWorks(): Response
    {
        return Inertia::render('HowItWorks', ['content' => $this->pageContent('how')]);
    }

    public function mentors(): Response
    {
        return Inertia::render('Mentors/Index', ['mentors' => PublicCatalog::mentors()]);
    }

    public function mentor(string $slug): Response
    {
        $mentor = collect(PublicCatalog::mentors())->firstWhere('slug', $slug);
        abort_if($mentor === null, 404);
        $courses = collect(PublicCatalog::courses())->whereIn('slug', $mentor['courses'])->values();

        return Inertia::render('Mentors/Show', ['mentor' => $mentor, 'courses' => $courses]);
    }

    public function stories(): Response
    {
        return Inertia::render('Stories/Index', ['stories' => $this->storiesWithImages()]);
    }

    public function story(string $slug): Response
    {
        $story = collect($this->storiesWithImages())->firstWhere('slug', $slug);
        abort_if($story === null, 404);

        return Inertia::render('Stories/Show', ['story' => $story]);
    }

    private function storiesWithImages(): array
    {
        $courseImages = collect(PublicCatalog::courses())->keyBy('slug');
        $stories = collect(PublicCatalog::stories());
        if (! Schema::hasTable('learner_stories')) {
            return $stories->map(function (array $story) use ($courseImages) {
                $story['image'] = $courseImages->get($story['course_slug'])['image'] ?? null;

                return $story;
            })->all();
        }

        $staticBySlug = $stories->keyBy('slug');
        $databaseStories = LearnerStory::query()->where('status', 'published')->where('published_at', '<=', now())->with('course')->latest('published_at')->get()->map(function (LearnerStory $entry) use ($courseImages, $staticBySlug) {
            $static = $staticBySlug->get($entry->slug, []);
            $courseSlug = $entry->course?->slug ?? ($static['course_slug'] ?? null);
            $courseTitle = $entry->course?->title ?? ($static['course'] ?? 'Learning at Alfrik');

            return array_replace($static, [
                'slug' => $entry->slug, 'name' => $entry->name,
                'initials' => collect(explode(' ', $entry->name))->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode(''),
                'role' => $entry->role, 'cohort' => $entry->cohort, 'outcome' => $entry->outcome,
                'quote' => $entry->quote, 'story' => $entry->story, 'color' => $entry->color,
                'course' => $courseTitle, 'course_slug' => $courseSlug, 'mark' => $static['mark'] ?? '✦',
                'image' => $courseImages->get($courseSlug)['image'] ?? ($static['image'] ?? '/images/learning/live-class.png'),
            ]);
        });
        $databaseBySlug = $databaseStories->keyBy('slug');

        return $stories->map(function (array $story) use ($courseImages, $databaseBySlug) {
            $story['image'] = $courseImages->get($story['course_slug'])['image'] ?? null;

            return array_replace($story, $databaseBySlug->get($story['slug'], []));
        })->concat($databaseStories->reject(fn (array $story) => $staticBySlug->has($story['slug'])))->values()->all();
    }

    public function about(): Response
    {
        return Inertia::render('About', ['content' => $this->pageContent('about')]);
    }

    public function faq(): Response
    {
        return Inertia::render('Faq', ['content' => $this->pageContent('faq')]);
    }

    public function contact(): Response
    {
        return Inertia::render('Contact');
    }

    private function pageContent(string $key): array
    {
        $defaults = PublicPageDefaults::all()[$key];

        $stored = Schema::hasTable('public_page_contents') ? PublicPageContent::query()->where('page_key', $key)->first()?->content : null;

        return array_replace_recursive($defaults, $stored ?? []);
    }
}
