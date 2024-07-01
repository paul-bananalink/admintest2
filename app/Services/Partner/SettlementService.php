<?php

namespace App\Services\Partner;

use App\Repositories\Partner\SettlementRepository;
use App\Services\SettlementService as AdminSettlementService;

class SettlementService extends AdminSettlementService
{
    public function __construct(
        private SettlementRepository $settlementRepoPartner
    ) {
        parent::__construct(
            $settlementRepoPartner
        );
    }
}
