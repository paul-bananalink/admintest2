<?php

namespace App\Services\GraphQL;

use App\Events\Client\CountNotificationEvent;
use App\Events\Client\StatusMemberEvent;
use App\Models\Member;
use App\Repositories\MemberRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\BaseService;
use App\Repositories\MemberConfigRepository;
use App\Services\StatusMemberService;

class MemberService extends BaseService
{
    const DEFAULT_STATUS = 1;

    const MAX_WRONG_PW_COUNT = 2;

    const DEFAULT_MAX_WRONG_PW_COUNT = 0;

    const DEFAULT_LEVEL = 1;

    const TEMP_BLOCK_STATUS = 8;

    public function __construct(
        private MemberRepository $memberRepository,
        private MemberConfigRepository $memberConfigRepository,
        private StatusMemberService $statusMemberService
    ) {
    }

    public function login(array $attributes = [])
    {
        if (empty($attributes)) {
            return [];
        }

        $attempt = Auth::guard('admin')->attempt([
            'mID' => data_get($attributes, 'mID'),
            'password' => data_get($attributes, 'mPW'),
        ]);

        if ($attempt) {
            $member = Auth::guard('admin')->user();
            $this->triggerLoginSuccess($member);
        } else {
            $this->triggerLoginFailed(data_get($attributes, 'mID'));
        }

        return $member ?? null;
    }

    public function register(array $attributes = []) : ?Member
    { 
        if (empty($attributes)) {
            return [];
        }
        $pw = data_get($attributes, 'password');
        if (empty($pw)) {
            return null;
        }

        $attributes['mStatus'] = self::DEFAULT_STATUS;
        $attributes['mLevel'] = self::DEFAULT_LEVEL;
        $attributes['mPW'] = $pw;

        $member = $this->memberRepository->create($attributes);

        event(new CountNotificationEvent('member'));

        event(new StatusMemberEvent($member));

        return $member;
    }

    public function logout()
    {
        Auth::logout();
    }

    private function triggerLoginFailed($mId): void
    {
        $member = $this->memberRepository->getFirstWithConditions([['mID', $mId]]);
        if ($member) {
            $count = $member->mWrongPWCount ?? 0;
            $member->mWrongPWCount = ++$count;
            if ($member->mStatus !== self::TEMP_BLOCK_STATUS && $count > self::MAX_WRONG_PW_COUNT) {
                $member->mStatus = self::TEMP_BLOCK_STATUS;
            }
            $member->save();
        }
    }

    private function triggerLoginSuccess($member): void
    {
        $member->mWrongPWCount = self::DEFAULT_MAX_WRONG_PW_COUNT;
        $member->mLoginDateTime = now();
        $member->save();
    }
}
