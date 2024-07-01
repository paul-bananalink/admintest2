<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $member = (Auth::guard('sanctum')->user());
        if (!empty($member)) {
            $mID = $member->mID;
            Cache::put('member-is-online-' . $mID, true, now()->addMinutes(3));
        }

        return $next($request);
    }
}
