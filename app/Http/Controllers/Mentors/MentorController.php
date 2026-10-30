<?php

namespace App\Http\Controllers\Mentors;

use App\Data\PublicCatalog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MentorController extends Controller
{
    /**
     * Display all public mentors.
     */
    public function index(): Response
    {
        return Inertia::render('Mentors/Index', [
            'mentors' => PublicCatalog::mentors(),
        ]);
    }

    /**
     * Display a mentor and their related courses.
     */
    public function show(Request $request, string $slug): Response
    {
        $mentors = collect(PublicCatalog::mentors());

        $mentor = $mentors->firstWhere('slug', $slug);

        abort_if($mentor === null, 404);

        $courseSlugs = $mentor['courses'] ?? [];

        $courses = collect(PublicCatalog::courses())
            ->whereIn('slug', $courseSlugs)
            ->values();

        return Inertia::render('Mentors/Show', [
            'mentor' => $mentor,
            'courses' => $courses,
        ]);
    }
}