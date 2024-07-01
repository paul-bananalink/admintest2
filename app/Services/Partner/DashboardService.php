<?php

namespace App\Services\Partner;


use App\Services\DashboardService as AdminDashboardService;
use App\Repositories\Partner\MembersLoginRepository;
use App\Repositories\Partner\MemberRepository;
use App\Repositories\Partner\MoneyInfoRepository;
use App\Repositories\Partner\PointHistoryRepository;
use App\Repositories\Partner\TransactionRepository;

class DashboardService extends AdminDashboardService
{
    public function __construct(
        private MembersLoginRepository $memberLoginRepo,
        private MemberRepository $memberRepo,
        private MoneyInfoRepository $moneyInfoRepo,
        private TransactionRepository $transactionRepo,
        private PointHistoryRepository $pointHistoryRepository
    ) {
        parent::__construct(
            $this->memberLoginRepo,
            $this->memberRepo,
            $this->moneyInfoRepo,
            $this->transactionRepo,
            $this->pointHistoryRepository
        );
    }
}
