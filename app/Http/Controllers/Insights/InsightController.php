<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;
use App\Models\Insight;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InsightController extends Controller
{
    public function index(Request $request): Response
    {
        $query = $this->publishedInsights();

        if ($type = $request->string('type')->trim()->toString()) {
            $query->where('type', $type);
        }

        if ($category = $request->string('category')->trim()->toString()) {
            $query->where('category', $category);
        }

        if ($search = $request->string('q')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'ilike', "%{$search}%")
                    ->orWhere('excerpt', 'ilike', "%{$search}%")
                    ->orWhere('category', 'ilike', "%{$search}%");
            });
        }

        return Inertia::render('Insights/Index', [
            'insights' => $query
                ->with('author:id,name')
                ->orderByDesc('published_at')
                ->orderByDesc('id')
                ->paginate(9)
                ->withQueryString(),

            'subjects' => $this->publishedInsights()
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->orderBy('category')
                ->pluck('category'),

            'filters' => $request->only('type', 'category', 'q'),
        ]);
    }

    public function show(string $slug): Response
    {
        $insight = $this->publishedInsights()
            ->where('slug', $slug)
            ->with('author:id,name')
            ->firstOrFail();

        $related = $this->publishedInsights()
            ->where('id', '!=', $insight->id)
            ->with('author:id,name')
            ->orderByRaw(
                'CASE WHEN category = ? THEN 0 ELSE 1 END',
                [$insight->category ?? '']
            )
            ->orderByDesc('published_at')
            ->limit(3)
            ->get([
                'id',
                'author_id',
                'title',
                'slug',
                'type',
                'category',
                'excerpt',
                'cover_image',
                'published_at',
            ]);

        return Inertia::render('Insights/Show', [
            'insight' => $insight,
            'related' => $related,
            'collectionType' => null,
            'hasResponded' => false,
        ]);
    }

    private function publishedInsights()
    {
        return Insight::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
