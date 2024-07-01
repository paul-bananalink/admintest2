<?php

namespace App\Events\Admin;

use App\Events\BaseEvent;
use App\Repositories\MoneyInfoRepository;
use App\Repositories\TransactionRepository;

class CountMoneyEvent extends BaseEvent
{
    protected string $eventAliasName = 'mananger-money-event';

    private $sum_money_register_recharge_approved_today = 0;
    private $sum_money_register_recharge_approved_yesterday = 0;
    private $count_order_deposite_register_today = 0;

    private $sum_money_register_withdraw_approved_today = 0;
    private $money_register_withdraw_approved_yesterday = 0;

    private $count_money_register_withdraw_today = 0;

    private $sum_money_recharge_yesterday = 0;

    private $sum_money_recharge_today = 0;
    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            // money register
            'sum_money_register_recharge_approved_today' => formatNumber($this->sum_money_register_recharge_approved_today),
            'sum_money_register_recharge_approved_yesterday' => formatNumber($this->sum_money_register_recharge_approved_yesterday),
            'sum_money_interest_recharge' => formatNumber(abs($this->sum_money_register_recharge_approved_today - $this->sum_money_register_recharge_approved_yesterday)),
            'count_order_deposite_register_today' => $this->count_order_deposite_register_today,

            //money withdraw
            'sum_money_register_withdraw_approved_today' => formatNumber(abs($this->sum_money_register_withdraw_approved_today)),
            'money_register_withdraw_approved_yesterday' => formatNumber($this->money_register_withdraw_approved_yesterday),
            'sum_money_interest_withdraw' => formatNumber(abs(abs($this->sum_money_register_withdraw_approved_today) - abs($this->money_register_withdraw_approved_yesterday))),
            'count_money_register_withdraw_today' => $this->count_money_register_withdraw_today,

            //금일 수익금액
            'sum_money_interest_today' => formatNumber($this->sum_money_register_recharge_approved_today - abs($this->sum_money_register_withdraw_approved_today)),
            'sum_money_compare' => formatNumber(abs($this->sum_money_recharge_yesterday - $this->sum_money_recharge_today)),
        ];
    }

    /**
     * Get channel name
     */
    protected function getChannelName(): string
    {
        return 'mananger-money-channel';
    }

    private function handle(): void
    {
        $moneyInfoRepo = new MoneyInfoRepository();
        $today = now()->today();
        $last_day = now()->yesterday();
        // money register
        $this->sum_money_register_recharge_approved_today = $moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($today)->sum('miBankMoney');
        $this->count_order_deposite_register_today = $moneyInfoRepo->getCountOrderDepositeRegisterByDate($today);
        $this->sum_money_register_recharge_approved_yesterday = $moneyInfoRepo->getMoneyRegisterRechargeApprovedByDate($last_day)->sum('miBankMoney');
        //money withdraw
        $this->sum_money_register_withdraw_approved_today = $moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate($today)->sum('miBankMoney');
        $this->money_register_withdraw_approved_yesterday = $moneyInfoRepo->getMoneyRegisterWithdrawApprovedByDate(now()->yesterday())->sum('miBankMoney');
        $this->count_money_register_withdraw_today = $moneyInfoRepo->getCountOrderWithdrawRegisterByDate($today);

        $this->sum_money_recharge_yesterday = abs($this->sum_money_register_recharge_approved_yesterday) - abs($this->money_register_withdraw_approved_yesterday);
        $this->sum_money_recharge_today = abs($this->sum_money_register_recharge_approved_today) - abs($this->sum_money_register_withdraw_approved_today);
    }
}
