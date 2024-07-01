<?php

namespace App\Services;

use App\Events\Admin\CountMoneyEvent;
use App\Events\Client\CountNotificationEvent;
use App\Events\Client\GetBalanceEvent;
use App\Events\Client\MoneyInfoEvent;
use App\Events\Client\StatisticMoneyEvent;
use App\Exceptions\GraphQLException;
use App\Models\MoneyInfo;
use App\Models\Member;
use App\Repositories\MemberRepository;
use App\Repositories\MoneyInfoRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class MoneyInfoService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private MoneyInfoRepository $moneyInfoRepository,
        private MemberRepository $memberRepository,
        private MemberService $memberService,
        private MoneyHandlerService $moneyHandlerService,
    ) {
    }

    /**
     * Create withdraw/recharge
     *
     * @param  string  $type
     */
    public function create(array $attributes = []): MoneyInfo|bool
    {
        if (!in_array($attributes['miWallet'], array_keys(Member::MEMBER_WALLETS))) {
            return false;
        }

        $is_direct = in_array($attributes['miType'], [MoneyInfo::TYPE_AW, MoneyInfo::TYPE_AD]);
        $member = $is_direct ? $this->memberRepository->getFirstWithConditions([['mID', $attributes['mID']]]) : Auth::user();
        $moneyInfo = $this->moneyHandlerService->handleCreation($member, $attributes);

        // event(new StatisticMoneyEvent($this->getAllTotalMoney()));
        event(new CountNotificationEvent($attributes['miType']));
        event(new MoneyInfoEvent($moneyInfo, $attributes['miType']));
        event(new CountMoneyEvent());

        return $moneyInfo;
    }

    /**
     * Update withdraw/recharge
     *
     * @param [type] $id
     */
    public function update(array $attributes, int $id): bool
    {
        $moneyInfo = $this->moneyInfoRepository->getByPK($id);
        $status = (int) $attributes['data'];
        $isApproval = $status == MoneyInfo::STATUS_NINE;
        $isCancellation = $status == MoneyInfo::STATUS_THREE;
        $isRollback = $status == MoneyInfo::STATUS_TWO;

        $member = $moneyInfo->member;

        if ($moneyInfo->miType == MoneyInfo::TYPE_UW && $isApproval && (
            ($moneyInfo->miWallet == Member::WALLET_SPORTS && abs($moneyInfo->miBankMoney) > $member->mSportsMoney) ||
            ($moneyInfo->miWallet == Member::WALLET_CASINO_SLOT && abs($moneyInfo->miBankMoney) > $member->mMoney)
        )) {
            throw new \Exception('회원의 보유금액이 충분하지 않습니다');
        }
        return $this->tryCatchFuncDB(function () use ($moneyInfo, $member, $isApproval, $isCancellation, $isRollback) {
            $this->runEvent(new CountMoneyEvent());

            if ($isApproval) {
                $this->moneyHandlerService->handleApproval($moneyInfo);
            } elseif ($isCancellation) {
                $this->moneyHandlerService->handleCancellation($moneyInfo);
            } elseif ($isRollback) {
                $this->moneyHandlerService->handleRollback($moneyInfo);
            }

            if (!$isCancellation) {
                $balance = ['mMoney' => $member->mMoney, 'mSportsMoney' => $member->mSportsMoney, 'mPoint' => $member->mPoint];
                event(new GetBalanceEvent($balance, $member->mID));
            }
        });
    }

    /**
     * Update withdraw/recharge
     *
     * @param [type] $ids
     */
    public function updateIds(array $attributes): bool
    {
        $miNos = explode(",", $attributes['data']);
        $moneyinfos = $this->moneyInfoRepository->getByPKs($miNos);
        return $this->tryCatchFuncDB(
            function () use ($moneyinfos, $miNos) {
                $this->moneyInfoRepository->updateByPKs(
                    $miNos,
                    [
                        'miProcess_miID' => auth()->user()->mID,
                        'miStatus' => 9,
                    ]
                );
                foreach ($moneyinfos as $moneyInfo) {
                    // $this->syncHistory($moneyInfo, ['miStatus' => 9]);

                    // $this->handleMoney($moneyInfo->member, $moneyInfo->toArray(), $moneyInfo);
                    event(new MoneyInfoEvent($moneyInfo, 'update'));
                }
                $this->runEvent(new CountMoneyEvent());
            }
        );
    }

    /**
     * Hard delete withdraw
     *
     * @param [type] $id
     */
    public function delete($id): bool
    {
        $status = false;
        if (!empty($moneyInfo = $this->moneyInfoRepository->getByPK($id))) {
            $type = $moneyInfo->getType(); //Type is withdraw or recharge
            $status = $moneyInfo->delete();

            if ($type) {
                event(new CountNotificationEvent($type, -1));
            }
            event(new MoneyInfoEvent($moneyInfo, 'delete'));
        } else {
            throw new GraphQLException('Money info not found');
        }
        $this->runEvent(new CountMoneyEvent());
        return $status;
    }

    /**
     * Find money info
     *
     * @param [type] $id
     * @return MoneyInfo
     */
    public function find($id)
    {
        return $this->moneyInfoRepository->getByPK($id);
    }

    /**
     * GraphQL paginate
     *
     * @return void
     */
    public function paginate(array $attributes = [])
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        $page = $attributes['page'];
        $limit = $attributes['limit'];

        $where[] = ['mID', $member->mID];
        $type = $attributes['type'];
        if ($type == "exchange") {
            $where[] = ['miType', MoneyInfo::TYPE_EM];
        } elseif ($type == "recharge") {
            $where[] = ['miType', MoneyInfo::TYPE_UD];
        } else {
            $where[] = ['miType', MoneyInfo::TYPE_UW];
        }
        if ($type == "exchange") {
            $data = $this->moneyInfoRepository->paginateWithConditions($page, $limit * 2, [['miRegDate', 'desc']], ['where' => $where])->groupBy('miRegDate');
            $list = collect();
            foreach ($data as $values) {
                $item = $to = $from = null;
                foreach ($values as $value) {
                    if ($value->miBankMoney > 0) {
                        $to = $value->miWallet;
                        $item = $value;
                    } else {
                        $from = $value->miWallet;
                    }
                }
                $item->to = $to;
                $item->from = $from;
                $list->push($item);
            }
            return new LengthAwarePaginator($list->toArray(), 0, $limit, $page);
        } else {
            return $data = $this->moneyInfoRepository->paginateWithConditions($page, $limit, [['miRegDate', 'desc']], ['where' => $where]);
        }
    }

    /**
     * Admin get list and paginate
     *
     * @return void
     */
    public function getAll(array $attributes = [])
    {
        $conditions = $this->formatConditions($attributes);

        $order = [['miRegDate', config('constant_view.QUERY_DATABASE.DESC')]];

        return $this->moneyInfoRepository->paginate($conditions, $order, ['member', 'process_member']);
    }

    public function get($attributes)
    {
        $conditions = $this->formatConditions($attributes);

        $order = [['miRegDate', config('constant_view.QUERY_DATABASE.DESC')]];

        return $this->moneyInfoRepository->getListWithConditions($conditions, $order, ['member', 'process_member']);
    }

    /**
     * Get overview for admin
     */
    public function getOverview(array $attributes = []): array
    {
        $all = $this->moneyInfoRepository->getListWithConditions($this->formatConditions($attributes));

        $attributes['status'] = 'requested';
        $requested = $this->moneyInfoRepository->getListWithConditions($this->formatConditions($attributes));

        $attributes['status'] = 'approved';
        $approved = $this->moneyInfoRepository->getListWithConditions($this->formatConditions($attributes));

        $attributes['status'] = 'reject';
        $reject = $this->moneyInfoRepository->getListWithConditions($this->formatConditions($attributes));

        return [
            'total' => ['amount' => $all->sum('miBankMoney')],
            'requested' => ['amount' => $requested->sum('miBankMoney'), 'count' => $requested->count()],
            'approved' => ['amount' => $approved->sum('miBankMoney'), 'count' => $approved->count()],
            'reject' => ['amount' => $reject->sum('miBankMoney'), 'count' => $reject->count()],
            'config' => $this->initConfig(),
        ];
    }

    public function getSumMoneyDepositeRegisterToday()
    {
        return $this->moneyInfoRepository->getMoneyOrderDepositeRegisterToday();
    }

    // getCountOrderDepositeRegisterToday
    public function getCountOrderDepositRegisterToday()
    {
        return $this->moneyInfoRepository->getCountOrderDepositeRegisterByDate(now()->today());
    }

    public function getMoneyOrderWithdrawRegisterToday()
    {
        return $this->moneyInfoRepository->getMoneyOrderWithdrawRegisterToday();
    }

    public function getCountOrderWithdrawRegisterToday()
    {
        return $this->moneyInfoRepository->getCountOrderWithdrawRegisterByDate(now()->today());
    }

    public function getMoneyRegisterRechargeApprovedToday()
    {
        return $this->moneyInfoRepository->getMoneyRegisterRechargeApprovedByDate(now()->today())->sum('miBankMoney');
    }

    public function getMoneyRegisterWithdrawApprovedToday()
    {
        return $this->moneyInfoRepository->getMoneyRegisterWithdrawApprovedByDate(now()->today())->sum('miBankMoney');
    }

    public function getTotalNotifications()
    {
        $total = [];
        $conditions['where'] = [['miStatus', 1]];
        foreach (MoneyInfo::MI_TYPE_FILTER as $key => $types) {
            $conditions['whereIn'] = [['miType', $types]];

            $total[$key] = $this->moneyInfoRepository->countWithConditions($conditions);
        }

        return $total;
    }

    public function getLatestRegDateByType($member, $type)
    {
        return $this->moneyInfoRepository->moneyInfosMiRegDateLatest($member, $type);
    }

    /**
     * Format conditions
     */
    private function formatConditions(array $attributes): array
    {
        $conditions = [];
        $is_rollback = isset($attributes['mode']) && $attributes['mode'] == "rollback" ?? false;
        $filter = data_get($attributes, 'filter', null);

        $conditions['whereIn'][] = ['miWallet', [Member::WALLET_CASINO_SLOT, Member::WALLET_SPORTS, Member::WALLET_POINT]];

        if ($is_rollback && empty($filter)) {
            $conditions['where'][] = ['miStatus', MoneyInfo::STATUS_NINE];
        }

        if ($type = data_get($attributes, 'type')) {
            $type = MoneyInfo::RECHARGE == $type ? MoneyInfo::TYPE_UD : MoneyInfo::TYPE_UW;
            $conditions['where'][] = ['miType', $type];
        }

        if ($level = data_get($attributes, 'level')) {
            $conditions['whereHas'][] = ['member', function ($query) use ($level) {
                return $query->where('mLevel', $level);
            }];
        }

        if ($search = data_get($attributes, 'search')) {
            $conditions['where'][] = ['mID', 'like', '%' . $search . '%'];
        }

        if ($start_date = data_get($attributes, 'start_date')) {
            $conditions['where'][] = ['miRegDate', '>=', $start_date];
        }

        if ($end_date = data_get($attributes, 'end_date')) {
            $conditions['where'][] = ['miRegDate', '<=', $end_date];
        }

        if ($filter && $filter != 'all') {
            $filter = MoneyInfo::MI_STATUS_FILTER[$filter] ?? null;
            $conditions['where'][] = ['miStatus', $filter];
        }

        if ($mID = data_get($attributes, 'mID')) {
            $conditions['where'][] = ['mID', $mID];
        };

        return $conditions;
    }

    public function getAllTotalMoney()
    {
        $getSumMoneyDepositeRegisterToday = $this->getSumMoneyDepositeRegisterToday();
        $getCountOrderDepositRegisterToday = $this->getCountOrderDepositRegisterToday();

        $getMoneyOrderWithdrawRegisterToday = $this->getMoneyOrderWithdrawRegisterToday();
        $getCountOrderWithdrawRegisterToday = $this->getCountOrderWithdrawRegisterToday();

        $getMoneyRegisterRechargeApprovedToday = $this->getMoneyRegisterRechargeApprovedToday();
        $getMoneyRegisterWithdrawApprovedToday = $this->getMoneyRegisterWithdrawApprovedToday();

        $profitAmountToday = (float) $getMoneyRegisterRechargeApprovedToday + (float) $getMoneyRegisterWithdrawApprovedToday;

        $getSumMoneyAllMember = $this->memberService->getSumMoneyAllMember();
        $count_member_register_today = $this->memberService->countMembersRegisteredToday();
        $count_member_register_approved_today = $this->memberService->getCountMemberRegisterApprovedToday();

        return [
            'count_member_register_today' => $count_member_register_today,
            'count_member_register_approved_today' => $count_member_register_approved_today,
            'getCountOrderWithdrawRegisterToday' => $getCountOrderWithdrawRegisterToday,
            'getCountOrderDepositRegisterToday' => $getCountOrderDepositRegisterToday,
            'getMoneyOrderWithdrawRegisterToday' => formatNumber($getMoneyOrderWithdrawRegisterToday),
            'getSumMoneyDepositeRegisterToday' => formatNumber($getSumMoneyDepositeRegisterToday),
            'profitAmountToday' => formatNumber($profitAmountToday),
            'getSumMoneyAllMember' => formatNumber($getSumMoneyAllMember),
        ];
    }
    public function getWithdrawCheck()
    {
        /** @var Member */
        $member = auth('sanctum')->user();
        $member_config = $member->memberConfig;
        $data = [];
        if (env('ENABLE_SPORTS')) {
            $sports_current_money = $member->tbTotalCarts()->where('isCanceled', 'N')->sum('betting_money');
            $sports_withdraw_no_rolling = data_get($member_config, 'mcSportsRolling');
            $sports_withdraw_money = $sports_withdraw_no_rolling ? null : data_get($member_config, 'mcSportsMoneyWithdraw');
            $data['sports_current_money'] = $sports_current_money;
            $data['sports_withdraw_money'] = $sports_withdraw_money;
            $data['is_enable_sports_withdraw'] = $sports_withdraw_no_rolling || ($sports_withdraw_money && $sports_current_money >= $sports_withdraw_money);
        }

        $casino_current_money = $member->transactions()->where('tRegDate', '>=', $member->memberLatestRecharge()->mProcessDate ?? today())->where('tType', 'Bet')->sum('tAmount');
        $casino_withdraw_no_rolling = data_get($member_config, 'mcCasinoRolling');
        $casino_withdraw_money = $casino_withdraw_no_rolling ? null : data_get($member_config, 'mcCasinoMoneyWithdraw');

        $data['casino_current_money'] = $casino_current_money;
        $data['casino_withdraw_money'] = $casino_withdraw_money;
        $data['is_enable_casino_withdraw'] = $casino_withdraw_no_rolling || ($casino_withdraw_money && $casino_current_money >= $casino_withdraw_money);

        return $data;
    }

    public function checkWithdrawEnable($miWallet)
    {
        $withdraw_check = $this->getWithdrawCheck();
        $key = $miWallet == Member::WALLET_CASINO_SLOT ? 'is_enable_casino_withdraw' : 'is_enable_sports_withdraw';
        return $withdraw_check[$key];
    }
}
