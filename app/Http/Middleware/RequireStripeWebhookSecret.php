<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireStripeWebhookSecret
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(config('cashier.webhook.secret'), 503, 'Stripe webhooks are not configured.');

        return $next($request);
    }
}
