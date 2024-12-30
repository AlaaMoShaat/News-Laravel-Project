<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && !$user->is_profile_complete) {
            if ($request->is('account/setting') || $request->is('account/setting/*')) {
                return $next($request);
            }
            if (Auth::guard('web')->check()) {
                return redirect()->route('frontend.dashboard.setting');
            }
            if (Auth::guard('sanctum')->check()) {
                return apiResponse(403, 'Please Complete Your Profile');
            }
        }

        return $next($request);
    }
}
