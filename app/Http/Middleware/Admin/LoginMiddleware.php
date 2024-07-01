<?php

namespace App\Http\Middleware\Admin;

use App\Models\Member;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->checkMLevelAdmin()) {
            return $this->redirectWithError();
        }
        if (! $this->checkMStatusAdmin()) {
            return $this->redirectWithError();
        }

        return $next($request);
    }

    //check role for admin
    private function checkMStatusAdmin(): bool
    {
        return auth('admin')->user()->mStatus == Member::M_STATUS_NINE;
    }

    private function checkMLevelAdmin(): bool
    {
        return in_array(auth('admin')->user()->mLevel, Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE);
    }

    private function redirectWithError(string $message = '')
    {
        auth()->logout();
        return redirect()->route('admin.page-login')->withErrors("Can't Login because your account have a few issue!");
    }
}
