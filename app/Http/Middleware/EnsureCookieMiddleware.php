<?php

namespace App\Http\Middleware;

use App\Models\VisitorPreference;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Stringable;
use Symfony\Component\HttpFoundation\Response;

class EnsureCookieMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $visitorId = $request->cookie('visitor_id') ?: (string) Str::uuid();

        if (!$request->cookie('visitor_id')) {
            VisitorPreference::create(['visitor_id' => $visitorId]);
        }

        $request->merge(['visitor_id' => $visitorId]);

        $response = $next($request);

        return $response->withCookie(cookie('visitor_id', $visitorId));
    }
}
