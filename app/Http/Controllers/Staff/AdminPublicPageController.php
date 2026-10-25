<?php

namespace App\Http\Controllers\Staff;

use App\Data\PublicPageDefaults;
use App\Http\Controllers\Controller;
use App\Models\PublicPageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminPublicPageController extends Controller
{
    public function index(): Response
    {
        $defaults = PublicPageDefaults::all();
        $stored = PublicPageContent::query()->whereIn('page_key', array_keys($defaults))->get()->keyBy('page_key');
        $pages = collect($defaults)->map(fn (array $content, string $key) => array_replace_recursive($content, $stored->get($key)?->content ?? []))->all();

        return Inertia::render('Staff/Manage/PublicPages', ['pages' => $pages]);
    }

    public function update(Request $request, string $pageKey): RedirectResponse
    {
        abort_unless(in_array($pageKey, ['about', 'how', 'faq'], true), 404);
        $rules = [
            'about' => [
                'content.eyebrow' => ['required', 'string', 'max:120'], 'content.title' => ['required', 'string', 'max:180'],
                'content.emphasis' => ['required', 'string', 'max:180'], 'content.intro' => ['required', 'string', 'max:1000'],
                'content.section_title' => ['required', 'string', 'max:180'], 'content.section_body' => ['required', 'string', 'max:5000'],
                'content.section_support' => ['required', 'string', 'max:2000'], 'content.values' => ['required', 'array', 'min:1', 'max:6'],
                'content.values.*' => ['required', 'string', 'max:180'], 'content.cta_title' => ['required', 'string', 'max:180'],
            ],
            'how' => [
                'content.eyebrow' => ['required', 'string', 'max:120'], 'content.title' => ['required', 'string', 'max:180'],
                'content.emphasis' => ['required', 'string', 'max:180'], 'content.intro' => ['required', 'string', 'max:1000'],
                'content.steps' => ['required', 'array', 'min:1', 'max:8'], 'content.steps.*.number' => ['required', 'string', 'max:8'],
                'content.steps.*.title' => ['required', 'string', 'max:180'], 'content.steps.*.text' => ['required', 'string', 'max:1000'],
                'content.callout_title' => ['required', 'string', 'max:180'], 'content.callout_body' => ['required', 'string', 'max:2000'],
            ],
            'faq' => [
                'content.eyebrow' => ['required', 'string', 'max:120'], 'content.title' => ['required', 'string', 'max:180'],
                'content.emphasis' => ['required', 'string', 'max:180'], 'content.intro' => ['required', 'string', 'max:1000'],
                'content.items' => ['required', 'array', 'min:1', 'max:30'], 'content.items.*.question' => ['required', 'string', 'max:255'],
                'content.items.*.answer' => ['required', 'string', 'max:4000'],
            ],
        ];
        $data = $request->validate($rules[$pageKey]);
        PublicPageContent::query()->updateOrCreate(['page_key' => $pageKey], [
            'content' => $data['content'], 'updated_by' => $request->user()->id,
        ]);

        return back()->with('success', ucfirst($pageKey).' page content saved.');
    }
}
