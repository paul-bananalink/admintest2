<?php

namespace App\Services\GraphQL;

use App\Events\Client\GetBalanceEvent;
use App\Models\BonusConfig;
use App\Models\MoneyInfo;
use App\Repositories\BonusConfigRepository;
use App\Repositories\MoneyInfoRepository;
use App\Services\BonusHandlerService;
use App\Repositories\MemberRepository;

class RouletteService
{
    private array $config;
    private array $cumulativeRatios;

    public function __construct(
        private MoneyInfoRepository $moneyInfoRepository,
        private BonusHandlerService $bonusHandlerService,
        private BonusConfigRepository $bonusConfigRepository,
        private MemberRepository $memberRepository,
    ) {
        $this->config = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_COUPON_BONUS))['roulette'];
        $this->cumulativeRatios = $this->calcCumulativeRatios();
    }

    public function init(): array
    {
        return $this->config;
    }

    public function result(): array
    {
        $data = $this->config;
        $randomNumber = rand(0, 99);
        $maxPercent = max(array_column($data, 'percent'));
        $maxPercentIndex = array_search($maxPercent, array_column($data, 'percent'));

        $index = $maxPercentIndex + 1;

        foreach ($this->cumulativeRatios as $i => $cumulativeRatio) {
            if ($randomNumber < $cumulativeRatio) {
                $index = $i + 1;
                break;
            }
        }
        $data = $data[$index];
        $data['seconds'] = rand(300, 500) / 100;

        $this->addBonusMember($data['amount']);

        $member = auth()->user();
        $roulette = $member->mRoulette - 1;
        $member->mRoulette = $roulette;
        $member->save();

        return $data;
    }

    private function calcCumulativeRatios(): array
    {
        $ratios = array_column($this->config, 'percent');
        $cumulativeRatios = [];
        $cumulativeSum = 0;

        foreach ($ratios as $ratio) {
            $cumulativeSum += $ratio;
            $cumulativeRatios[] = $cumulativeSum;
        }

        return $cumulativeRatios;
    }

    private function addBonusMember(float $point)
    {
        $member = auth()->user();
        $attributes = [
            'mID' => $member->mID,
            'miBankMoney' => $point,
            'miStatus' => MoneyInfo::STATUS_NINE,
            'miWallet' => MoneyInfo::TYPE_WALLET_CASINO,
            'miType' => MoneyInfo::TYPE_AD,
        ];

        /** @var MoneyInfo */
        $moneyInfo = $this->moneyInfoRepository->create($attributes);
        $this->bonusHandlerService->addBonusMoneyInfo($moneyInfo, BonusConfig::TYPE_COUPON_BONUS, BonusHandlerService::PAYMENT_METHOD_MONEY);

        $balance = ['mMoney' => $member->mMoney, 'mSportsMoney' => $member->mSportsMoney, 'mPoint' => $member->mPoint];
        event(new GetBalanceEvent($balance, $member->mID));
    }
}
