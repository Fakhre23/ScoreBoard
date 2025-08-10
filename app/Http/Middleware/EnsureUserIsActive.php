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

        if ($user && $user->is_active == 0) {       //check if the logged-in user exists before trying to access their is_active property.
            return redirect()->route('pendingDashboard');
        } else if ($user && $user->user_role == 1) {
            return redirect()->route('adminDashboard');
        } else if ($user && $user->user_role == 2) {
            return redirect()->route('ambassadorDashboard');
        } else if ($user && $user->user_role == 3) {
            return redirect()->route('viceDashboard');
        } else if ($user && $user->user_role == 4) {
            return redirect()->route('studentDashboard');
        }
        return $next($request);
    }
}
