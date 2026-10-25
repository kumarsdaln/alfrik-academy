<?php

namespace App\Http\Middleware;

use App\Models\AuditEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditStaffMutations
{
    public function handle(Request $request, \Closure $next): Response
    {
        if (! str_starts_with($request->path(), 'staff/') || ! in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return $next($request);
        }

        $response = $next($request);
        $actor = $request->user();

        if ($actor && $actor->is_active && ($response->isSuccessful() || $response->isRedirection())) {
            $parameters = collect($request->route()?->parameters() ?? [])
                ->map(fn ($value) => $value instanceof Model ? $value->getKey() : (is_scalar($value) ? $value : null))
                ->filter(fn ($value) => $value !== null)->all();
            $fields = array_values(array_diff(array_keys($request->except(['_token', '_method', 'password', 'password_confirmation', 'token'])), ['current_password']));

            AuditEvent::query()->create([
                'actor_id' => $actor->id,
                'action' => $request->route()?->getName() ?? $request->method().' '.$request->path(),
                'context' => ['route_parameters' => $parameters, 'changed_fields' => $fields, 'http_status' => $response->getStatusCode()],
                'ip_address' => $request->ip(),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 500),
                'created_at' => now(),
            ]);
        }

        return $response;
    }
}
