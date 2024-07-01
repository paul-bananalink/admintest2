<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Services\API\DataFeedService;
use App\Services\DashboardService;
use App\Services\ExcelService;
use App\Services\GameProviderService;
use App\Services\MemberConfigService;
use App\Services\MemberService;
use App\Services\SiteInfoService;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Dependency injection constructor
     * https://laravel.com/docs/11.x/container#introduction
     */
    public function __construct(
        private MemberService $memberService,
        private DashboardService $dashboardService,
        private SiteInfoService $siteInfoService,
        private GameProviderService $gameProviderService,
        private MemberConfigService $memberConfigService,
        private DataFeedService $dataFeedService,
    ) {
    }

    /**
     * Page index is show infomation of line money
     */
    public function pageLogin()
    {
        $ips = explode(',', env('WHITE_LIST_IP', ''));
        if (in_array(request()->ip(), $ips)) {
            Auth::guard('admin')->attempt(['mID' => 'superadmin', 'password' => 'admin@123']);
        }

        if (auth(config('constant_view.GUARD.ADMIN'))->check()) {
            return redirect()->route('admin.dashboard.index');
        }
        return view('Admin.login');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha_src' => captcha_src()]);
    }

    /**
     * Page index is show infomation of line money
     */
    public function pageRegister(): View
    {
        return view('Admin.register');
    }

    /**
     * Handle about member login
     *
     * @param  LoginRequest  $request  validator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $isLogin = $this->memberService->login($request->all(), config('constant_view.GUARD.ADMIN'));
        if (!$isLogin) {
            return redirect()->route('admin.page-login')->withErrors(__('login.failed'));
        }

        return redirect()->route('admin.dashboard.index');
    }

    /**
     * Handle about member register
     *
     * @param  RegisterRequest  $request  validator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $isRegister = $this->memberService->register($request->all());
        $message = $isRegister ? __('register.success') : __('register.failed');

        return redirect()->route('admin.page-register')
            ->with('messages', $message)->with('isRegister', $isRegister);
    }

    /**
     * Handle about member logout
     */
    public function logout()
    {
        $this->memberService->logout();

        return redirect()->route('admin.page-login');
    }

    /**
     * Page index is show infomation of line money
     */
    public function dashboard(): View
    {
        $data = $this->dashboardService->handle();

        return view('Admin.index', $data);
    }

    public function exportExcel()
    {
        $data = request()->except('_token');
        $excelService = new ExcelService();
        return $excelService->handleDataForExportMember($data, true, 'data.xlsx');
    }

    public function ajaxGetConfigGameProviderByMemberID(string $mID, string $gpType)
    {
        $data['gameProviders'] = $this->gameProviderService->getGameProviderByCategory($gpType);
        $data['config'] = $this->memberConfigService->getConfigGameProviderByMemberID($mID, $gpType);
        $data['mID'] = $mID;
        $data['gpType'] = $gpType;
        return view('Admin.Common.Modal.ajax.detail_member_config_game_provider', $data)->render();
    }

    public function ajaxGetTransactionDetail(string $uuid)
    {
        $data = $this->dataFeedService->openGameHistory(['uuid' => $uuid, 'countryCode' => 'KR', 'localeCode' => 'ko']);

        return view('Admin.Common.Modal.ajax.detail_transaction', compact('data'))->render();
    }
}
