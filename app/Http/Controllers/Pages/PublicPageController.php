<?php

namespace App\Http\Controllers\Pages;

use App\Data\PublicPageDefaults;
use App\Http\Controllers\Controller;
use App\Models\PublicPageContent;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use Inertia\Response;

class PublicPageController extends Controller
{
    /**
     * Display the How It Works page.
     */
    public function howItWorks(): Response
    {
        return Inertia::render('HowItWorks', [
            'content' => $this->pageContent('how'),
        ]);
    }

    /**
     * Display the About page.
     */
    public function about(): Response
    {
        return Inertia::render('About', [
            'content' => $this->pageContent('about'),
        ]);
    }

    /**
     * Display the FAQ page.
     */
    public function faq(): Response
    {
        return Inertia::render('Faq', [
            'content' => $this->pageContent('faq'),
        ]);
    }

    /**
     * Display the Contact page.
     */
    public function contact(): Response
    {
        return Inertia::render('Contact');
    }

    /**
     * Merge default page content with stored database content.
     */
    private function pageContent(string $key): array
    {
        $defaults = PublicPageDefaults::all()[$key] ?? [];

        $stored = Schema::hasTable('public_page_contents')
            ? PublicPageContent::query()
                ->where('page_key', $key)
                ->first()
                ?->content
            : null;

        return array_replace_recursive(
            $defaults,
            is_array($stored) ? $stored : []
        );
    }
}