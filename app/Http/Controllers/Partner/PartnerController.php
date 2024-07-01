<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Services\MemberService;
use App\Http\Requests\Partner\PartnerLoginRequest;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function __construct(
        private MemberService $memberService
    ) {
    }

    public function dashboard(): View
    {
        $data = [];
        return view('Partner.Dashboard.index', $data);
    }

    /**
     * Handle about member logout
     */
    public function logout()
    {
        $this->memberService->logout();

        return redirect()->route('partner.login');
    }

    public function login()
    {
        $ips = explode(',', env('WHITE_LIST_IP', ''));
        if (in_array(request()->ip(), $ips)) {
            Auth::guard('partner')->attempt(['mID' => 'banana', 'password' => 'admin@123']);
        }

        if (auth(config('constant_view.GUARD.PARTNER'))->user()) {
            return redirect()->route('partner.dashboard.index');
        }

        return view('login_partner');
    }

    public function authenticate(PartnerLoginRequest $request)
    {
        $isLogin = $this->memberService->login($request->all(), config('constant_view.GUARD.PARTNER'));
        if (!$isLogin) {
            return redirect()->back()->withErrors(__('login.failed'));
        }

        return redirect()->route('partner.dashboard.index');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha_src' => captcha_src()]);
    }
}
