<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;
use App\Models\Insight;
use App\Models\SurveyResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class SurveyController extends Controller
{
    public function index(): Response
    {
        $surveys = $this->publishedSurveys()
            ->with('author:id,name')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Insights/Collection', [
            'contentType' => 'survey',
            'title' => 'Surveys',
            'description' => 'Explore community surveys, contribute your perspective, and see what people are asking across different fields.',
            'insights' => $surveys,
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $survey = $this->publishedSurveys()
            ->where('slug', $slug)
            ->with('author:id,name')
            ->firstOrFail();

        $related = Insight::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $survey->id)
            ->with('author:id,name')
            ->orderByRaw(
                'CASE WHEN category = ? THEN 0 ELSE 1 END',
                [$survey->category ?? '']
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
            'insight' => $survey,
            'related' => $related,
            'collectionType' => 'survey',
            'hasResponded' => SurveyResponse::query()
                ->where('insight_id', $survey->id)
                ->where(
                    'respondent_hash',
                    $this->respondentHash($request)
                )
                ->exists(),
        ]);
    }

    public function submit(
        Request $request,
        string $slug
    ): RedirectResponse {
        $survey = $this->publishedSurveys()
            ->where('slug', $slug)
            ->firstOrFail();

        $questions = collect($survey->survey_questions ?? [])
            ->filter(fn ($question) =>
                is_array($question)
                && isset($question['id'], $question['type'])
                && is_string($question['id'])
                && preg_match('/^[A-Za-z0-9_-]+$/', $question['id'])
                && in_array(
                    $question['type'],
                    ['text', 'multiple_choice', 'single_choice'],
                    true
                )
            )
            ->unique('id')
            ->values();

        abort_if($questions->isEmpty(), 404);

        $respondentHash = $this->respondentHash($request);

        if ($this->hasResponded($survey, $respondentHash)) {
            return back()->withErrors([
                'survey' => 'You have already submitted a response to this survey.',
            ]);
        }

        $allowedIds = $questions->pluck('id')->all();

        $rules = [
            'answers' => [
                'required',
                'array:' . implode(',', $allowedIds),
            ],
        ];

        foreach ($questions as $question) {
            $id = $question['id'];
            $required = (bool) ($question['required'] ?? false);

            $options = collect($question['options'] ?? [])
                ->filter(fn ($option) => is_string($option))
                ->unique()
                ->values()
                ->all();

            $key = "answers.{$id}";

            if ($question['type'] === 'text') {
                $rules[$key] = [
                    $required ? 'required' : 'nullable',
                    'string',
                    'max:2000',
                ];

                continue;
            }

            if ($question['type'] === 'multiple_choice') {
                $rules[$key] = [
                    $required ? 'required' : 'nullable',
                    'array',
                    'max:' . max(1, count($options)),
                ];

                if ($required) {
                    $rules[$key][] = 'min:1';
                }

                $rules["{$key}.*"] = [
                    'required',
                    'string',
                    Rule::in($options),
                    'distinct',
                ];

                continue;
            }

            $rules[$key] = [
                $required ? 'required' : 'nullable',
                'string',
                Rule::in($options),
            ];
        }

        $validated = $request->validate($rules);

        $response = SurveyResponse::query()->firstOrCreate(
            [
                'insight_id' => $survey->id,
                'respondent_hash' => $respondentHash,
            ],
            [
                'answers' => $validated['answers'],
                'submitted_at' => now(),
            ]
        );

        if (! $response->wasRecentlyCreated) {
            return back()->withErrors([
                'survey' => 'You have already submitted a response to this survey.',
            ]);
        }

        return back()->with(
            'success',
            'Thank you. Your anonymous response has been recorded.'
        );
    }

    private function publishedSurveys()
    {
        return Insight::query()
            ->where('type', 'survey')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    private function hasResponded(
        Insight $survey,
        string $respondentHash
    ): bool {
        return SurveyResponse::query()
            ->where('insight_id', $survey->id)
            ->where('respondent_hash', $respondentHash)
            ->exists();
    }

    private function respondentHash(Request $request): string
    {
        $identity = $request->user()
            ? 'user:' . $request->user()->getAuthIdentifier()
            : 'session:' . $request->session()->getId();

        return hash_hmac(
            'sha256',
            $identity,
            (string) config('app.key')
        );
    }
}