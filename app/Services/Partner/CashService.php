<?php

namespace App\Services\Partner;

use App\Repositories\Partner\CashRepository;
use App\Services\CashService as AdminCashService;

class CashService extends AdminCashService
{
    public function __construct(
        private CashRepository $cashRepository,
    ) {
        parent::__construct(
            $this->cashRepository
        );
    }
}
