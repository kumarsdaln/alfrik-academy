<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\SurveyResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class DiscoveryController extends Controller
{
    public function surveys(Request $request): Response
    {
        return $this->editorialCollection($request, 'survey');
    }

    public function reports(Request $request): Response
    {
        return $this->editorialCollection($request, 'report');
    }

    public function survey(Request $request, string $slug): Response
    {
        return $this->typedInsight($slug, 'survey', $request);
    }

    public function submitSurvey(Request $request, string $slug): RedirectResponse
    {
        $insight = Insight::query()
            ->where('slug', $slug)
            ->where('type', 'survey')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();
        $questions = collect($insight->survey_questions ?? [])->filter(fn ($question) => is_array($question) && isset($question['id'], $question['type']))->values();

        abort_if($questions->isEmpty(), 404);

        $allowedIds = $questions->pluck('id')->all();
        $rules = ['answers' => ['required', 'array:'.implode(',', $allowedIds)]];
        foreach ($questions as $question) {
            $id = $question['id'];
            $required = (bool) ($question['required'] ?? false);
            $options = array_values(array_filter($question['options'] ?? [], 'is_string'));

            if ($question['type'] === 'text') {
                $rules["answers.{$id}"] = [$required ? 'required' : 'nullable', 'string', 'max:2000'];
            } elseif ($question['type'] === 'multiple_choice') {
                $rules["answers.{$id}"] = [$required ? 'required' : 'nullable', 'array', 'max:'.max(1, count($options))];
                if ($required) {
                    $rules["answers.{$id}"][] = 'min:1';
                }
                $rules["answers.{$id}.*"] = ['string', Rule::in($options)];
            } else {
                $rules["answers.{$id}"] = [$required ? 'required' : 'nullable', 'string', Rule::in($options)];
            }
        }

        $validated = $request->validate($rules);
        $respondentHash = $this->surveyRespondentHash($request);
        SurveyResponse::query()->firstOrCreate(
            ['insight_id' => $insight->id, 'respondent_hash' => $respondentHash],
            ['answers' => $validated['answers'], 'submitted_at' => now()],
        );

        return back()->with('success', 'Thank you. Your anonymous response has been recorded.');
    }

    public function report(string $slug): Response
    {
        return $this->typedInsight($slug, 'report');
    }

    public function insights(Request $request): Response
    {
        $query = Insight::query()->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
        if ($type = $request->string('type')->toString()) {
            $query->where('type', $type);
        }
        if ($category = $request->string('category')->trim()->toString()) {
            $query->where('category', $category);
        }
        if ($search = $request->string('q')->trim()->toString()) {
            $query->where(fn ($builder) => $builder->where('title', 'ilike', "%{$search}%")
                ->orWhere('excerpt', 'ilike', "%{$search}%")
                ->orWhere('category', 'ilike', "%{$search}%"));
        }

        return Inertia::render('Insights/Index', [
            'insights' => $query->with('author:id,name')->latest('published_at')->paginate(9)->withQueryString(),
            'subjects' => Insight::query()->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())
                ->whereNotNull('category')->where('category', '!=', '')
                ->distinct()->orderBy('category')->pluck('category'),
            'filters' => $request->only('type', 'category', 'q'),
        ]);
    }

    public function insight(string $slug): Response
    {
        return $this->typedInsight($slug);
    }

    private function editorialCollection(Request $request, string $type): Response
    {
        $label = $type === 'survey' ? 'Surveys' : 'Research reports';
        $insights = Insight::query()->where('type', $type)->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())
            ->with('author:id,name')->latest('published_at')->paginate(12)->withQueryString();

        return Inertia::render('Insights/Collection', [
            'contentType' => $type,
            'title' => $label,
            'description' => $type === 'survey'
                ? 'Explore community surveys, contribute your perspective, and see what people are asking across different fields.'
                : 'Read research, findings, and evidence-led reports shared with the Kanram community.',
            'insights' => $insights,
        ]);
    }

    private function typedInsight(string $slug, ?string $type = null, ?Request $request = null): Response
    {
        $query = Insight::query()->where('slug', $slug)->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
        if ($type !== null) {
            $query->where('type', $type);
        }
        $insight = $query->with('author:id,name')->firstOrFail();
        $related = Insight::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $insight->id)
            ->with('author:id,name')
            ->orderByRaw('CASE WHEN category = ? THEN 0 ELSE 1 END', [$insight->category ?? ''])
            ->latest('published_at')
            ->limit(3)
            ->get(['id', 'author_id', 'title', 'slug', 'type', 'category', 'excerpt', 'cover_image', 'published_at']);

        return Inertia::render('Insights/Show', [
            'insight' => $insight,
            'related' => $related,
            'collectionType' => in_array($type, ['survey', 'report'], true) ? $type : null,
            'hasResponded' => $request && $type === 'survey'
                ? SurveyResponse::query()->where('insight_id', $insight->id)->where('respondent_hash', $this->surveyRespondentHash($request))->exists()
                : false,
        ]);
    }

    private function surveyRespondentHash(Request $request): string
    {
        $identity = $request->user()
            ? 'user:'.$request->user()->getAuthIdentifier()
            : 'session:'.$request->session()->getId();

        return hash_hmac('sha256', $identity, (string) config('app.key'));
    }

    public function jobs(Request $request): Response
    {
        $query = JobPost::query()->where('status', 'published')->where(fn ($builder) => $builder->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
        if ($type = $request->string('employment')->toString()) {
            $query->where('employment_type', $type);
        }
        if ($search = $request->string('q')->trim()->toString()) {
            $query->where(fn ($builder) => $builder->where('title', 'ilike', "%{$search}%")->orWhere('company', 'ilike', "%{$search}%"));
        }

        $jobs = $query->latest('published_at')->paginate(10)->withQueryString();
        if ($request->user()) {
            $appliedIds = JobApplication::query()->where('user_id', $request->user()->id)->whereIn('job_post_id', collect($jobs->items())->pluck('id'))->pluck('job_post_id');
            $jobs->getCollection()->each(fn ($job) => $job->setAttribute('has_applied', $appliedIds->contains($job->id)));
        }

        return Inertia::render('Careers/Index', ['jobs' => $jobs, 'filters' => $request->only('employment', 'q')]);
    }

    public function submitJob(Request $request): RedirectResponse
    {
        // Quietly accept honeypot submissions while discarding their content.
        if ($request->filled('fax_number')) {
            return to_route('careers.index')->with('success', 'Thanks. Your job listing has been sent for review.');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'company' => ['required', 'string', 'max:180'],
            'contact_name' => ['required', 'string', 'max:180'],
            'contact_email' => ['required', 'email:rfc', 'max:254'],
            'company_website' => ['nullable', 'url', 'max:2048'],
            'location' => ['required', 'string', 'max:180'],
            'workplace_type' => ['required', 'in:remote,hybrid,on_site'],
            'employment_type' => ['required', 'in:full_time,part_time,contract,internship'],
            'seniority' => ['nullable', 'string', 'max:100'],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'summary' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'min:30', 'max:12000'],
            'skills' => ['nullable', 'string', 'max:500'],
            'application_url' => ['nullable', 'url', 'max:2048'],
            'expires_at' => ['nullable', 'date', 'after:today'],
        ]);

        $data['posted_by'] = $request->user()?->id;
        $data['slug'] = Str::slug($data['title'].'-'.$data['company']).'-'.Str::lower(Str::random(6));
        $data['skills'] = collect(explode(',', $data['skills'] ?? ''))->map(fn ($skill) => trim($skill))->filter()->values()->all();
        $data['status'] = 'pending_review';
        $data['published_at'] = null;

        JobPost::query()->create($data);

        return to_route('careers.index')->with('success', 'Thanks. Your job listing has been sent for review.');
    }

    public function job(Request $request, string $slug): Response
    {
        $job = JobPost::query()->where('slug', $slug)->where('status', 'published')->where(fn ($builder) => $builder->whereNull('expires_at')->orWhere('expires_at', '>=', now()))->firstOrFail();
        $hasApplied = $request->user() ? JobApplication::query()->where('job_post_id', $job->id)->where('user_id', $request->user()->id)->exists() : false;

        return Inertia::render('Careers/Show', ['job' => $job, 'hasApplied' => $hasApplied]);
    }

    public function apply(Request $request, string $slug): RedirectResponse
    {
        $job = JobPost::query()->where('slug', $slug)->where('status', 'published')->where(fn ($builder) => $builder->whereNull('expires_at')->orWhere('expires_at', '>=', now()))->firstOrFail();
        $data = $request->validate(['cover_note' => ['nullable', 'string', 'max:5000']]);
        JobApplication::query()->firstOrCreate(
            ['job_post_id' => $job->id, 'user_id' => $request->user()->id],
            ['cover_note' => $data['cover_note'] ?? null, 'status' => 'submitted', 'submitted_at' => now()],
        );

        return to_route('careers.show', $job->slug)->with('success', 'Your application has been sent.');
    }
}
