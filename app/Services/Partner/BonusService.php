<?php

namespace App\Services\Partner;

use App\Repositories\MoneyInfoRepository;
use App\Services\BonusService as AdminBonusService;

class BonusService extends AdminBonusService
{
    public function __construct(
        private MoneyInfoRepository $moneyInfoRepository,
    ) {
        parent::__construct(
            $moneyInfoRepository,
        );
    }
}
