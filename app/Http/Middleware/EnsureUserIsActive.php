<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If not active → always go to pendingDashboard
        if ($user && $user->is_active == 0 && !$request->routeIs('pendingDashboard')) {
            return redirect()->route('pendingDashboard');
        }

        // Role-based dashboard protection
        $roleRoutes = [
            1 => 'adminDashboard',
            2 => 'ambassadorDashboard',
            3 => 'viceDashboard',
            4 => 'studentDashboard',
        ];

        if ($user && isset($roleRoutes[$user->user_role])) {
            $correctRoute = $roleRoutes[$user->user_role];

            // If not already on correct dashboard, redirect
            if (!$request->routeIs($correctRoute)) {
                return redirect()->route($correctRoute);
            }
        }

        return $next($request);
    }
}
