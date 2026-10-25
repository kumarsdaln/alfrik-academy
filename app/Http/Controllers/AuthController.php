<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\WebinarEvent;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

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
        $request->validate(['email' => ['required', 'email', 'max:255']]);
        Password::sendResetLink($request->only('email'));

        return back()->with('success', 'If an account uses that email, a password reset link is on its way.');
    }

    public function showResetPassword(Request $request, string $token): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        $status = Password::reset($credentials, function (User $user, string $password): void {
            $user->forceFill(['password' => $password, 'remember_token' => Str::random(60)])->save();
            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? to_route('login')->with('success', 'Your password has been updated. Sign in with your new password.')
            : back()->withErrors(['email' => 'This password reset link is invalid or has expired.']);
    }

    public function verificationNotice(): Response|RedirectResponse
    {
        return request()->user()->hasVerifiedEmail()
            ? to_route('learn')
            : Inertia::render('Auth/VerifyEmail');
    }

    public function resendVerification(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return to_route('learn');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A fresh verification link has been sent to your email address.');
    }

    public function verifyEmail(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return to_route('learn');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([...$credentials, 'is_active' => true], $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'Those details do not match an account.']);
        }

        $request->session()->regenerate();

        if (! Auth::user()->hasVerifiedEmail()) {
            Auth::user()->sendEmailVerificationNotification();

            return redirect()->route('verification.notice');
        }

        $staffRole = Auth::user()->roles()->whereIn('name', ['admin', 'teacher', 'social_manager'])->exists();

        return redirect()->intended(route($staffRole ? 'staff' : 'learn'));
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
            'timezone' => ['nullable', 'timezone'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'timezone' => $validated['timezone'] ?? 'Asia/Kolkata',
        ]);
        $user->roles()->sync([Role::where('name', 'student')->firstOrFail()->id]);

        Auth::login($user);
        $request->session()->regenerate();

        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function rememberEventDestination(Request $request): void
    {
        $path = parse_url((string) $request->query('next'), PHP_URL_PATH);
        if (! is_string($path) || ! preg_match('#^/events/([a-zA-Z0-9_-]+)$#', $path, $matches)) {
            return;
        }

        if (WebinarEvent::query()->where('slug', $matches[1])->whereIn('status', ['published', 'completed'])
            ->whereNotNull('published_at')->where('published_at', '<=', now())->exists()) {
            $request->session()->put('url.intended', $path);
        }
    }
}
