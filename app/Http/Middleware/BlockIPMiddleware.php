<?php

namespace App\Http\Middleware;

use App\Services\SiteInfoService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockIPMiddleware
{
    public function __construct(private SiteInfoService $siteInfoService)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $manualBlockIps = stringToArray(app('site_info')->siManualBlockIP);
        $autoBlockIps = stringToArray(app('site_info')->siAutomationBlockIP);

        $blockedIps = [...$manualBlockIps, ...$autoBlockIps];

        $isBlocked = in_array($request->ip(), $blockedIps);

        if ($isBlocked && isApiDomain()) {
            return response()->json(['status' => false, 'message' => 'blocked ip'], 403);
        }

        if ($isBlocked && isAdminDomain()) {
            return abort(401, '사이트에 접속할 수 없습니다.');
        }

        return $next($request);
    }
}
