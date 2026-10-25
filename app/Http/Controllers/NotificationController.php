<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $filter = $request->query('filter', 'all');
        if (! in_array($filter, ['all', 'unread', 'read'], true)) {
            $filter = 'all';
        }

        $query = $user->notifications();
        $counts = [
            'all' => (clone $query)->count(),
            'unread' => (clone $query)->whereNull('read_at')->count(),
            'read' => (clone $query)->whereNotNull('read_at')->count(),
        ];

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->latest()->paginate(25)->withQueryString()->through(fn ($notification) => [
            'id' => $notification->id,
            'title' => $notification->data['title'] ?? 'Academy update',
            'body' => $notification->data['body'] ?? '',
            'url' => $notification->data['url'] ?? null,
            'category' => $notification->data['category'] ?? 'learning',
            'readAt' => $notification->read_at?->toIso8601String(),
            'createdAt' => $notification->created_at?->toIso8601String(),
        ]);

        return Inertia::render('Notifications/Index', [
            'notifications' => $notifications,
            'unreadCount' => $counts['unread'],
            'counts' => $counts,
            'activeFilter' => $filter,
        ]);
    }

    public function read(Request $request, string $notification): RedirectResponse
    {
        $request->user()->notifications()->whereKey($notification)->firstOrFail()->markAsRead();

        return back();
    }

    public function readAll(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return back();
    }

    public function open(Request $request, string $notification): RedirectResponse
    {
        $record = $request->user()->notifications()->whereKey($notification)->firstOrFail();
        $record->markAsRead();
        $url = $record->data['url'] ?? null;
        abort_unless(is_string($url) && $url !== '' && ! str_contains($url, "\\"), 404);

        $parts = parse_url($url);
        abort_unless(is_array($parts), 404);

        if (isset($parts['host'])) {
            $appUrl = parse_url((string) config('app.url')) ?: [];
            $trustedHosts = array_filter([
                strtolower($request->getHost()),
                isset($appUrl['host']) ? strtolower($appUrl['host']) : null,
            ]);

            abort_unless(
                in_array(strtolower($parts['host']), $trustedHosts, true)
                && in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)
                && ! isset($parts['user'])
                && ! isset($parts['pass']),
                404,
            );
            $url = ($parts['path'] ?? '/')
                .(isset($parts['query']) ? '?'.$parts['query'] : '')
                .(isset($parts['fragment']) ? '#'.$parts['fragment'] : '');
        }

        abort_unless(str_starts_with($url, '/') && ! str_starts_with($url, '//'), 404);

        return redirect($url);
    }
}
