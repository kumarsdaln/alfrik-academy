<?php

namespace App\Http\Controllers\Careers;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function store(
        Request $request,
        string $slug
    ): RedirectResponse {
        $job = JobPost::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function ($query) {
                $query
                    ->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->firstOrFail();

        $validated = $request->validate([
            'cover_note' => ['nullable', 'string', 'max:5000'],
        ]);

        $application = JobApplication::query()->firstOrCreate(
            [
                'job_post_id' => $job->id,
                'user_id' => $request->user()->id,
            ],
            [
                'cover_note' => $validated['cover_note'] ?? null,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]
        );

        if (! $application->wasRecentlyCreated) {
            return back()->withErrors([
                'application' => 'You have already applied for this position.',
            ]);
        }

        return to_route('careers.show', $job->slug)->with(
            'success',
            'Your application has been sent.'
        );
    }
}