<?php

namespace App\Services;

use App\Events\Admin\AdminLogoutEvent;
use App\Events\Admin\ManangerMemberLoginEvent;
use App\Events\Client\MemberAccessEvent;
use App\Events\Client\MemberLogoutEvent;
use App\Exceptions\GraphQLException;
use App\Models\Member;
use App\Models\MemberEnvironment;
use App\Models\MoneyInfo;
use App\Repositories\MemberEnvironmentRepository;
use App\Repositories\MemberLoginFailedRepository;
use App\Repositories\MemberRepository;
use App\Rules\CheckMPhoneVaild;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MemberService extends BaseService
{
    private MemberRepository $memberRepository;
    private MemberAccessService $memAccessService;
    private SiteInfoService $siteService;
    private MemberLoginFailedRepository $memberLoginFailed;
    private MemberEnvironmentRepository $memberEnvironmentRepository;

    public function __construct()
    {
        $this->memberRepository = new MemberRepository;
        $this->memAccessService = new MemberAccessService;
        $this->siteService = new SiteInfoService;
        $this->memberLoginFailed = new MemberLoginFailedRepository;
        $this->memberEnvironmentRepository = new MemberEnvironmentRepository;
    }

    public function countMembersRegisteredToday()
    {
        return $this->memberRepository->getCountMemberRegisterByDate(now()->today());
    }

    public function getCountMemberRegisterApprovedToday()
    {
        return $this->memberRepository->getCountMemberRegisterApprovedToday();
    }

    /**
     * Handle login Admin & Guest
     *
     * @param  array  $attributes  from request validated
     */
    public function login(array $attributes = [], ?string $guard = null): bool
    {
        if (empty($attributes) || is_null($guard)) {
            return false;
        }

        //handle admin
        if ($guard == config('constant_view.GUARD.ADMIN')) {
            return $this->loginAdmin($attributes, $guard);
        }

        if ($guard == config('constant_view.GUARD.PARTNER')) {
            return $this->loginPartner($attributes, $guard);
        }

        //handle guest
        return $this->loginGuest($attributes, $guard);
    }

    public function register(array $attributes = []): bool
    {
        if (empty($attributes)) {
            return false;
        }

        return true;
    }

    public function updatePassword(array $attributes): bool
    {
        $new_password = data_get($attributes, 'new_password');

        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        $status = $this->memberRepository->updateByPK($member, ['mPW' => $new_password]);
        $member->tokens()->delete();

        return $status;
    }

    public function hasMember($attributes): bool
    {
        $conditions = [];

        if ($mID = data_get($attributes, 'mID')) {
            array_push($conditions, ['mID', $mID]);
        }

        if ($mNick = data_get($attributes, 'mNick')) {
            array_push($conditions, ['mNick', $mNick]);
        }

        if ($mID = data_get($attributes, 'member_invite')) {
            return true;
        }

        if (empty($conditions)) {
            return false;
        }

        return !empty($this->memberRepository->getFirstWithConditions($conditions));
    }

    /**
     * Logout by key session, It exist in session
     *
     * @return void
     */

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
    }

    public function logoutApi(): void
    {
        $member = Auth::user();
        $this->memAccessService->memberLogout($member->mNo);
        $member->tokens()->delete();
        event(new \App\Events\Client\MemberLoggedOut($member));
    }

    /**
     * Get token access key by guard
     */
    public function getTokenAccessLogin(string $guard = 'admin'): ?string
    {
        $expires_at = now()->addMinutes(app('site_info')->siTimeOUt ?? 120);

        return Auth::guard($guard)->user()->createToken(uniqid(), expiresAt: $expires_at)->plainTextToken;
    }

    public function countMemberPending(): int
    {
        return $this->memberRepository->countWithConditions(['where' => [['mStatus', Member::M_STATUS_ONE]]]);
    }

    public function getSumMoneyAllMember(): float
    {
        return $this->memberRepository->getSumMoneyAllMember();
    }

    /**
     * Handle trigger login failed
     */
    public function triggerLoginFailed(?string $m_id = null): void
    {
        if (empty($m_id)) {
            return;
        }

        $member = $this->memberRepository->getFirstWithConditions([['mID', $m_id]]);
        if (empty($member) || $member->mLevel == Member::M_LEVEL_ADMIN_MA) {
            return;
        }

        $dataUpdate = [
            'mWrongPWCount' => $member->mWrongPWCount + 1 ?? 1,
        ];

        if ($member->mStatus == Member::M_STATUS_NINE) {
            if ($member->mLevel != Member::M_LEVEL_ADMIN_MA) {
                $this->memberLoginFailed->createMemberLoginFailed(['m_id' => $m_id]);
            }

            if ($member->mWrongPWCount > Member::COUNT_MAX_PASS_WRONG) {
                $dataUpdate['mStatus'] = Member::M_STATUS_EIGHT;

                // Check if enable auto block ip in site config then block ip
                $site = app('site_info');
                if ($site->siAutoBlockIp) {
                    $this->siteService->blockIpSetting(['mdiIp' => request()->ip()]);
                    $this->memberLoginFailed->blockMemberList(['m_id' => $m_id]);
                }
            }
        }
        $this->tryCatchFuncDB(fn () => $this->memberRepository->updateByPK($member, $dataUpdate));
    }

    /**
     * Exchanges money from one wallet to another.
     *
     * @param string $from The wallet to exchange money from.
     * @param string $to The wallet to exchange money to.
     * @param float $amount The amount of money to exchange.
     * @return Member The updated member object.
     */
    public function exchangeMoney($from, $to, $amount)
    {
        /** @var Member */
        $member = auth()->user();

        $this->tryCatchFuncDB(function () use ($member, $from, $to, $amount) {
            $form_wallet = Member::MEMBER_WALLETS[$from];
            $to_wallet = Member::MEMBER_WALLETS[$to];

            $member->{$form_wallet} -= $amount;
            $member->{$to_wallet} += $amount;
            $member->save();

            $member->money_infos()->createMany([
                $this->initExchangeMoneyInfo($member, $amount * -1, $from),
                $this->initExchangeMoneyInfo($member, $amount, $to),
            ]);
        });

        return $member;
    }

    public function updatePosition(array $attributes)
    {
        try {
            $member = auth('sanctum')->user();
            $this->memberRepository->updateByPK($member, ['mPosition' => $attributes['position']]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * -------------------------PRIVATE FUNCTION-------------------------
     */

    /**
     * Handle login admin
     *
     * @param  array  $attributes  from request validated
     */
    private function loginAdmin(array $attributes = [], string $guard = 'admin'): bool
    {
        /** @var Auth */
        $auth = Auth::guard($guard);

        $credentials = [
            'mID' => $attributes['member_id'],
            'password' => $attributes['member_password'],
            'mStatus' => Member::M_STATUS_NINE,
            fn (Builder $query) => $query->whereIn('mLevel', Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE),
        ];

        if ($auth->attempt($credentials)) {
            $this->triggerLoginSuccess($guard);
            $auth->logoutOtherDevices($attributes['member_password']);
            $member = $auth->user();
            if ($member->mLevel != Member::M_LEVEL_ADMIN_MA) {
                return $member->member_allow_ip()->where('maiIp', request()->ip())->exists();
            }
            return true;
        } else {
            $this->triggerLoginFailed($attributes['member_id']);
            return false;
        }
    }

    private function loginPartner(array $attributes = [], string $guard = 'partner'): bool
    {
        /** @var Auth */
        $auth = Auth::guard($guard);

        $credentials = [
            'mID' => $attributes['member_id'],
            'password' => $attributes['member_password'],
            'mStatus' => Member::M_STATUS_NINE,
            'mIsPartner' => Member::PARTNER,
            fn (Builder $query) => $query->whereNotIn('mLevel', Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE),
        ];

        if ($auth->attempt($credentials)) {
            $this->triggerLoginSuccess($guard);
            $auth->logoutOtherDevices($attributes['member_password']);
            return true;
        } else {
            $this->triggerLoginFailed($attributes['member_id']);
            return false;
        }
    }

    private function loginGuest(array $attributes = [], string $guard = 'guest'): bool
    {
        /** @var Auth */
        $auth = Auth::guard($guard);

        $credentials = [
            'mID' => $attributes['mID'],
            'password' => $attributes['mPW'],
            fn (Builder $query) => $query->whereNotIn('mLevel', Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE),
        ];

        if ($auth->attemptWhen($credentials, function (Member $member) {
            return $this->checkStatusMember($member);
        })) {
            $this->triggerLoginSuccess($guard);
            return true;
        } else {
            $this->triggerLoginFailed($attributes['mID']);
            return false;
        }
    }

    /**
     * Check mStatus of table member
     *
     * @return bool|GraphQLException
     */
    // M_LEVEL_ADMIN_MA
    private function checkStatusMember($member): bool
    {
        if (empty($member)) {
            return false;
        }

        // $m_phone = $member->mPhone;
        // $phoneValidator = new CheckMPhoneVaild($m_phone);

        $success = true;
        if ($member->memberConfig->mcForceLogout) {
            $message = app('site_info')->siBlockedMemberLoginMessage;
            $reason = '탈퇴';
            $success = false;
        } elseif ($member->mStatus == Member::M_STATUS_EIGHT) {
            $message = app('site_info')->siBlockedMemberLoginMessage;
            $reason = '차단';
            $success = false;
        } elseif ($member->memberConfig->mcIsAlbagi) {
            $message = app('site_info')->siBlockedMemberLoginMessage;
            $reason = '알박이';
            $success = false;
        } elseif ($member->mStatus == Member::M_STATUS_ONE) {
            $message = __('login.pending');
            $reason = '대기';
            $success = false;
        }

        // $phoneValidator->validate('mPhone', $m_phone, function ($msg) use (&$success, &$message, &$reason) {
        //     $message = app('site_info')->siBlockedMemberLoginMessage;
        //     $reason = '회원 전화번호가 차단되였습니다.'; //Block member phone numbers
        //     $success = false;
        // });

        if (!$success) {
            $member->loginFailed()->create([
                'mID' => $member->mID,
                'mlfOS' => request()->header('User-Agent'),
                'mlfIP' => request()->ip(),
                'mlfRegDate' => now(),
                'mlfReason' => $reason,
            ]);
            $this->triggerLoginFailed($member->mID);

            throw new GraphQLException($message);
        }

        return $success;
    }

    /**
     * Handle trigger login Success
     */
    private function triggerLoginSuccess(string $guard = 'admin'): void
    {
        $member = auth($guard)->user();
        $now = now();

        if (in_array($member->mLevel, Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)) {
            $this->runEvent(new AdminLogoutEvent($member->mNo));
        } else {
            $this->runEvent(new MemberLogoutEvent($member->mNo));
        }

        if (($guard != config('constant_view.GUARD.ADMIN') || $guard != config('constant_view.GUARD.PARTNER'))) {
            $this->runEvent(new MemberAccessEvent($member->mID, [
                'mID' => $member->mID,
                'member_id' => $member->mID,
                'ip' => request()->ip(),
                'login_date' => $now,
                'member_header_access' => request()->header('user-agent', ''),
            ]));
            $this->runEvent(new ManangerMemberLoginEvent());

            event(new \App\Events\Client\MemberLoggedIn($member));

            $this->memberEnvironmentRepository->create([
                'mID' => $member->mID,
                'meType' => MemberEnvironment::ME_TYPE_LOGIN,
                'meIP' => request()->ip(),
                'meDeviceID' => request()->header('user-agent', ''),
                'meOS' => '',
            ]);
        }

        $dataUpdate = [
            'mLoginDateTime' => $now,
            'mWrongPWCount' => 0
        ];
        if ($member->mWrongPWCount != Member::COUNT_DEFAULT_PASS_WRONG) {
            $dataUpdate['mWrongPWCount'] = Member::COUNT_DEFAULT_PASS_WRONG;
        }

        $this->tryCatchFuncDB(fn () => $this->memberRepository->updateByPK(auth($guard)->user(), $dataUpdate));
    }

    /**
     * Init data for exchange money
     */
    private function initExchangeMoneyInfo(Member $member, int $moneyAmount, string $wallet): array
    {
        return [
            'miType' => MoneyInfo::TYPE_EM,
            'miStatus' => MoneyInfo::STATUS_NINE,
            'miBankMoney' => $moneyAmount,
            'miBankName' => $member->mBankName,
            'miBankNumber' => $member->mBankNumber,
            'miBankOwner' => $member->mBankOwner,
            'miWallet' => $wallet,
        ];
    }

    public function updateFirstLogin($member)
    {
        $this->memberRepository->updateByPK($member, ['mIsFirstLogin' => 1]);
    }
}
