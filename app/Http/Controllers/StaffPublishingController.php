<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Support\Images\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class StaffPublishingController extends Controller
{
    public function index(Request $request): Response
    {
        $this->authorizePublishing($request);

        $canManageApplications = $request->user()->hasRole('admin')
            || $request->user()->hasPermission('applications.manage');

        $jobs = JobPost::query()
            ->withCount('applications')
            ->latest()
            ->limit(8)
            ->get();

        if ($canManageApplications) {
            $jobs->each(
                fn (JobPost $job) => $job->makeVisible([
                    'contact_name',
                    'contact_email',
                    'company_website',
                ])
            );
        }

        return Inertia::render('Staff/Publishing', [
            'insights' => Insight::query()
                ->latest()
                ->limit(8)
                ->get(),

            'jobs' => $jobs,

            'applications' => $canManageApplications
                ? JobApplication::query()
                    ->with([
                        'job:id,title,company',
                        'applicant:id,name,email',
                    ])
                    ->latest('submitted_at')
                    ->limit(30)
                    ->get()
                : collect(),

            'canManageApplications' => $canManageApplications,
        ]);
    }

    public function surveys(Request $request): Response
    {
        return $this->editorialContent($request, 'survey');
    }

    public function reports(Request $request): Response
    {
        return $this->editorialContent($request, 'report');
    }

    private function editorialContent(
        Request $request,
        string $type
    ): Response {
        $this->authorizePublishing($request);

        $entries = Insight::query()
            ->where('type', $type)
            ->withCount('surveyResponses')
            ->when(
                $type === 'survey',
                fn ($query) => $query->with([
                    'surveyResponses:id,insight_id,answers',
                ])
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $surveyResults = [];

        if ($type === 'survey') {
            foreach ($entries->getCollection() as $entry) {
                $choiceQuestions = collect($entry->survey_questions ?? [])
                    ->filter(
                        fn ($question) => in_array(
                            $question['type'] ?? null,
                            ['single_choice', 'multiple_choice'],
                            true
                        )
                    );

                $counts = $choiceQuestions->mapWithKeys(
                    function ($question) {
                        $options = collect($question['options'] ?? [])
                            ->mapWithKeys(
                                fn ($option) => [$option => 0]
                            )
                            ->all();

                        return [$question['id'] => $options];
                    }
                )->all();

                if ($counts !== []) {
                    foreach ($entry->surveyResponses as $response) {
                        foreach ($counts as $questionId => &$options) {
                            $answers = $response->answers[$questionId] ?? null;

                            foreach (
                                is_array($answers) ? $answers : [$answers]
                                as $answer
                            ) {
                                if (
                                    is_string($answer)
                                    && array_key_exists($answer, $options)
                                ) {
                                    $options[$answer]++;
                                }
                            }
                        }

                        unset($options);
                    }
                }

                $surveyResults[$entry->id] = $counts;
            }
        }

        return Inertia::render('Staff/Manage/EditorialContent', [
            'contentType' => $type,
            'entries' => $entries,
            'surveyResults' => $surveyResults,
        ]);
    }

    public function storeInsight(Request $request): RedirectResponse
    {
        $this->authorizePublishing($request);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'type' => [
                'required',
                Rule::in(['article', 'news', 'event', 'survey', 'report']),
            ],
            'category' => ['nullable', 'string', 'max:100'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string', 'min:20'],
            'cover_image' => ['nullable', 'string', 'max:2048'],
            'cover_upload' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'survey_questions' => ['nullable', 'array', 'max:20'],
            'survey_questions.*.id' => [
                'required',
                'alpha_dash',
                'max:40',
                'distinct',
            ],
            'survey_questions.*.prompt' => [
                'required',
                'string',
                'max:240',
            ],
            'survey_questions.*.type' => [
                'required',
                Rule::in(['text', 'single_choice', 'multiple_choice']),
            ],
            'survey_questions.*.required' => [
                'required',
                'boolean',
            ],
            'survey_questions.*.options' => [
                'nullable',
                'array',
                'max:20',
            ],
            'survey_questions.*.options.*' => [
                'required',
                'string',
                'max:120',
            ],
            'status' => ['required', 'in:draft,published'],
        ]);

        $data['survey_questions'] = $this->validatedSurveyQuestions($data);
        $data['author_id'] = $request->user()->id;
        $data['slug'] = Str::slug($data['title'])
            . '-'
            . Str::lower(Str::random(5));

        $data['reading_minutes'] = $this->readingMinutes($data['body']);
        $data['published_at'] = $data['status'] === 'published'
            ? now()
            : null;

        $data['cover_image'] = ImageUpload::store(
            $request,
            'cover_upload',
            'insights',
            1200,
            800
        ) ?? ($data['cover_image'] ?? null);

        unset($data['cover_upload']);

        Insight::query()->create($data);

        return to_route(
            $data['type'] === 'survey'
                ? 'staff.manage.surveys'
                : ($data['type'] === 'report'
                    ? 'staff.manage.reports'
                    : 'staff.publishing')
        )->with('success', 'Your insight is saved.');
    }

    public function storeJob(Request $request): RedirectResponse
    {
        $this->authorizePublishing($request);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'company' => ['required', 'string', 'max:180'],
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
            'description' => ['required', 'string', 'min:20'],
            'skills' => ['nullable', 'string', 'max:500'],
            'application_url' => ['nullable', 'url', 'max:2048'],
            'expires_at' => ['nullable', 'date', 'after:today'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $data['posted_by'] = $request->user()->id;
        $data['slug'] = Str::slug(
            $data['title'] . '-' . $data['company']
        ) . '-' . Str::lower(Str::random(5));

        $data['skills'] = $this->normalizeSkills($data['skills'] ?? null);

        $data['published_at'] = $data['status'] === 'published'
            ? now()
            : null;

        JobPost::query()->create($data);

        return to_route('staff.publishing')
            ->with('success', 'The opportunity is saved.');
    }

    public function updateApplication(
        Request $request,
        JobApplication $application
    ): RedirectResponse {
        $this->authorizeApplications($request);

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'submitted',
                    'reviewing',
                    'shortlisted',
                    'declined',
                ]),
            ],
        ]);

        $application->update($validated);

        return to_route('staff.publishing')
            ->with('success', 'Application status updated.');
    }

    public function updateInsight(
        Request $request,
        Insight $insight
    ): RedirectResponse {
        $this->authorizePublishing($request);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'required',
                'alpha_dash',
                'max:190',
                Rule::unique('insights', 'slug')->ignore($insight->id),
            ],
            'type' => [
                'required',
                Rule::in(['article', 'news', 'event', 'survey', 'report']),
            ],
            'category' => ['nullable', 'string', 'max:100'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string', 'min:20'],
            'cover_image' => ['nullable', 'string', 'max:2048'],
            'cover_upload' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'survey_questions' => ['nullable', 'array', 'max:20'],
            'survey_questions.*.id' => [
                'required',
                'alpha_dash',
                'max:40',
                'distinct',
            ],
            'survey_questions.*.prompt' => [
                'required',
                'string',
                'max:240',
            ],
            'survey_questions.*.type' => [
                'required',
                Rule::in(['text', 'single_choice', 'multiple_choice']),
            ],
            'survey_questions.*.required' => [
                'required',
                'boolean',
            ],
            'survey_questions.*.options' => [
                'nullable',
                'array',
                'max:20',
            ],
            'survey_questions.*.options.*' => [
                'required',
                'string',
                'max:120',
            ],
            'status' => ['required', 'in:draft,published'],
        ]);

        $data['survey_questions'] = $this->validatedSurveyQuestions($data);
        $data['reading_minutes'] = $this->readingMinutes($data['body']);

        $newImagePath = ImageUpload::store(
            $request,
            'cover_upload',
            'insights',
            1200,
            800
        );

        if ($newImagePath !== null) {
            $data['cover_image'] = $newImagePath;
        } else {
            // Preserve the existing image when no new upload is supplied.
            $data['cover_image'] = $insight->getRawOriginal('cover_image');
        }

        unset($data['cover_upload']);

        $data['published_at'] = $data['status'] === 'published'
            ? ($insight->published_at ?? now())
            : null;

        DB::transaction(function () use ($insight, $data, $newImagePath) {
            $insight->update($data);
        });

        if ($newImagePath !== null) {
            ImageUpload::deleteManaged(
                $insight->getRawOriginal('cover_image'),
                'insights'
            );
        }

        return back()->with('success', 'Insight updated.');
    }

    public function destroyInsight(
        Request $request,
        Insight $insight
    ): RedirectResponse {
        $this->authorizePublishing($request);

        $oldImagePath = $insight->getRawOriginal('cover_image');

        $insight->delete();

        ImageUpload::deleteManaged($oldImagePath, 'insights');

        return back()->with('success', 'Insight removed from the public site.');
    }

    public function updateJob(
        Request $request,
        JobPost $jobPost
    ): RedirectResponse {
        $this->authorizePublishing($request);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'required',
                'alpha_dash',
                'max:190',
                Rule::unique('job_posts', 'slug')->ignore($jobPost->id),
            ],
            'company' => ['required', 'string', 'max:180'],
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
            'description' => ['required', 'string', 'min:20'],
            'skills' => ['nullable', 'string', 'max:500'],
            'application_url' => ['nullable', 'url', 'max:2048'],
            'expires_at' => ['nullable', 'date'],
            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'pending_review',
                    'published',
                    'closed',
                ]),
            ],
        ]);

        $data['skills'] = $this->normalizeSkills($data['skills'] ?? null);

        $data['published_at'] = $data['status'] === 'published'
            ? ($jobPost->published_at ?? now())
            : null;

        $jobPost->update($data);

        return back()->with('success', 'Opportunity updated.');
    }

    public function closeJob(
        Request $request,
        JobPost $jobPost
    ): RedirectResponse {
        $this->authorizePublishing($request);

        $jobPost->update(['status' => 'closed']);

        return back()->with(
            'success',
            'Opportunity closed. Application history was retained.'
        );
    }

    private function authorizePublishing(Request $request): void
    {
        abort_unless(
            $request->user()
                && (
                    $request->user()->hasRole('admin')
                    || $request->user()->hasPermission('marketing.manage')
                ),
            403
        );
    }

    private function authorizeApplications(Request $request): void
    {
        abort_unless(
            $request->user()
                && (
                    $request->user()->hasRole('admin')
                    || $request->user()->hasPermission('applications.manage')
                ),
            403
        );
    }

    private function validatedSurveyQuestions(array $data): ?array
    {
        if ($data['type'] !== 'survey') {
            return null;
        }

        $questions = collect($data['survey_questions'] ?? [])
            ->map(function (array $question) {
                $question['prompt'] = trim($question['prompt']);

                $options = collect($question['options'] ?? [])
                    ->map(fn ($option) => trim($option))
                    ->filter()
                    ->values();

                if (
                    $question['type'] !== 'text'
                    && (
                        $options->count() < 2
                        || $options
                            ->map(fn ($option) => mb_strtolower($option))
                            ->unique()
                            ->count() !== $options->count()
                    )
                ) {
                    throw ValidationException::withMessages([
                        'survey_questions' =>
                            'Choice questions need at least two distinct answer options.',
                    ]);
                }

                $question['options'] = $question['type'] === 'text'
                    ? []
                    : $options->all();

                $question['required'] = (bool) $question['required'];

                return $question;
            })
            ->values()
            ->all();

        if ($questions === []) {
            throw ValidationException::withMessages([
                'survey_questions' =>
                    'Add at least one question before saving this survey.',
            ]);
        }

        return $questions;
    }

    private function normalizeSkills(?string $skills): array
    {
        return collect(explode(',', $skills ?? ''))
            ->map(fn ($skill) => trim($skill))
            ->filter()
            ->unique(fn ($skill) => mb_strtolower($skill))
            ->values()
            ->all();
    }

    private function readingMinutes(string $body): int
    {
        return max(
            1,
            (int) ceil(str_word_count(strip_tags($body)) / 200)
        );
    }
}
