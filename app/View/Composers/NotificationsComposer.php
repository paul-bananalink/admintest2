<?php

namespace App\View\Composers;

use App\Services\ConsultationService;
use App\Services\MemberService;
use App\Services\MoneyInfoService;
use Illuminate\View\View;

class NotificationsComposer
{
    public function __construct(
        private MoneyInfoService $moneyInfoService,
        private MemberService $memberService,
        private ConsultationService $consultationService
    ) {
    }

    public function compose(View $view)
    {
        $totalMoneyInfo = $this->moneyInfoService->getTotalNotifications();
        $getSumMoneyDepositeRegisterToday = $this->moneyInfoService->getSumMoneyDepositeRegisterToday();
        $getCountOrderDepositRegisterToday = $this->moneyInfoService->getCountOrderDepositRegisterToday();

        $getMoneyOrderWithdrawRegisterToday = $this->moneyInfoService->getMoneyOrderWithdrawRegisterToday();
        $getCountOrderWithdrawRegisterToday = $this->moneyInfoService->getCountOrderWithdrawRegisterToday();

        $getMoneyRegisterRechargeApprovedToday = $this->moneyInfoService->getMoneyRegisterRechargeApprovedToday();
        $getMoneyRegisterWithdrawApprovedToday = $this->moneyInfoService->getMoneyRegisterWithdrawApprovedToday();

        $profitAmountToday = (float) $getMoneyRegisterRechargeApprovedToday + (float) $getMoneyRegisterWithdrawApprovedToday;

        $getSumMoneyAllMember = $this->memberService->getSumMoneyAllMember();

        $totalPendingMember = $this->memberService->countMemberPending();
        $count_member_register_today = $this->memberService->countMembersRegisteredToday();
        $count_member_register_approved_today = $this->memberService->getCountMemberRegisterApprovedToday();

        $totalConsultation = $this->consultationService->getTotalNotify();
        $id_admin = auth()->id();

        $view->with([
            'totalMoneyInfo' => $totalMoneyInfo,
            'totalPendingMember' => $totalPendingMember,
            'totalConsultation' => $totalConsultation,
            'count_member_register_today' => $count_member_register_today,
            'count_member_register_approved_today' => $count_member_register_approved_today,
            'getSumMoneyDepositeRegisterToday' => $getSumMoneyDepositeRegisterToday,
            'getCountOrderDepositRegisterToday' => $getCountOrderDepositRegisterToday,
            'getMoneyOrderWithdrawRegisterToday' => $getMoneyOrderWithdrawRegisterToday,
            'getCountOrderWithdrawRegisterToday' => $getCountOrderWithdrawRegisterToday,
            'profitAmountToday' => $profitAmountToday,
            'getSumMoneyAllMember' => $getSumMoneyAllMember,
            'id_admin' => $id_admin,
        ]);
    }
}
