<?php

namespace App\Services\Partner;

use App\Repositories\Partner\PartnerRepository;
use App\Repositories\Partner\MemberRepository;
use App\Services\MoneyInfoService;
use App\Services\PartnerService;

class PartnerManagerService extends PartnerService
{
    public function __construct(
        private PartnerRepository $partnerRepo,
        private MemberRepository $memRepo,
        private MoneyInfoService $moneyInfoService,
    ) {
        parent::__construct(
            $partnerRepo,
            $memRepo,
            $moneyInfoService,
        );
    }
}
