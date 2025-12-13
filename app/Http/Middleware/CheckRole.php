<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckRole Middleware
 * 
 * Validates that the authenticated user has the required role(s)
 */
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles  Comma or pipe-separated list of allowed roles
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Parse roles (support both comma and pipe separators)
        $allowedRoles = preg_split('/[,|]/', $roles);
        $allowedRoles = array_map('trim', $allowedRoles);

        // Check if user has any of the required roles using Spatie Permission
        if (!$request->user()->hasAnyRole($allowedRoles)) {
            $userRoles = $request->user()->getRoleNames()->toArray();

            return response()->json([
                'success' => false,
                'user_roles' => $userRoles,
                'required_roles' => $allowedRoles,
                'message' => 'Unauthorized. Required role: ' . implode(' or ', $allowedRoles)
            ], 403);
        }

        return $next($request);
    }
}
