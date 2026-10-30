<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\WebinarEvent;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class AuthController extends Controller
{
    public function showLogin(Request $request): Response
    {
        $this->rememberEventDestination($request);

        return Inertia::render('Auth/Login');
    }

    public function showRegistration(Request $request): Response
    {
        $this->rememberEventDestination($request);

        return Inertia::render('Auth/Register');
    }

    public function showForgotPassword(): Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function sendPasswordResetLink(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => mb_strtolower(trim((string) $request->input('email'))),
        ]);

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        // Keep the response generic so account existence is not disclosed.
        Password::sendResetLink($request->only('email'));

        return back()->with(
            'success',
            'If an account uses that email, a password reset link is on its way.'
        );
    }

    public function showResetPassword(Request $request, string $token): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $token,
            'email' => mb_strtolower(trim((string) $request->query('email', ''))),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => mb_strtolower(trim((string) $request->input('email'))),
        ]);

        $credentials = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        $status = Password::reset(
            $credentials,
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return to_route('login')->with(
                'success',
                'Your password has been updated. Sign in with your new password.'
            );
        }

        return back()->withErrors([
            'email' => 'This password reset link is invalid or has expired.',
        ]);
    }

    public function verificationNotice(): Response|RedirectResponse
    {
        $user = request()->user();

        if ($user->hasVerifiedEmail()) {
            return to_route('learn');
        }

        return Inertia::render('Auth/VerifyEmail');
    }

    public function resendVerification(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return to_route('learn');
        }

        $user->sendEmailVerificationNotification();

        return back()->with(
            'success',
            'A fresh verification link has been sent to your email address.'
        );
    }

    public function verifyEmail(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return to_route('learn');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => mb_strtolower(trim((string) $request->input('email'))),
        ]);

        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(
            [
                ...$credentials,
                'is_active' => true,
            ],
            $request->boolean('remember')
        )) {
            throw ValidationException::withMessages([
                'email' => 'Those details do not match an account.',
            ]);
        }

        $request->session()->regenerate();

        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return to_route('verification.notice');
        }

        $isStaff = $user->roles()
            ->whereIn('name', ['admin', 'teacher', 'social_manager'])
            ->exists();

        return redirect()->intended(
            route($isStaff ? 'staff' : 'learn')
        );
    }

    public function register(Request $request): RedirectResponse
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => mb_strtolower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
            'timezone' => ['nullable', 'timezone'],
        ]);

        // Resolve the role before creating a user so a missing seed
        // cannot leave a newly created account without its student role.
        $studentRole = Role::query()
            ->where('name', 'student')
            ->first();

        if (! $studentRole) {
            report(new ModelNotFoundException(
                'The required student role has not been seeded.'
            ));

            throw ValidationException::withMessages([
                'email' => 'Registration is temporarily unavailable. Please try again later.',
            ]);
        }

        $user = DB::transaction(function () use ($validated, $studentRole): User {
            $user = User::query()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->roles()->sync([$studentRole->id]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        $user->sendEmailVerificationNotification();

        return to_route('verification.notice');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home');
    }

    /**
     * Preserve only valid, published event destinations as intended URLs.
     */
    private function rememberEventDestination(Request $request): void
    {
        $next = (string) $request->query('next', '');
        $path = parse_url($next, PHP_URL_PATH);

        if (
            ! is_string($path)
            || ! preg_match('#^/events/([a-zA-Z0-9_-]+)$#', $path, $matches)
        ) {
            return;
        }

        $eventExists = WebinarEvent::query()
            ->where('slug', $matches[1])
            ->whereIn('status', ['published', 'completed'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->exists();

        if ($eventExists) {
            $request->session()->put('url.intended', $path);
        }
    }
}