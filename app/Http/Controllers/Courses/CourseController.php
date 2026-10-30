<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    /**
     * Display published courses from the database.
     */
    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('q', ''));
        $category = (string) $request->query('category', 'all');

        $courses = Course::query()
            ->published()
            ->with([
                'category:id,name,slug',
                'mentors:id,name,avatar_path',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'ilike', "%{$search}%")
                        ->orWhere('subtitle', 'ilike', "%{$search}%")
                        ->orWhere('description', 'ilike', "%{$search}%");
                });
            })
            ->when($category !== 'all', function ($query) use ($category) {
                $query->whereHas('category', function ($query) use ($category) {
                    $query->where('slug', $category);
                });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->whereHas('courses', function ($query) {
                $query->where('status', 'published');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'slug'])
            ->map(fn ($item) => [
                'slug' => $item->slug,
                'label' => $item->name,
            ])
            ->values();

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'categories' => $categories,
            'filters' => [
                'q' => $search,
                'category' => $category,
            ],
        ]);
    }

    /**
     * Display one published course from the database.
     */
    public function show(Request $request, string $slug): Response
    {
        $course = Course::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'instructors'])
            ->firstOrFail();

        $purchase = [
            'available' => false,
            'student' => false,
            'paymentsConfigured' => (bool) config('cashier.secret'),
            'priceMinor' => null,
            'currency' => 'USD',
            'cohorts' => [],
            'alreadyEnrolled' => false,
        ];

        if ($course->price_minor !== null) {
            $availableCohorts = $course->cohorts()
                ->where('status', 'open')
                ->withCount([
                    'enrollments as active_enrollments_count' => fn ($query) =>
                        $query->where('status', 'active'),
                ])
                ->get()
                ->filter(function ($cohort) {
                    if ($cohort->capacity === null) {
                        return true;
                    }

                    $pendingPayments = Payment::query()
                        ->where('cohort_id', $cohort->id)
                        ->where('status', 'pending')
                        ->where('expires_at', '>', now())
                        ->count();

                    return (
                        $cohort->active_enrollments_count + $pendingPayments
                    ) < $cohort->capacity;
                })
                ->map(fn ($cohort) => [
                    'id' => $cohort->id,
                    'name' => $cohort->name,
                    'startsOn' => $cohort->starts_on?->toDateString(),
                    'timezone' => $cohort->timezone,
                ])
                ->values();

            $user = $request->user();

            $purchase = [
                'available' => $course->price_minor > 0,
                'student' => $user?->hasRole('student') ?? false,
                'paymentsConfigured' => (bool) config('cashier.secret'),
                'priceMinor' => $course->price_minor,
                'currency' => strtoupper($course->currency),
                'cohorts' => $availableCohorts,
                'alreadyEnrolled' => $user
                    ? $user->enrollments()
                        ->where('course_id', $course->id)
                        ->where('status', 'active')
                        ->exists()
                    : false,
            ];
        }

        $related = Course::query()
            ->where('status', 'published')
            ->where('id', '!=', $course->id)
            ->when(
                $course->category_id,
                fn ($query) => $query->where(
                    'category_id',
                    $course->category_id
                )
            )
            ->latest('published_at')
            ->limit(2)
            ->get();

        return Inertia::render('Courses/Show', [
            'course' => $course,
            'purchase' => $purchase,
            'related' => $related,
        ]);
    }
}