<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;
use App\Models\Insight;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function index(): Response
    {
        $reports = $this->publishedReports()
            ->with('author:id,name')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Insights/Collection', [
            'contentType' => 'report',
            'title' => 'Research reports',
            'description' => 'Read research, findings, and evidence-led reports shared with the Alfrik community.',
            'insights' => $reports,
        ]);
    }

    public function show(string $slug): Response
    {
        $report = $this->publishedReports()
            ->where('slug', $slug)
            ->with('author:id,name')
            ->firstOrFail();

        $related = Insight::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $report->id)
            ->with('author:id,name')
            ->orderByRaw(
                'CASE WHEN category = ? THEN 0 ELSE 1 END',
                [$report->category ?? '']
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
            'insight' => $report,
            'related' => $related,
            'collectionType' => 'report',
            'hasResponded' => false,
        ]);
    }

    private function publishedReports()
    {
        return Insight::query()
            ->where('type', 'report')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
