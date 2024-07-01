<?php

namespace App\Services\Partner;

use App\Repositories\Partner\MoneyInfoRepository;
use App\Repositories\Partner\MemberRepository;
use App\Services\MemberService;
use App\Services\MoneyHandlerService;
use App\Services\MoneyInfoService as AdminMoneyInfoService;

class MoneyInfoService extends AdminMoneyInfoService
{
    public function __construct(
        private MoneyInfoRepository $moneyInfoRepository,
        private MemberRepository $memberRepository,
        private MemberService $memberService,
        private MoneyHandlerService $moneyHandlerService
    ) {
        parent::__construct(
            $moneyInfoRepository,
            $memberRepository,
            $memberService,
            $moneyHandlerService
        );
    }
}
