<?php

namespace App\Services\Partner;

use App\Repositories\Partner\TransactionRepository;
use App\Repositories\GameProviderRepository;
use App\Services\TransactionService as AdminTransactionService;

class TransactionService extends AdminTransactionService
{

    public function __construct(
        private TransactionRepository $transactionRepo,
        private GameProviderRepository $gameProviderRepo,
        private MoneyInfoService $moneyInfoService
    ) {
        parent::__construct(
            $transactionRepo,
            $gameProviderRepo,
            $moneyInfoService
        );
    }
}
