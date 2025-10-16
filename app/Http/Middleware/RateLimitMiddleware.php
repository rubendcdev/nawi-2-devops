<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $maxAttempts = 60, int $decayMinutes = 1): Response
    {
        $key = $this->resolveRequestSignature($request);

        if (Cache::has($key)) {
            $attempts = Cache::get($key, 0);
            if ($attempts >= $maxAttempts) {
                return response()->json([
                    'success' => false,
                    'message' => 'Demasiadas solicitudes. Intenta de nuevo en ' . $decayMinutes . ' minuto(s).',
                    'retry_after' => $decayMinutes * 60
                ], 429);
            }
            Cache::put($key, $attempts + 1, now()->addMinutes($decayMinutes));
        } else {
            Cache::put($key, 1, now()->addMinutes($decayMinutes));
        }

        return $next($request);
    }

    /**
     * Resolve request signature.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        $user = $request->user();
        $route = $request->route();

        if ($user) {
            return 'rate_limit:' . $user->id . ':' . $route->getName();
        }

        return 'rate_limit:' . $request->ip() . ':' . $route->getName();
    }
}
