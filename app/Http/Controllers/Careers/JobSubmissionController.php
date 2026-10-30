<?php

namespace App\Http\Controllers\Careers;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobSubmissionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Silently discard honeypot submissions.
        if ($request->filled('fax_number')) {
            return to_route('careers.index')->with(
                'success',
                'Thanks. Your job listing has been sent for review.'
            );
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'company' => ['required', 'string', 'max:180'],
            'contact_name' => ['required', 'string', 'max:180'],
            'contact_email' => ['required', 'email:rfc', 'max:254'],
            'company_website' => ['nullable', 'url', 'max:2048'],
            'location' => ['required', 'string', 'max:180'],
            'workplace_type' => [
                'required',
                Rule::in(['remote', 'hybrid', 'on_site']),
            ],
            'employment_type' => [
                'required',
                Rule::in([
                    'full_time',
                    'part_time',
                    'contract',
                    'internship',
                ]),
            ],
            'seniority' => ['nullable', 'string', 'max:100'],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'summary' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'min:30', 'max:12000'],
            'skills' => ['nullable', 'string', 'max:500'],
            'application_url' => ['nullable', 'url', 'max:2048'],
            'expires_at' => ['nullable', 'date', 'after:today'],
        ]);

        $slugBase = Str::slug(
            $data['title'] . '-' . $data['company']
        );

        $data['slug'] = $slugBase . '-' . Str::lower(Str::random(8));
        $data['posted_by'] = $request->user()?->id;
        $data['skills'] = collect(
            explode(',', $data['skills'] ?? '')
        )
            ->map(fn (string $skill) => trim($skill))
            ->filter()
            ->unique()
            ->values()
            ->all();

        // Public submissions must wait for administrator approval.
        $data['status'] = 'pending_review';
        $data['published_at'] = null;

        JobPost::query()->create($data);

        return to_route('careers.index')->with(
            'success',
            'Thanks. Your job listing has been sent for review.'
        );
    }
}