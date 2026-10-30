<?php

namespace App\Http\Controllers\Stories;

use App\Data\PublicCatalog;
use App\Http\Controllers\Controller;
use App\Models\LearnerStory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use Inertia\Response;

class LearnerStoryController extends Controller
{
    /**
     * Display learner stories.
     */
    public function index(): Response
    {
        return Inertia::render('Stories/Index', [
            'stories' => $this->storiesWithImages(),
        ]);
    }

    /**
     * Display one learner story.
     */
    public function show(string $slug): Response
    {
        $story = collect($this->storiesWithImages())
            ->firstWhere('slug', $slug);

        abort_if($story === null, 404);

        return Inertia::render('Stories/Show', [
            'story' => $story,
        ]);
    }

    /**
     * Combine static catalog stories with published database stories.
     */
    private function storiesWithImages(): array
    {
        $courseImages = collect(PublicCatalog::courses())
            ->keyBy('slug');

        $stories = collect(PublicCatalog::stories());

        if (! Schema::hasTable('learner_stories')) {
            return $stories
                ->map(function (array $story) use ($courseImages) {
                    $story['image'] = $courseImages->get(
                        $story['course_slug'] ?? ''
                    )['image'] ?? null;

                    return $story;
                })
                ->all();
        }

        $staticBySlug = $stories->keyBy('slug');

        $databaseStories = LearnerStory::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with('course')
            ->latest('published_at')
            ->get()
            ->map(function (LearnerStory $entry) use (
                $courseImages,
                $staticBySlug
            ) {
                $static = $staticBySlug->get($entry->slug, []);

                $courseSlug = $entry->course?->slug
                    ?? ($static['course_slug'] ?? null);

                $courseTitle = $entry->course?->title
                    ?? ($static['course'] ?? 'Learning at Alfrik');

                $courseImage = $courseSlug !== null
                    ? ($courseImages->get($courseSlug)['image'] ?? null)
                    : null;

                return array_replace($static, [
                    'slug' => $entry->slug,
                    'name' => $entry->name,
                    'initials' => collect(explode(' ', $entry->name))
                        ->filter()
                        ->take(2)
                        ->map(fn ($part) => mb_strtoupper(
                            mb_substr($part, 0, 1)
                        ))
                        ->implode(''),
                    'role' => $entry->role,
                    'cohort' => $entry->cohort,
                    'outcome' => $entry->outcome,
                    'quote' => $entry->quote,
                    'story' => $entry->story,
                    'color' => $entry->color,
                    'course' => $courseTitle,
                    'course_slug' => $courseSlug,
                    'mark' => $static['mark'] ?? '✦',
                    'image' => $courseImage
                        ?? ($static['image'] ?? '/images/learning/live-class.png'),
                ]);
            });

        $databaseBySlug = $databaseStories->keyBy('slug');

        $mergedStaticStories = $stories->map(
            function (array $story) use ($courseImages, $databaseBySlug) {
                $courseSlug = $story['course_slug'] ?? '';

                $story['image'] = $courseImages->get(
                    $courseSlug
                )['image'] ?? null;

                return array_replace(
                    $story,
                    $databaseBySlug->get($story['slug'], [])
                );
            }
        );

        $newDatabaseStories = $databaseStories->reject(
            fn (array $story) => $staticBySlug->has($story['slug'])
        );

        return $mergedStaticStories
            ->concat($newDatabaseStories)
            ->values()
            ->all();
    }
}