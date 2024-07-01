<?php

namespace App\Services;

use App\Models\BonusConfig;
use App\Models\Member;
use App\Repositories\BonusConfigRepository;
use App\Repositories\CasinoConfigRepository;
use Carbon\Carbon;

class CasinoConfigService extends BaseService
{
    public function __construct(
        private CasinoConfigRepository $casinoConfigRepository,
        private RechargeConfigService $rechargeConfigService,
        private BonusConfigRepository $bonusConfigRepository,
    ) {
    }

    public function update(array $data, string $ccType): bool
    {
        $config = $this->casinoConfigRepository->getConfig($ccType);

        if (empty($config)) {
            return false;
        }

        $attr = $this->initData($data);

        return $this->tryCatchFuncDB(function () use ($config, $attr) {
            $this->casinoConfigRepository->updateByPK($config, $attr);
        });
    }

    public function convertFloat(array $data): array
    {
        return array_map(function ($value) {
            $value = str_replace(',', '', $value);
            return floatval($value);
        }, $data);
    }

    public function toggleField(string $field, string $ccType): bool
    {
        $config = $this->casinoConfigRepository->getConfig($ccType);

        if (empty($config)) {
            return false;
        }

        $data = [];
        $data[$field] = data_get($config, $field) ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->casinoConfigRepository->updateByPK($config, $data);
        });
    }

    public function getConfigText(): ?string
    {
        /** @var Member */
        $member = auth('sanctum')->user();
        $member_bonus = $this->getMemberRechargeBonus($member);
        if (!$member_bonus) {
            return null;
        }

        return '카지노 - ' . $member_bonus['char'] . '입금보너스 ' . $member_bonus['percent'] . '%, 최대 ' . formatNumber($member_bonus['money']) . ' 원까지.';
    }

    public function initData(array $data): array
    {

        $attr = [
            'ccNoticeBlockBet' => data_get($data, 'ccNoticeBlockBet'),
            'ccDuplicateBetCount' => data_get($data, 'ccDuplicateBetCount'),

            'ccMemberLosingPoints' => $this->convertFloat(data_get($data, 'ccMemberLosingPoints')),
            'ccMemberRollingPoints' => $this->convertFloat(data_get($data, 'ccMemberRollingPoints')),

            'ccMinBetAmount' => $this->convertFloat(data_get($data, 'ccMinBetAmount')),
            'ccMaxBetPayout' => $this->convertFloat(data_get($data, 'ccMaxBetPayout')),

            'ccUserAllocationByLevel' => $this->convertFloat(data_get($data, 'ccUserAllocationByLevel')),
            'ccMaxPayout' => $this->convertFloat(data_get($data, 'ccMaxPayout')),
        ];

        return $attr;
    }

    public function getMemberRechargeBonus($member)
    {
        $isMemberHasFirstTimeRecharged = $member->money_infos()->where('miType', \App\Models\MoneyInfo::TYPE_UD)->exists();
        $config = app(BonusConfig::TYPE_RECHARGE_BONUS);
        $bonusRecharge = $this->bonusConfigRepository->getValue($config);
        $key = $isMemberHasFirstTimeRecharged ? 'casino_recharge' : 'casino_first_time_recharge';
        $bonusRechargeStatus = $bonusRecharge['table'][$member->mLevel][$key]['is_payment_upon_withdraw'] ?? null;

        if (!$bonusRechargeStatus) {
            return false;
        }

        $rechargeConfig = $this->rechargeConfigService->getConfig();
        $isWeekend = Carbon::today()->isWeekend();

        return [
            'percent' => $isWeekend ? $bonusRecharge['table'][$member->mLevel][$key]['weekend_rate'] : $bonusRecharge['table'][$member->mLevel][$key]['weekday_rate'],
            'money' => $isMemberHasFirstTimeRecharged ? $rechargeConfig->rcMaxBonusCasinoRecharge : $rechargeConfig->rcMaxBonusFirstTimeCasinoRecharge,
            'char' => $isMemberHasFirstTimeRecharged ? '매' : '첫',
        ];
    }

    public function getConfig(string $ccType)
    {
        $config = $this->casinoConfigRepository->getConfig($ccType);

        if (!$config) return [];

        $res['enable'] = !$config->ccBlockBet;

        return $res;
    }
}
