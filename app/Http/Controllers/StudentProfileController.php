<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class StudentProfileController extends Controller
{
    private const DEFAULT_NOTIFICATION_PREFERENCES = [
        'class_reminders' => true,
        'assignment_feedback' => true,
        'event_updates' => true,
        'academy_updates' => true,
    ];

    public function show(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Learning/Profile', [
            'profile' => [
                'name' => $user->name,
                'email' => $user->email,
                'bio' => $user->bio ?? '',
                'emailVerified' => $user->hasVerifiedEmail(),
            ],
        ]);
    }

    public function learningPreferences(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Learning/Preferences', [
            'timezone' => $user->timezone ?? 'Asia/Kolkata',
            'courses' => $this->activeCourses($user),
        ]);
    }

    public function notifications(Request $request): Response
    {
        return Inertia::render('Learning/Notifications', [
            'preferences' => array_merge(self::DEFAULT_NOTIFICATION_PREFERENCES, $request->user()->notification_preferences ?? []),
        ]);
    }

    public function security(Request $request): Response
    {
        return Inertia::render('Learning/Security', [
            'security' => [
                'email' => $request->user()->email,
                'emailVerified' => $request->user()->hasVerifiedEmail(),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'bio' => ['nullable', 'string', 'max:500'],
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Your profile has been updated.');
    }

    public function updatePreferences(Request $request): RedirectResponse
    {
        $validated = $request->validate(['timezone' => ['required', 'timezone']]);
        $request->user()->update($validated);

        return back()->with('success', 'Your learning preferences have been saved.');
    }

    public function updateNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'preferences' => ['required', 'array'],
            'preferences.class_reminders' => ['required', 'boolean'],
            'preferences.assignment_feedback' => ['required', 'boolean'],
            'preferences.event_updates' => ['required', 'boolean'],
            'preferences.academy_updates' => ['required', 'boolean'],
        ]);

        $request->user()->update(['notification_preferences' => $validated['preferences']]);

        return back()->with('success', 'Your notification preferences have been saved.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(12)->letters()->mixedCase()->numbers()],
        ]);

        $request->user()->update(['password' => $validated['password']]);

        return back()->with('success', 'Your password has been changed.');
    }

    private function activeCourses(User $user)
    {
        return $user->enrollments()->where('status', 'active')->with('course:id,title,slug')->get()
            ->filter(fn ($enrollment) => $enrollment->course)
            ->map(fn ($enrollment) => ['title' => $enrollment->course->title, 'slug' => $enrollment->course->slug])
            ->values();
    }
}
