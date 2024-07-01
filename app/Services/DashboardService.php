<?php

namespace App\Services;

use App\Repositories\MemberRepository;
use App\Repositories\MembersLoginRepository;
use App\Repositories\MoneyInfoRepository;
use App\Repositories\PointHistoryRepository;
use App\Repositories\TransactionRepository;

class DashboardService extends BaseService
{
    const TYPE_DAY = 'day';
    const TYPE_MONTH = 'month';

    /**
     * Create a new class instance.
     */
    public function __construct(
        private MembersLoginRepository $memLoginRepo,
        private MemberRepository $memRepo,
        private MoneyInfoRepository $moneyInfoRepo,
        private TransactionRepository $transactionRepository,
        private PointHistoryRepository $pointHistoryRepository
    ) {
    }

    public function getStatisticBoard(array $attributes = []): array
    {
        if (data_get($attributes, 'type', 'day') == self::TYPE_DAY) {
            return $this->getDataByTypeDay();
        } elseif (data_get($attributes, 'type', 'day') == self::TYPE_MONTH) {
            return $this->getDataByTypeMonth();
        }
        return [];
    }

    /**
     * ---------------------------CONTENTS DAY---------------------------
     */
    public function getData20DaysAgo()
    {
        $data = [];
        for ($i = 20; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $recharge_approved = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($date);
            $withdraw_approved = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($date);

            $data[$i]['new_member'] = $this->memRepo->countByDate('mRegDate', $date);
            $data[$i]['user_recharge'] = $this->moneyInfoRepo->countUserRechargeByDate($date);
            $data[$i]['money_recharge']['count'] = $recharge_approved->count();
            $data[$i]['money_recharge']['total'] = $recharge_approved->sum('miBankMoney');
            $data[$i]['money_withdraw']['count'] = $withdraw_approved->count();
            $data[$i]['money_withdraw']['total'] = $withdraw_approved->sum('miBankMoney');
            $data[$i]['total_bet'] = $this->transactionRepository->sumBet($date);
            $data[$i]['total_win'] = $this->transactionRepository->sumWin($date);
            $data[$i]['money_profit'] = $data[$i]['money_recharge']['total'] + $data[$i]['money_withdraw']['total'];
            $data[$i]['rolling_bonus_day']= $this->pointHistoryRepository->getRolling($date)->sum('phPoint');
            $data[$i]['bet_profit'] = $data[$i]['total_bet'] - $data[$i]['total_win'] - $data[$i]['rolling_bonus_day'];
            $data[$i]['date'] = $date;
        }
        
        return $data;
    }

    public function getDataForChartDay(): array
    {
        //casino
        $sum_bet_today_casino = $this->transactionRepository->sumBet(now()->today(), \App\Models\GameProvider::NAME_CASINO);
        $sum_win_today_casino = $this->transactionRepository->sumWin(now()->today(), \App\Models\GameProvider::NAME_CASINO);
        $count_member_batting_today_casino = $this->transactionRepository->countMemberBatting(now()->today(), \App\Models\GameProvider::NAME_CASINO);
        $rate_win_today_casino = $sum_bet_today_casino != 0 ? (($sum_bet_today_casino - $sum_win_today_casino) / $sum_bet_today_casino) * 100 : 0; // percent of bet & win


        //slot
        $sum_bet_today_slot = $this->transactionRepository->sumBet(now()->today(), \App\Models\GameProvider::NAME_SLOT);
        $sum_win_today_slot = $this->transactionRepository->sumWin(now()->today(), \App\Models\GameProvider::NAME_SLOT);
        $count_member_batting_today_slot = $this->transactionRepository->countMemberBatting(now()->today(), \App\Models\GameProvider::NAME_SLOT);
        $rate_win_today_slot = $sum_bet_today_slot != 0 ? (($sum_bet_today_slot - $sum_win_today_slot) / $sum_bet_today_slot) * 100 : 0; // percent of bet & win

        return [
            //casino
            'sum_bet_minus_win_today_casino' => $sum_bet_today_casino - $sum_win_today_casino,
            'sum_win_today_casino' => $sum_win_today_casino,
            'rate_win_today_casino' => $rate_win_today_casino,
            'rate_convert_to_money_win_today_casino' => (($sum_bet_today_casino - $sum_win_today_casino) * $rate_win_today_casino) / 100,
            'count_member_batting_today_casino' => $count_member_batting_today_casino,

            //slot
            'sum_bet_minus_win_today_slot' => $sum_bet_today_slot - $sum_win_today_slot,
            'sum_win_today_slot' => $sum_win_today_slot,
            'rate_win_today_slot' => $rate_win_today_slot,
            'rate_convert_to_money_win_today_slot' => (($sum_bet_today_slot - $sum_win_today_slot) * $rate_win_today_slot) / 100,
            'count_member_batting_today_slot' => $count_member_batting_today_slot,
        ];
    }
    //---------------------------END CONTENTS DAY---------------------------

    /**
     * ---------------------------CONTENTS MONTH---------------------------
     */
    public function getData20MonthsAgo()
    {
        $data = [];
        for ($i = intval(date('m')) - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i)->format('Y-m');
            $recharge_approved = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($date, false);
            $withdraw_approved = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($date, false);
            $data[$i]['new_member'] = $this->memRepo->countByDate('mRegDate', $date, false);
            $data[$i]['user_recharge'] = $this->moneyInfoRepo->countUserRechargeByDate($date, false);
            $data[$i]['money_recharge']['count'] = $recharge_approved->count();
            $data[$i]['money_recharge']['total'] = $recharge_approved->sum('miBankMoney');
            $data[$i]['money_withdraw']['count'] = $withdraw_approved->count();
            $data[$i]['money_withdraw']['total'] = $withdraw_approved->sum('miBankMoney');
            $data[$i]['total_bet'] = $this->transactionRepository->sumBet($date, is_day: false);
            $data[$i]['total_win'] = $this->transactionRepository->sumWin($date, is_day: false);
            $data[$i]['money_profit'] = $data[$i]['money_recharge']['total'] + $data[$i]['money_withdraw']['total'];
            $data[$i]['bet_profit'] = $data[$i]['total_bet'] - $data[$i]['total_win'];
            $data[$i]['date'] = $date;
        }

        return $data;
    }

    public function getDataForChartMonth(): array
    {
        $this_month = now()->format('Y-m');

        //casino
        $sum_bet_this_month_casino = $this->transactionRepository->sumBet($this_month, \App\Models\GameProvider::NAME_CASINO, false);
        $sum_win_this_month_casino = $this->transactionRepository->sumWin($this_month, \App\Models\GameProvider::NAME_CASINO, false);
        $count_member_batting_this_month_casino = $this->transactionRepository->countMemberBatting($this_month, \App\Models\GameProvider::NAME_CASINO, false);
        $rate_win_this_month_casino = $sum_bet_this_month_casino != 0 ? (($sum_bet_this_month_casino - $sum_win_this_month_casino) / $sum_bet_this_month_casino) * 100 : 0; // percent of bet & win


        //slot
        $sum_bet_this_month_slot = $this->transactionRepository->sumBet($this_month, \App\Models\GameProvider::NAME_SLOT, false);
        $sum_win_this_month_slot = $this->transactionRepository->sumWin($this_month, \App\Models\GameProvider::NAME_SLOT, false);
        $count_member_batting_this_month_slot = $this->transactionRepository->countMemberBatting($this_month, \App\Models\GameProvider::NAME_SLOT, false);
        $rate_win_this_month_slot = $sum_bet_this_month_slot != 0 ? (($sum_bet_this_month_slot - $sum_win_this_month_slot) / $sum_bet_this_month_slot) * 100 : 0; // percent of bet & win

        return [
            //casino
            'sum_bet_minus_win_this_month_casino' => $sum_bet_this_month_casino - $sum_win_this_month_casino,
            'sum_win_this_month_casino' => $sum_win_this_month_casino,
            'rate_win_this_month_casino' => $rate_win_this_month_casino,
            'rate_convert_to_money_win_this_month_casino' => (($sum_bet_this_month_casino - $sum_win_this_month_casino) * $rate_win_this_month_casino) / 100,
            'count_member_batting_this_month_casino' => $count_member_batting_this_month_casino,

            //slot
            'sum_bet_minus_win_this_month_slot' => $sum_bet_this_month_slot - $sum_win_this_month_slot,
            'sum_win_this_month_slot' => $sum_win_this_month_slot,
            'rate_win_this_month_slot' => $rate_win_this_month_slot,
            'rate_convert_to_money_win_this_month_slot' => (($sum_bet_this_month_slot - $sum_win_this_month_slot) * $rate_win_this_month_slot) / 100,
            'count_member_batting_this_month_slot' => $count_member_batting_this_month_slot,
        ];
    }
    //---------------------------END CONTENTS DAY---------------------------

    /**
     * -----------------------PRIVATE FUNCTION-----------------------
     */

    private function getDataByTypeDay(): array
    {
        $today = now()->today();
        $last_day = now()->yesterday();

        //금일 신규가입 유저수 (차단)
        $count_member_register_today = $this->memRepo->getCountMemberRegisterByDate($today);
        $count_member_register_yesterday = $this->memRepo->getCountMemberRegisterByDate($last_day);
        $count_member_register = $count_member_register_today - $count_member_register_yesterday;
        $count_member_suspended_today = $this->memRepo->getCountMemberSuspendedByDate($today);
        $count_member_suspended_yesterday = $this->memRepo->getCountMemberSuspendedByDate($last_day);
        $count_member_suspended = $count_member_suspended_today - $count_member_suspended_yesterday;

        //금일 입금액 deposite
        $sum_money_register_recharge_approved_today = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($today)->sum('miBankMoney');
        $sum_money_register_recharge_approved_yesterday = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($last_day)->sum('miBankMoney');
        $sum_money_interest_recharge = $sum_money_register_recharge_approved_today - $sum_money_register_recharge_approved_yesterday;
        $count_order_deposite_register_today = $this->moneyInfoRepo->getCountOrderDepositeRegisterByDate($today);

        //금일 출금액 withdraw
        $sum_money_register_withdraw_approved_today = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($today)->sum('miBankMoney');
        $sum_money_register_withdraw_approved_yesterday = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($last_day)->sum('miBankMoney');
        $sum_money_interest_withdraw = abs($sum_money_register_withdraw_approved_today) - abs($sum_money_register_withdraw_approved_yesterday);
        $count_money_register_withdraw_today = $this->moneyInfoRepo->getCountOrderWithdrawRegisterByDate($today);

        //금일 수익금액
        $sum_money_interest_today = $sum_money_register_recharge_approved_today - abs($sum_money_register_withdraw_approved_today);
        $sum_money_interest_yesterday = $sum_money_register_recharge_approved_yesterday - abs($sum_money_register_withdraw_approved_yesterday);
        $sum_money_compare = $sum_money_interest_today - $sum_money_interest_yesterday;
        
        $today_bet = $this->transactionRepository->getBet($today);
        $total_bet_today = $today_bet->sum('tAmount');
        $count_total_bet_today = $today_bet->count();
        
        $yesterday_bet = $this->transactionRepository->getBet($last_day);
        $total_yesterday_bet = $yesterday_bet->sum('tAmount');
        $count_total_yesterday_bet = $yesterday_bet->count();
        
        $sum_bet_compare = $total_bet_today - $total_yesterday_bet;
        
        $today_bet_win = $this->transactionRepository->getWin($today);
        $sum_total_bet_win_today = $today_bet_win->sum('tAmount');
        $yesterday_bet_win = $this->transactionRepository->getWin($last_day);
        $sum_total_bet_win_yesterday = $yesterday_bet_win->sum('tAmount');

        $rolling_bonus_today= $this->pointHistoryRepository->getRolling($today);
        $sum_rolling_bonus_today = $rolling_bonus_today->sum('phPoint');

        $rolling_bonus_yesterday= $this->pointHistoryRepository->getRolling($last_day);
        $sum_rolling_bonus_yesterday = $rolling_bonus_yesterday->sum('phPoint');

        $bet_profit_loss_today= $total_bet_today - $sum_total_bet_win_today - $sum_rolling_bonus_today;
        $bet_profit_loss_yesterday= $total_yesterday_bet - $sum_total_bet_win_yesterday - $sum_rolling_bonus_yesterday;
        $sum_bet_profit_compare = $bet_profit_loss_today - $bet_profit_loss_yesterday;
        //금월 수익현황
        //month
        $this_month = now()->format('Y-m');
        $last_month = now()->subMonth(1)->format('Y-m');
        $sum_money_register_recharge_approved_this_month = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($this_month, false)->sum('miBankMoney');
        $sum_money_register_recharge_approved_last_month = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($last_month, false)->sum('miBankMoney');
        $sum_money_register_withdraw_approved_this_month = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($this_month, false)->sum('miBankMoney');
        $sum_money_register_withdraw_approved_last_month = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($last_month, false)->sum('miBankMoney');
        $sum_money_interest_this_month = $sum_money_register_recharge_approved_this_month - (-$sum_money_register_withdraw_approved_this_month);
        $sum_money_interest_last_month = $sum_money_register_recharge_approved_last_month - (-$sum_money_register_withdraw_approved_last_month);
        $sum_money_compare_month = $sum_money_interest_last_month - $sum_money_interest_this_month;
        //----end month

        // Betting profit and loss during the month
        $this_month_bet = $this->transactionRepository->getBet($this_month);
        $last_month_bet = $this->transactionRepository->getBet($last_month);

        $total_bet_month = $this_month_bet->sum('tAmount');   
        $total_bet_last_month = $last_month_bet->sum('tAmount');
        
        $sum_bet_month = $total_bet_month - $total_bet_last_month;
       
        return [
            'count_member_login' => $this->countOnlineMembers(),

            //금일 신규가입 유저수 (차단)
            'count_member_register_today' => $count_member_register_today,
            'count_member_register' => $count_member_register,
            'count_member_suspended_today' => $count_member_suspended_today,
            'count_member_suspended' => $count_member_suspended,

            //금일 입금액 deposite
            'sum_money_register_recharge_approved_today' => $sum_money_register_recharge_approved_today,
            'sum_money_interest_recharge' => $sum_money_interest_recharge,
            'count_order_deposite_register_today' => $count_order_deposite_register_today,

            //금일 출금액 withdraw
            'sum_money_register_withdraw_approved_today' => -$sum_money_register_withdraw_approved_today, // display integer of withdraw
            'sum_money_interest_withdraw' => $sum_money_interest_withdraw,
            'count_money_register_withdraw_today' => $count_money_register_withdraw_today,

            //금일 수익금액
            'sum_money_interest_today' => $sum_money_interest_today,
            'sum_money_interest_yesterday' => $sum_money_interest_yesterday,
            'sum_money_compare' => $sum_money_compare,
            'total_member_bet_today' => $today_bet->unique('mID')->count(),
            'total_bet_today' => $total_bet_today,
            'count_total_bet_today' => $count_total_bet_today,
            'total_bet_yesterday' => $total_yesterday_bet,
            'count_total_bet_yesterday' => $count_total_yesterday_bet,
            'sum_bet_compare' => $sum_bet_compare,

            // Betting profit and loss during the month
            'total_bet_month' => $total_bet_month,
            'sum_bet_month'=>$sum_bet_month,
            
            //get data 20 days ago
            'data_20_days_ago' => $this->getData20DaysAgo(),

            //casino & slot
            ...$this->getDataForChartDay(),

            //금일 수익금액
            'sum_money_interest_this_month' => $sum_money_interest_this_month,
            'sum_money_interest_last_month' => $sum_money_interest_last_month,
            'sum_money_compare_month' => $sum_money_compare_month,

            'bet_profit_loss_today'=> $bet_profit_loss_today,
            'sum_bet_profit_compare' => $sum_bet_profit_compare
        ];
    }

    private function getDataByTypeMonth(): array
    {
        $today = now()->today();
        $last_day = now()->yesterday();

        $this_month = now()->format('Y-m');
        $last_month = now()->subMonth(1)->format('Y-m');

        //금일 신규가입 유저수 (차단)
        $count_member_register_this_month = $this->memRepo->getCountMemberRegisterByDate($this_month, false); //this month
        $count_member_register_last_month = $this->memRepo->getCountMemberRegisterByDate($last_month, false); //last month
        $count_member_register = $count_member_register_this_month - $count_member_register_last_month;
        $count_member_suspended_this_month = $this->memRepo->getCountMemberSuspendedByDate($this_month, false);
        $count_member_suspended_last_month = $this->memRepo->getCountMemberSuspendedByDate($last_month, false);
        $count_member_suspended = $count_member_suspended_this_month - $count_member_suspended_last_month;

        //금일 입금액 deposite
        $sum_money_register_recharge_approved_this_month = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($this_month, false)->sum('miBankMoney');
        $sum_money_register_recharge_approved_last_month = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($last_month, false)->sum('miBankMoney');
        $sum_money_interest_recharge = $sum_money_register_recharge_approved_this_month - $sum_money_register_recharge_approved_last_month;
        $count_order_deposite_register_this_month = $this->moneyInfoRepo->getCountOrderDepositeRegisterByDate($this_month, false);

        //금일 출금액 withdraw
        $sum_money_register_withdraw_approved_this_month = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($this_month, false)->sum('miBankMoney');
        $sum_money_register_withdraw_approved_last_month = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($last_month, false)->sum('miBankMoney');
        $sum_money_interest_withdraw = abs($sum_money_register_withdraw_approved_this_month) - abs($sum_money_register_withdraw_approved_last_month);
        $count_money_register_withdraw_this_month = $this->moneyInfoRepo->getCountOrderWithdrawRegisterByDate($this_month, false);

        //금일 수익금액
        $sum_money_interest_this_month = $sum_money_register_recharge_approved_this_month - (-$sum_money_register_withdraw_approved_this_month);
        $sum_money_interest_last_month = $sum_money_register_recharge_approved_last_month - (-$sum_money_register_withdraw_approved_last_month);
        $sum_money_compare = $sum_money_interest_last_month - $sum_money_interest_this_month;

        //Bet profit or loss during the day
        $today_bet = $this->transactionRepository->getBet($today);
        $yesterday_bet = $this->transactionRepository->getBet($last_day);
        $total_bet_today = $today_bet->sum('tAmount');
        $total_yesterday_bet = $yesterday_bet->sum('tAmount');

        $sum_bet_compare_to_day = $total_bet_today - $total_yesterday_bet;

        //Betting profit and loss during the month
        $this_month_bet = $this->transactionRepository->getBet($this_month);
        $last_month_bet = $this->transactionRepository->getBet($last_month);
        $total_bet_month = $this_month_bet->sum('tAmount');   
        $total_bet_last_month = $last_month_bet->sum('tAmount');
          
        $sum_bet_month = $total_bet_month - $total_bet_last_month;
        
        $this_month_bet_win = $this->transactionRepository->getWin($this_month);
        $sum_total_bet_win_month = $this_month_bet_win->sum('tAmount');
        $last_month_bet_win = $this->transactionRepository->getWin($last_month);
        $sum_total_bet_win_month = $last_month_bet_win->sum('tAmount');

        $this_month_rolling_bonus= $this->pointHistoryRepository->getRolling($today);
        $sum_rolling_bonus_month = $this_month_rolling_bonus->sum('phPoint');
        $rolling_bonus_yesterday= $this->pointHistoryRepository->getRolling($last_day);
        $sum_rolling_bonus_yesterday = $rolling_bonus_yesterday->sum('phPoint');

        $this_month_bet_profit_loss= $total_bet_today - $sum_total_bet_win_month - $sum_rolling_bonus_month;
        $this_month_bet_profit_loss= $total_yesterday_bet - $sum_total_bet_win_month - $sum_rolling_bonus_yesterday;
        $sum_bet_profit_compare_month = abs($this_month_bet_profit_loss) - abs($this_month_bet_profit_loss);

        //금일 수익금액
        //day
        $today = now()->today();
        $last_day = now()->yesterday();
        $sum_money_register_recharge_approved_today = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($today)->sum('miBankMoney');
        $sum_money_register_recharge_approved_yesterday = $this->moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($last_day)->sum('miBankMoney');
        $sum_money_register_withdraw_approved_today = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($today)->sum('miBankMoney');
        $sum_money_register_withdraw_approved_yesterday = $this->moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($last_day)->sum('miBankMoney');
        $sum_money_interest_today = $sum_money_register_recharge_approved_today - abs($sum_money_register_withdraw_approved_today);
        $sum_money_interest_yesterday = $sum_money_register_recharge_approved_yesterday - abs($sum_money_register_withdraw_approved_yesterday);
        $sum_money_compare_today = $sum_money_interest_today - $sum_money_interest_yesterday;
        //end day



        return [
            'count_member_login' => $this->countOnlineMembers(),

            //금일 신규가입 유저수 (차단)
            'count_member_register_this_month' => $count_member_register_this_month,
            'count_member_register' => $count_member_register,
            'count_member_suspended_this_month' => $count_member_suspended_this_month,
            'count_member_suspended' => $count_member_suspended,

            //금일 입금액 deposite
            'sum_money_register_recharge_approved_this_month' => $sum_money_register_recharge_approved_this_month,
            'sum_money_interest_recharge' => $sum_money_interest_recharge,
            'count_order_deposite_register_this_month' => $count_order_deposite_register_this_month,

            //금일 출금액 withdraw
            'sum_money_register_withdraw_approved_this_month' => -$sum_money_register_withdraw_approved_this_month, // display integer of withdraw
            'sum_money_interest_withdraw' => $sum_money_interest_withdraw,
            'count_money_register_withdraw_this_month' => $count_money_register_withdraw_this_month,

            //금일 수익금액
            'sum_money_interest_this_month' => $sum_money_interest_this_month,
            'sum_money_interest_last_month' => $sum_money_interest_last_month,
            'sum_money_compare' => $sum_money_compare,

            'total_member_bet_this_month' => $this_month_bet->unique('mID')->count(),
            'total_bet_this_month' => $this_month_bet->count(),
            'sum_bet_compare' => $this_month_bet->count() - $last_month_bet->count(),

            //Bet profit or loss during the day
            'total_bet_today'=> $total_bet_today,
            'sum_bet_compare_to_day'=> $sum_bet_compare_to_day,
            // Betting profit and loss during the month
            'sum_bet_month' => $sum_bet_month,
            'total_bet_month' => $total_bet_month,

            //get data 12 months of this year
            'data_12_months_ago' => $this->getData20MonthsAgo(),

            //casino & slot
            ...$this->getDataForChartMonth(),

            //금일 수익금액
            'sum_money_interest_today' => $sum_money_interest_today,
            // 'sum_money_interest_yesterday' => $sum_money_interest_yesterday,
            'sum_money_compare_today' => $sum_money_compare_today,

            'this_month_bet_profit_loss' => $this_month_bet_profit_loss,
            'sum_bet_profit_compare_month' => $sum_bet_profit_compare_month,
        ];
    }

    /**
     * Count member login today
     *
     * @param int
     */
    private function countMemberLogin(): int
    {
        return $this->memLoginRepo->getCountMemberAccess([
            'updated_at',
            [now()->subHours(2)->format('Y-m-d H:m:s'), now()->format('Y-m-d H:m:s')],
        ]);
    }
    private function countOnlineMembers(): int
    {
        return $this->memRepo->getOnlineMembers()['onlineMemberCount'];
    }
}
