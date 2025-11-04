<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUserTypeMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $userType): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado',
                'code' => 'UNAUTHENTICATED'
            ], 401);
        }

        // Check if user has the required type
        if (!$this->userHasType($user, $userType)) {
            return response()->json([
                'success' => false,
                'message' => 'Acceso denegado. Tipo de usuario no autorizado.',
                'code' => 'UNAUTHORIZED_USER_TYPE'
            ], 403);
        }

        return $next($request);
    }

    /**
     * Check if user has the required type
     */
    protected function userHasType($user, string $requiredType): bool
    {
        // Check if user has a role relationship
        if (method_exists($user, 'roles')) {
            return $user->roles()->where('name', $requiredType)->exists();
        }

        // Check if user has a type field
        if (isset($user->type)) {
            return $user->type === $requiredType;
        }

        // Check if user is a taxista (has license and circulation card)
        if ($requiredType === 'taxista') {
            return !empty($user->licencia) && !empty($user->tarjeta_circulacion);
        }

        // Default to pasajero for other cases
        return $requiredType === 'pasajero';
    }
}
