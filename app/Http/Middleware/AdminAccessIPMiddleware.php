<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessIPMiddleware
{
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminAccessIp = app('site_info')->siAdminAccessIP;
        if (!$adminAccessIp) {
            return $next($request);
        }

        $adminAccessIp = explode(PHP_EOL, $adminAccessIp);
        if (in_array($request->ip(), $adminAccessIp)) {
            return $next($request);
        }

        return abort(401, '사이트에 접속할 수 없습니다.');
    }
}
