<?php

namespace App\Services;

use App\Events\Admin\CountMemberRegist;
use App\Events\Client\StatisticMoneyEvent;
use App\Models\Member;
use App\Models\MemberEnvironment;
use App\Repositories\ConsultationRepository;
use App\Repositories\GameProviderRepository;
use App\Repositories\GameRepository;
use App\Repositories\MemberRepository;
use App\Repositories\MembersLoginRepository;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\MemberConfigRepository;
use App\Repositories\MemberEnvironmentRepository;
use App\Services\GraphQL\NoteService;
use App\Repositories\PartnerRepository;
use Illuminate\Support\Facades\Cache;

class StatusMemberService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private MembersLoginRepository $memLoginRepo,
        private MemberRepository $memRepo,
        private MemberAccessService $memAccessService,
        private MoneyInfoService $moneyInfoService,
        private GameProviderRepository $gameProviderRepo,
        private GameRepository $gameRepo,
        private MemberConfigRepository $memberConfigRepository,
        private NoteService $noteService,
        private PartnerRepository $partnerRepository,
        private MemberEnvironmentRepository $memberEnvironmentRepository,
        private ConsultationRepository $consultationRepo
    ) {
    }

    /**
     * Update account member by admin
     *
     * @param int $id primary key (mNo) of table member
     * @param array $attributes request from validated
     * @return bool
     */
    public function updateMember(int $id, array $attributes = []): bool
    {

        if (empty($id) || empty($attributes)) {
            return false;
        }
        $data = $this->initDataUpdateMember($attributes);
        $dataConfig = $this->initDataUpdateMemberConfig($attributes);

        return $this->tryCatchFuncDB(function () use ($id, $data, $dataConfig) {
            $this->memRepo->updateByPK($id, $data);
            $member = $this->memRepo->getByPK($id);
            $member->memberConfig()->update($dataConfig);
        });
    }

    public function banByField(string $field, int $id): bool
    {
        if (empty($field) || empty($id)) {
            return false;
        }

        $member = $this->memRepo->getByPK($id);
        $member->{$field} = !$member->{$field};
        $member->save();

        return true;
    }

    public function updateGameList($game, $id)
    {
        $member = $this->memRepo->getByPK($id);
        if (empty($member)) {
            return false;
        }

        $bannedGames = $member->mBanGames ?? [];
        if (in_array($game, $bannedGames)) {
            $bannedGames = array_diff($bannedGames, [$game]);
        } else {
            $bannedGames[] = $game;
        }

        return $this->memRepo->updateByPK($id, ['mBanGames' => $bannedGames]);
    }

    public function updateProviderList($provider, $id)
    {
        $member = $this->memRepo->getByPK($id);
        if (empty($member)) {
            return false;
        }

        $bannedProviders = $member->mBanProviders ?? [];
        if (in_array($provider, $bannedProviders)) {
            $bannedProviders = array_diff($bannedProviders, [$provider]);
        } else {
            $bannedProviders[] = $provider;
        }

        return $this->memRepo->updateByPK($id, ['mBanProviders' => array_values($bannedProviders)]);
    }

    public function getMemberById(int $id)
    {
        return $this->memRepo->getByPK($id);
    }

    public function checkMemberId(): bool
    {
        return $this->memRepo->isUniqueMemberID(request('mMemberId'));
    }

    public function checkPartnerCode(): bool
    {
        return $this->memRepo->isPartnerCode(request('mPartnerCode'));
    }

    public function checkMemberNick(string $m_nick = '', $unique = false): bool
    {
        return !$this->memRepo->isMemberNick($m_nick);
    }

    /**
     * Create member to db
     *
     * @param array $attributes from request validated
     * @return ?Member|bool
     */
    public function createMember(array $attributes = [])
    {
        if (empty($attributes)) {
            return false;
        }

        $data = $this->initDataCreateMember($attributes);
        $member = $this->memRepo->create($data);
        $partner = $this->getPartnerByCode($attributes['mPartnerCode']);

        $member->mMemberID = $partner->mID;
        $member->save();

        $this->memberEnvironmentRepository->create([
            'mID' => $member->mID,
            'meType' => MemberEnvironment::ME_TYPE_REGISTER,
            'meIP' => request()->ip(),
            'meDeviceID' => request()->header('user-agent', ''),
            'meOS' => '',
        ]);

        if ($member) {
            $this->runEvent(new CountMemberRegist());
            $this->runEvent(new StatisticMoneyEvent($this->moneyInfoService->getAllTotalMoney()));
        }

        return $member;
    }

    private function getPartnerByCode(string $mPartnerCode): ?Member
    {
        $partner = Member::where('mPartnerCode', $mPartnerCode)->first();

        return $partner;
    }
    public function initDataUpdateMemberConfig(array $attr)
    {
        return [
            'mcSinglePoleAmount' => data_get($attr, 'mcSinglePoleAmount', null),
            'mcMultiPoleAmount' => data_get($attr, 'mcMultiPoleAmount', null),
            'mcSuspicion' => data_get($attr, 'mcSuspicion', null),

            'mcRollingCasinoRate' => convertFloat(data_get($attr, 'mcRollingCasinoRate')),
            'mcLossCasinoRate' => convertFloat(data_get($attr, 'mcLossCasinoRate')),
            'mcRollingSlotRate' => convertFloat(data_get($attr, 'mcRollingSlotRate', null)),
            'mcLossSlotRate' => convertFloat(data_get($attr, 'mcLossSlotRate', null)),

            'mcMaxWinCasinoMoney' => convertFloat(data_get($attr, 'mcMaxWinCasinoMoney')),
            'mcMaxWinSlotMoney' => convertFloat(data_get($attr, 'mcMaxWinSlotMoney')),
            'mcPublicBettingSlot' => convertFloat(data_get($attr, 'mcPublicBettingSlot', null)),
            'mcPublicBettingCasino' => convertFloat(data_get($attr, 'mcPublicBettingCasino', null))
        ];
    }

    /**
     * Get list member to show for page status member
     *
     * @param array $attributes from request
     * @return array
     */
    public function getStatusMemberAccess(array $attributes = []): array
    {
        //convert to field
        $order_by = $this->convertToFieldDB(data_get($attributes, 'orderBy', 'mRegDate'));
        //get sort field
        $sort = data_get($attributes, 'sort', config('constant_view.QUERY_DATABASE.DESC'));

        //get count load to view
        $total = $this->initTotal('mRegDate');

        if (data_get($attributes, 'member_logged_by_days', false)) // click button [days]일 미접속회원
        {
            $select_days_member_logged = data_get($attributes, 'select_days_member_logged', 5);
            if (Cookie::get('select_days_member_logged', 5) != $select_days_member_logged) {
                Cookie::queue(Cookie::forever('select_days_member_logged', $select_days_member_logged));
            }

            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberLoggedByDays($select_days_member_logged, $order_by, $sort);
        } elseif (data_get($attributes, 'member_status_normal')) // click button 정상
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberStatusNormal($order_by, $sort);
        } elseif (data_get($attributes, 'member_status_pending')) // click button 대기
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberStatusPending($order_by, $sort);
        } elseif (data_get($attributes, 'member_status_stop')) // click button 중지
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberStatusStop($order_by, $sort);
        } elseif (data_get($attributes, 'member_status_black_list')) // click button 블랙리스트
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberStatusBlackList($order_by, $sort);
        } elseif (data_get($attributes, 'member_top_200_profit')) // click button + 탑200
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberTop200Profit($order_by, $sort);
        } elseif (data_get($attributes, 'member_bottom_200_profit')) // click button - 탑200
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberBottom200Profit($order_by, $sort);
        } elseif (data_get($attributes, 'test_member')) // click button 테스트유저 비노출
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getTestMember($order_by, $sort);
        } elseif (data_get($attributes, 'member_cash_casino')) // click button search
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberCashCasino($order_by, $sort);
        } elseif (data_get($attributes, 'btn_submit')) // click button search
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->handleQuerySearch($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'mc_bool')) // click button search
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getDataByConfig($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'mc_suspicion')) // click button search
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getDataByConfigNotNull($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'member_online')) // click button 블랙리스트
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberOnline($order_by, $sort);
        } else // First loading list member
        {
            [
                'members' => $members,
                'total_money' => $total_money,
            ] = $this->getMemberStatusAll($order_by, $sort);
        }

        return compact(
            'members',
            'total_money',
            'total',
        );
    }

    public function resetPass(?int $id = null): void
    {
        if (empty($id)) {
            return;
        }

        $this->tryCatchFuncDB(fn () => $this->memRepo->updateByPK($id, [
            'mWrongPWCount' => Member::COUNT_DEFAULT_PASS_WRONG,
        ]));
    }

    /**
     * Set mStatus member normal by Admin
     *
     * @param int $id
     * @return void
     */
    public function statusMemberNormal(?int $id = null): void
    {
        if (empty($id)) {
            return;
        }
        $mem = $this->memRepo->getByPK($id);
        if (!$mem) {
            return;
        }
        $data = [
            'mStatus' => Member::M_STATUS_NINE,
        ];
        if (data_get($mem, 'mStatus') == Member::M_STATUS_ONE) {
            $this->noteService->sendNoteToUser($mem->mNo);
            $data['mApproveRegDate'] = now();
        }
        if ($this->tryCatchFuncDB(fn () => $this->memRepo->updateByPK($mem, $data))) {
            //$mem => The object has not refreshed , not run it $mem->refresh()
            if (data_get($mem, 'mStatus') == Member::M_STATUS_ONE) $this->runEvent(new CountMemberRegist());
        }
        $this->runEvent(
            new CountMemberRegist()
        );
    }

    /**
     * Set mStatus member suspended by Admin
     *
     * @param int $id
     * @return void
     */
    public function statusMemberStop(?int $id = null): void
    {
        if (empty($id)) {
            return;
        }

        $this->tryCatchFuncDB(function () use ($id) {
            $this->memAccessService->memberLogout($id, config('constant_view.EVENTS.TURN_ON_EVENT'));

            $this->memRepo->updateByPK($id, [
                'mStatus' => Member::M_STATUS_EIGHT,
            ]);
        });
    }

    /**
     * Set mStatus member suspended by Admin
     *
     * @param int $id
     * @return void
     */
    public function updateStatusMember(int $id, string $type, bool $value): array|bool
    {
        if (empty($id)) {
            return false;
        }

        $mem = $this->memRepo->getByPK($id);
        if (!$mem) {
            return false;
        }

        if ($type == 'block') {
            $data = [
                'mStatus' => $value ? Member::M_STATUS_EIGHT : Member::M_STATUS_NINE,
            ];
            $this->tryCatchFuncDB(function () use ($id, $data) {
                $this->memAccessService->memberLogout($id, config('constant_view.EVENTS.TURN_ON_EVENT'));

                $this->memRepo->updateByPK($id, $data);
            });
        }

        if ($type == 'enable') {
            $data = [
                'mStatus' => $value ? Member::M_STATUS_NINE : Member::M_STATUS_EIGHT,
            ];
            if (data_get($mem, 'mStatus') == Member::M_STATUS_ONE) {
                $this->noteService->sendNoteToUser($mem->mNo);
                $data['mApproveRegDate'] = now();
            }
            if ($this->tryCatchFuncDB(fn () => $this->memRepo->updateByPK($mem, $data))) {
                //$mem => The object has not refreshed , not run it $mem->refresh()
                if (data_get($mem, 'mStatus') == Member::M_STATUS_ONE) $this->runEvent(new CountMemberRegist());
            }

            $this->runEvent(
                new CountMemberRegist()
            );
        }

        $mem->refresh();

        return [
            'is_active' => $mem->mStatus == Member::M_STATUS_NINE,
        ];
    }

    public function forceLogout(?int $id = null)
    {
        if (empty($id)) {
            return;
        }

        $member = $this->memRepo->getByPK($id);
        if ($member->memberConfig->mcForceLogout) {
            $member->memberConfig()->update([
                'mcForceLogout' => false,
            ]);
        } else {
            $this->tryCatchFuncDB(function () use ($id, $member) {
                $this->memAccessService->memberLogout($id, config('constant_view.EVENTS.TURN_ON_EVENT'));
                $member->memberConfig()->update([
                    'mcForceLogout' => true,
                ]);
            });
            $this->runEvent(
                new CountMemberRegist()
            );
        }
    }

    /**
     * Delete member on DB
     *
     * @param int $id
     * @return void
     */
    public function deleteMember(?int $id = null): void
    {
        if (empty($id)) {
            return;
        }

        $this->tryCatchFuncDB(function () use ($id) {
            $this->memAccessService->memberLogout($id, config('constant_view.EVENTS.TURN_ON_EVENT'));
            $this->memRepo->deleteByPK($id);
        });
    }

    public function updateMemberConfig($attributes)
    {
        $member = $this->memRepo->getByPK(data_get($attributes, 'mNo'));

        if (empty($member)) {
            return false;
        }

        $data = [
            'mID' => data_get($attributes, 'mID'),
            'mLevel' => data_get($attributes, 'mLevel'),
            'mNick' => data_get($attributes, 'mNick'),
            'mStatus' => data_get($attributes, 'mStatus'),
            'mNote' => data_get($attributes, 'mNote'),
            'mBankOwner' => data_get($attributes, 'mBankOwner'),
            'mBankExchangePW' => data_get($attributes, 'mBankExchangePW'),
            'mBankName' => data_get($attributes, 'mBankName'),
            "mBankNumber" => data_get($attributes, 'mBankNumber'),
        ];

        if (!empty($attributes['mPW'])) {
            $data['mPW'] = Hash::make($attributes['mPW']);
        }

        return $this->memRepo->updateByPK($member, $data);
    }

    public function resetPassword($id)
    {
        $member = $this->memRepo->getByPK($id);
        if (empty($member)) {
            return false;
        }

        return $this->memRepo->updateByPK($id, ['mPW' => Hash::make(config('constant_view.DEFAULT_PASSWORD'))]);
    }

    public function createOrUpdateMember($attributes)
    {
        $mNo = data_get($attributes, 'mNo');
        if (empty($mNo)) {
            $member = $this->createMember($attributes);
            $status = (bool)$member;
        } else {
            $status = $this->updateMember($mNo, $attributes);
            $member = $this->memRepo->getByPK($mNo);
        }
        return [
            'status' => $status,
            'member' => $member,
            'partner' => $member->partner,
        ];
    }

    /**
     * ----------------------------------PRIVATE FUNCTION----------------------------------
     */

    private function initTotal(mixed $order_by = ''): array
    {
        $data = [];
        [
            'members' => $members,
        ] = $this->getMemberLoggedByDays(request('select_days_member_logged', Cookie::get('select_days_member_logged', 5)), $order_by);
        $data['total_member_logged_by_day'] = $members->total();

        [
            'members' => $members,
        ] = $this->getMemberStatusAll($order_by);
        $data['total_member_status_all'] = $members->total();

        [
            'members' => $members,
        ] = $this->getMemberStatusNormal($order_by);
        $data['total_member_status_normal'] = $members->total();

        [
            'members' => $members,
        ] = $this->getMemberStatusPending($order_by);
        $data['total_member_status_pending'] = $members->total();

        [
            'members' => $members,
        ] = $this->getMemberStatusStop($order_by);
        $data['total_member_status_stop'] = $members->total();

        [
            'members' => $members,
        ] = $this->getMemberStatusBlackList($order_by);
        $data['total_member_status_black_list'] = $members->total();

        [
            'members' => $members,
        ] = $this->getMemberTop200Profit($order_by);
        $data['total_member_top_200_profit'] = $members->total();

        [
            'members' => $members,
        ] = $this->getMemberBottom200Profit($order_by);
        $data['total_member_bottom_200_profit'] = $members->total();

        [
            'members' => $members,
        ] = $this->getTestMember($order_by);
        $data['test_member'] = $members->total();

        return $data;
    }

    /**
     * get Member status black list
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getTestMember(mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['m_status' => [Member::M_STATUS_TEST]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member top 200 profit
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberTop200Profit(mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['profit_member' => ['profit_member_count' => 200, 'profit_member_sort' => config('constant_view.QUERY_DATABASE.DESC')]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member top 200 profit
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberBottom200Profit(mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['profit_member' => ['profit_member_count' => 200, 'profit_member_sort' => config('constant_view.QUERY_DATABASE.ASC')]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member cash casino
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberCashCasino(mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['cash_casino' => true],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );

        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member status black list
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberStatusBlackList(mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['m_status' => [Member::M_STATUS_SEVEN]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member status stop
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberStatusStop(mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['m_status' => [Member::M_STATUS_EIGHT]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member status pending
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberStatusPending(mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['m_status' => [Member::M_STATUS_ONE]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member status normal
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberStatusNormal(mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['m_status' => [Member::M_STATUS_NINE]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member status all
     *
     * @param mixed|string $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberStatusAll(mixed $order_by = '', string $sort = 'desc'): array
    {

        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['m_status' => array_keys(Member::STATUS_MEMBER_TO_STRING)],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    private function getMemberOnline(mixed $order_by = '', string $sort = 'desc'): array
    {
        $onlineMembers = $this->memRepo->getOnlineMembers()['onlineMembers'];
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['member_online' => [...$onlineMembers]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $onlineMembers ? $members : [],
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * get Member logged in 5 days
     *
     * @param int $days = 5
     * @param mixed $order_by
     * @param string $sort
     * @return array
     */
    private function getMemberLoggedByDays(int $days = 5, string $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['logged_from' => $days ? now()->subDays($days)->endOfDay() : null],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * Handle query search when has key search
     *
     * @param array $attributes conditions
     * @param mixed|string $order_by,
     * @param string $sort (desc)
     * @return array
     */
    private function handleQuerySearch(
        array $attributes = [],
        mixed $order_by = 'mRegDate',
        string $sort = 'desc',
    ): array {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['filter' => [
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
                'column' => $this->convertToFieldDB(data_get($attributes, 'select_field_search', config('constant_view.VIEW.SELECT_ALL_FIELD'))),
                'search' => data_get($attributes, 'search', null),
            ]],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    /**
     * Field name on html convert to field on DB
     *
     * @param string|mixed $key
     * @return string|mixed
     */
    private function convertToFieldDB(string $key = 'm_register_date')
    {
        if ($key == config('constant_view.VIEW.SELECT_ALL_FIELD')) {
            return $key;
        }

        if ($key == 'm_id') return 'mID';
        elseif ($key == 'm_nick') return 'mNick';
        elseif ($key == 'm_real_name') return 'mRealName';
        elseif ($key == 'm_bank_number') return 'mBankNumber';
        elseif ($key == 'm_bank_owner') return 'mBankOwner';
        elseif ($key == 'm_phone') return 'mNick';
        elseif ($key == 'm_money') return 'mMoney';
        elseif ($key == 'm_register_date' || $key == 'mRegDate') return 'mRegDate';
        elseif ($key == 'm_money_last_update') return 'mMoneyLastUpdate';
        elseif ($key == 'm_login_date_time') return 'mLoginDateTime';
        elseif ($key == 'm_point') return 'mPoint';
        elseif ($key == 'm_partner') return 'mMemberID';
        elseif ($key == 'm_member_invite') return 'mMemberID';
        elseif ($key == 'm_level') return 'mLevel';
        elseif ($key == 'm_ip') return 'mLoginIP';
        elseif ($key == 'm_phone') return 'mPhone';
        elseif ($key == 'm_note') return 'mNote';
        elseif ($key == 'm_bank_name') return 'mBankName';
        elseif ($key == 'm_sports_money') return 'mSportsMoney';
        elseif ($key == 'mi_type_UD_AD') return DB::raw("(SELECT COALESCE(SUM(miBankMoney), 0) FROM money_info WHERE miStatus = 9 AND miType IN ('UD', 'AD') AND member.mID = money_info.mID)");
        elseif ($key == 'mi_type_UW_AW') return DB::raw("(SELECT COALESCE(SUM(miBankMoney), 0) FROM money_info WHERE miStatus = 9 AND miType IN ('UW', 'AW') AND member.mID = money_info.mID)");
        elseif ($key == 'm_revenue') return DB::raw("(SELECT COALESCE(SUM(miBankMoney), 0) FROM money_info WHERE miStatus = 9 AND miType IN ('UD', 'AD') AND member.mID = money_info.mID) - (SELECT ABS(COALESCE(SUM(miBankMoney), 0)) FROM money_info WHERE miStatus = 9 AND miType IN ('UW', 'AW') AND member.mID = money_info.mID)");
        elseif ($key == 'm_cash') return DB::raw("(SELECT COALESCE(mMoney, 0) + COALESCE(mSportsMoney, 0))");
        elseif ($key == 'm_point') return 'mPoint';

        return 'mID';
    }

    /**
     * Initialize data for create member
     *
     * @param array @attributes
     */
    private function initDataCreateMember(array $attributes = []): array
    {
        return [
            'mMemberID' => data_get($attributes, 'mMemberID'),
            'mPartnerName' => data_get($attributes, 'mPartnerName'),
            'mID' => data_get($attributes, 'mID'),
            'mPW' => data_get($attributes, 'mPW'),
            'mNick' => data_get($attributes, 'mNick'),
            'mBankName' => data_get($attributes, 'mBankName'),
            'mBankNumber' => data_get($attributes, 'mBankNumber'),
            'mBankOwner' => data_get($attributes, 'mBankOwner'),
            'mPhone' => data_get($attributes, 'mPhone'),
            'mStatus' => array_key_exists("mForceLogout", $attributes) ? Member::M_STATUS_EIGHT : data_get($attributes, 'mStatus', Member::M_STATUS_ONE),
            'mNote' => data_get($attributes, 'mNote'),
            'mLevel' => data_get($attributes, 'mLevel', Member::M_LEVEL_MEMBER),
            'mRegDate' => now()
        ];
    }

    private function initDataUpdateMember(array $attributes = []): array
    {
        $data = [
            'mMemberID' => data_get($attributes, 'mMemberID'),
            'mBankName' => data_get($attributes, 'mBankName'),
            'mBankNumber' => data_get($attributes, 'mBankNumber'),
            'mBankOwner' => data_get($attributes, 'mBankOwner'),
            'mNote' => data_get($attributes, 'mNote'),
            'mBankExchangePW' => data_get($attributes, 'mBankExchangePW'),
            'mID' => data_get($attributes, 'mID'),
            'mNick' => data_get($attributes, 'mNick'),
            'mLevel' => data_get($attributes, 'mLevel'),
            'mWrongPWCount' => 0,
            'mPartnerCode' => data_get($attributes, 'mPartnerCode'),
            'mPartnerName' => data_get($attributes, 'mPartnerName'),
        ];

        $member = $this->memRepo->getMemberByMID($attributes['mID']);

        $mPhone = data_get($attributes, 'mPhone');
        $check = $mPhone == hashString($member->mPhone);
        $data['mPhone'] = $check ? $member->mPhone : $mPhone;
        if (!$check) {
            $data['mPhoneCom'] = null;
        }

        $mConsultBankName = data_get($attributes, 'mConsultBankName');
        $check = $mConsultBankName == hashString($member->mConsultBankName);
        $data['mConsultBankName'] = $check ? $member->mConsultBankName : $mConsultBankName;
        if (!$check) {
            $data['mConsultBankNameCom'] = null;
        }

        $mConsultBankAccount = data_get($attributes, 'mConsultBankAccount');
        $check = $mConsultBankAccount == hashString($member->mConsultBankAccount);
        $data['mConsultBankAccount'] = $check ? $member->mConsultBankAccount : $mConsultBankAccount;
        if (!$check) {
            $data['mConsultBankAccountCom'] = null;
        }

        if ($check = data_get($attributes, 'mPW')) {
            $data['mPW'] = $check;
        }
        if ($check = data_get($attributes, 'mNo')) {
            $data['mNo'] = $check;
        }

        return $data;
    }

    private function getDataByConfig($attributes, mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['mc_bool' => data_get($attributes, 'mc_bool')],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );

        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    private function getDataByConfigNotNull($attributes, mixed $order_by = '', string $sort = 'desc'): array
    {
        $members = $this->memRepo->getListMemberStatusAccessNew(
            ['mc_suspicion' => data_get($attributes, 'mc_suspicion')],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );

        return [
            'members' => $members,
            'total_money' => $members->getCollection()->sum('mMoney'),
        ];
    }

    public function handleActionPageStatusMembers(string $action)
    {
        if ($action === 'hash-phone') {
            return $this->tryCatchFuncDB(function () {
                $members = $this->memRepo->getListMemberHashPhone();

                foreach ($members as $member) {
                    $member->mPhoneCom = Hash::make($member->mPhone);
                    $member->save();
                }
            });
        } elseif ($action === 'hash-consultations') {
            return $this->tryCatchFuncDB(function () {
                $members = $this->memRepo->getListMemberHashConsultation();

                foreach ($members as $member) {
                    $member->mConsultBankNameCom = Hash::make($member->mConsultBankName);
                    $member->mConsultBankAccountCom = Hash::make($member->mConsultBankAccount);
                    $member->save();
                }
            });
        }
    }

    public function updateByMember(string $field, string $mID)
    {
        $member = $this->memRepo->getFirstWithConditions([['mID', $mID]]);
        // $this->memberConfigRepository->updateOrCreate(['mID' => $mID], [$field => !$field]);
        if (!empty($member)) {
            $member->{$field} = !$member->{$field};
            $member->save();
        } else {
            $this->memRepo->create([
                'mID' => $mID,
                $field => true
            ]);
        }
    }

    public function updateIsPartnerByMember(string $mID)
    {
        $member = $this->memRepo->getFirstWithConditions([['mID', $mID]]);

        if (!$member) {
            return [
                'status' => false,
                'is_partner' => $member->mIsPartner ? true : false,
                'message' => '찾을 수 없다',
                'mNo' => $member->mNo
            ];
        }
        if ($member->mIsPartner && $this->existsPartnerChilds($member->mID)) {
            return [
                'status' => false,
                'is_partner' => $member->mIsPartner ? true : false,
                'message' => '하위 파트너가 있으니까 비활성할 수 없습니다.',
                'mNo' => $member->mNo
            ];
        }

        $status = $this->tryCatchFuncDB(function () use ($member) {
            $member->mIsPartner = !$member->mIsPartner;
            if ($member->save()) {
                if (!$member->mIsPartner) $this->memRepo->updateByPK($member->mNo, ['mPartnerCode' => null]);
            }
        });

        return [
            'status' => $status,
            'message' => $status ? '업데이트 성공.' : '업데이트 실패.',
            'is_partner' => $member->mIsPartner,
            'mNo' => $member->mNo
        ];
    }

    private function existsPartnerChilds($mID)
    {
        return $this->memRepo->existsPartnerChilds($mID);
    }
}
