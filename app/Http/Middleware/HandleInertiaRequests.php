<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $user = $request->user();
        $roles = $user ? $user->roles()->with('permissions:id,name')->get() : collect();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    ...$user->only('id', 'name', 'email', 'timezone'),
                    'emailVerified' => $user->hasVerifiedEmail(),
                    'roles' => $roles->pluck('name')->values(),
                    'permissions' => $roles->flatMap(fn ($role) => $role->permissions->pluck('name'))->unique()->values(),
                ] : null,
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
            ],
            'notifications' => fn () => $user ? [
                'unreadCount' => $user->unreadNotifications()->count(),
                'recent' => $user->notifications()->latest()->limit(5)->get(['id', 'data', 'read_at', 'created_at'])
                    ->map(fn ($notification) => [
                        'id' => $notification->id,
                        'title' => $notification->data['title'] ?? 'Academy update',
                        'body' => $notification->data['body'] ?? '',
                        'url' => $notification->data['url'] ?? null,
                        'category' => $notification->data['category'] ?? 'learning',
                        'readAt' => $notification->read_at?->toIso8601String(),
                        'createdAt' => $notification->created_at?->toIso8601String(),
                    ])->values(),
            ] : ['unreadCount' => 0, 'recent' => []],
        ];
    }
}
