<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LearnerStory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AdminStoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Staff/Manage/Stories', [
            'stories' => LearnerStory::query()->with('course:id,title')->latest()->paginate(10)->withQueryString(),
            'courses' => Course::query()->orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']).'-'.Str::lower(Str::random(5));
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        LearnerStory::query()->create($data);

        return back()->with('success', 'Learner story created.');
    }

    public function update(Request $request, LearnerStory $story): RedirectResponse
    {
        $data = $this->validated($request, $story);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['published_at'] = $data['status'] === 'published' ? ($story->published_at ?? now()) : null;
        $story->update($data);

        return back()->with('success', 'Learner story updated.');
    }

    public function destroy(LearnerStory $story): RedirectResponse
    {
        $story->delete();

        return back()->with('success', 'Learner story removed from the public site.');
    }

    private function validated(Request $request, ?LearnerStory $story = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'], 'slug' => ['nullable', 'alpha_dash', 'max:180', Rule::unique('learner_stories', 'slug')->ignore($story?->id)],
            'course_id' => ['nullable', 'exists:courses,id'], 'role' => ['required', 'string', 'max:180'],
            'cohort' => ['nullable', 'string', 'max:120'], 'outcome' => ['required', 'string', 'max:180'],
            'quote' => ['required', 'string', 'max:1500'], 'story' => ['required', 'string', 'max:12000'],
            'color' => ['required', Rule::in(['lilac', 'blue', 'orange'])], 'status' => ['required', Rule::in(['draft', 'published'])],
        ]);
    }
}
