<?php

namespace App\Http\Middleware\Partner;

use App\Models\Member;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnerLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth(config('constant_view.GUARD.PARTNER'))->user()) {
            return $this->redirectWithError();
        }
        
        return $next($request);
    }

    private function redirectWithError(string $message = ''): RedirectResponse
    {
        return redirect()->route('partner.login')->withErrors("Can't Login because your account have a few issue!");
    }

}
