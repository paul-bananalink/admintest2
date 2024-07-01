<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteDetectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $domain = request()->getSchemeAndHttpHost(); //Return full domain as https://apitest.spobulls.net

        $admin_suffix = $request->is('admin/*');

        $partner_suffix = $request->is('partner/*');

        if ($domain == env('API_URL') && ($admin_suffix || $partner_suffix)) {
            return abort(404);
        }

        if ($domain == env('PARTNER_URL') && $admin_suffix) {
            return abort(404);
        }

        return $next($request);
    }
}
