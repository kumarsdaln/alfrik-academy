<?php

namespace App\Http\Controllers\Careers;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JobController extends Controller
{
    public function index(Request $request): Response
    {
        $query = $this->publishedJobs();

        if ($employment = $request->string('employment')->trim()->toString()) {
            $query->where('employment_type', $employment);
        }

        if ($search = $request->string('q')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'ilike', "%{$search}%")
                    ->orWhere('company', 'ilike', "%{$search}%");
            });
        }

        $jobs = $query
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        if ($request->user()) {
            $appliedIds = JobApplication::query()
                ->where('user_id', $request->user()->id)
                ->whereIn(
                    'job_post_id',
                    collect($jobs->items())->pluck('id')
                )
                ->pluck('job_post_id');

            $jobs->getCollection()->each(
                fn ($job) => $job->setAttribute(
                    'has_applied',
                    $appliedIds->contains($job->id)
                )
            );
        }

        return Inertia::render('Careers/Index', [
            'jobs' => $jobs,
            'filters' => $request->only('employment', 'q'),
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $job = $this->publishedJobs()
            ->where('slug', $slug)
            ->firstOrFail();

        $hasApplied = $request->user()
            ? JobApplication::query()
                ->where('job_post_id', $job->id)
                ->where('user_id', $request->user()->id)
                ->exists()
            : false;

        return Inertia::render('Careers/Show', [
            'job' => $job,
            'hasApplied' => $hasApplied,
        ]);
    }

    private function publishedJobs()
    {
        return JobPost::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function ($builder) {
                $builder
                    ->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            });
    }
}