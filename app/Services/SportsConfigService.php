<?php

namespace App\Services;

use App\Models\BonusConfig;
use App\Models\Member;
use App\Repositories\BonusConfigRepository;
use App\Repositories\SportsConfigRepository;
use Carbon\Carbon;

class SportsConfigService extends BaseService
{
    public function __construct(
        private SportsConfigRepository $sportsConfigRepo,
        private RechargeConfigService $rechargeConfigService,
        private BonusConfigRepository $bonusConfigRepository,
    ) {
    }

    public function update(array $data): bool
    {
        $config = $this->sportsConfigRepo->getConfig();

        if (empty($config)) {
            return false;
        }

        $attr = $this->initData($data);

        return $this->tryCatchFuncDB(function () use ($config, $attr) {
            $this->sportsConfigRepo->updateByPK($config, $attr);
        });
    }

    public function toggleField(string $field): bool
    {
        $config = $this->sportsConfigRepo->getConfig();

        if (empty($config)) {
            return false;
        }

        $data = [];
        $data[$field] = data_get($config, $field) ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->sportsConfigRepo->updateByPK($config, $data);
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

        return '스포츠 - ' . $member_bonus['char'] . '입금보너스 ' . $member_bonus['percent'] . '%, 최대 ' . formatNumber($member_bonus['money']) . ' 원까지.';
    }

    public function initData(array $data): array
    {

        $attr = [
            'scNoticeBlockBet' => data_get($data, 'scNoticeBlockBet'),
            'scTimeBet' => data_get($data, 'scTimeBet'),
            'scDuplicateBetCount' => data_get($data, 'scDuplicateBetCount'),
            'scMaxBetFolderCount' => data_get($data, 'scMaxBetFolderCount'),
            'scValueUseBonusAllFolder' => $this->convertStringToFloat(data_get($data, 'scValueUseBonusAllFolder')),
            'sc3FolderBonusOdds' => data_get($data, 'sc3FolderBonusOdds'),
            'sc6FolderBonusOdds' => data_get($data, 'sc6FolderBonusOdds'),
            'sc9FolderBonusOdds' => data_get($data, 'sc9FolderBonusOdds'),
            'scMaxCancelSingleBet' => data_get($data, 'scMaxCancelSingleBet'),
            'scSecondCancelAfterBet' => data_get($data, 'scSecondCancelAfterBet'),
            'scMinusCancelAfterBet' => data_get($data, 'scMinusCancelAfterBet'),
            'scSoccerFeed' => data_get($data, 'scSoccerFeed'),
            'scBasketballFeed' => data_get($data, 'scBasketballFeed'),
            'scBaseballFeed' => data_get($data, 'scBaseballFeed'),
            'scVolleyballFeed' => data_get($data, 'scVolleyballFeed'),
            'scIceHockeyFeed' => data_get($data, 'scIceHockeyFeed'),
            'scHandballFeed' => data_get($data, 'scHandballFeed'),
            'scTenisFeed' => data_get($data, 'scTenisFeed'),
            'scAmericanFootballFeed' => data_get($data, 'scAmericanFootballFeed'),
            'scEsportsFeed' => data_get($data, 'scEsportsFeed'),
            'scPingPongFeed' => data_get($data, 'scPingPongFeed'),
            'scBoxingFeed' => data_get($data, 'scBoxingFeed'),

            'scMemberLosingPoints' => $this->convertFloatInArray(data_get($data, 'scMemberLosingPoints')),
            'scMemberRollingPoints' => $this->convertFloatInArray(data_get($data, 'scMemberRollingPoints')),

            'scMaxBetAmount' => $this->convertFloatInArray(data_get($data, 'scMaxBetAmount')),
            'scMaxBetWinAmount' => $this->convertFloatInArray(data_get($data, 'scMaxBetWinAmount')),

            'scMinBetAmount1' => $this->convertFloatInArray(data_get($data, 'scMinBetAmount1')),
            'scMinBetAmount2' => $this->convertFloatInArray(data_get($data, 'scMinBetAmount2')),
            'scMinBetAmount3' => $this->convertFloatInArray(data_get($data, 'scMinBetAmount3')),
            'scMaxBetAmount1' => $this->convertFloatInArray(data_get($data, 'scMaxBetAmount1')),
            'scMaxBetAmount2' => $this->convertFloatInArray(data_get($data, 'scMaxBetAmount2')),
            'scMaxBetAmount3' => $this->convertFloatInArray(data_get($data, 'scMaxBetAmount3')),
            'scMaxBetPayout1' => $this->convertFloatInArray(data_get($data, 'scMaxBetPayout1')),
            'scMaxBetPayout2' => $this->convertFloatInArray(data_get($data, 'scMaxBetPayout2')),
            'scMaxBetPayout3' => $this->convertFloatInArray(data_get($data, 'scMaxBetPayout3')),

            'scUserAllocationByLevel' => $this->convertFloatInArray(data_get($data, 'scUserAllocationByLevel')),
            'scMaxPayout' => $this->convertFloatInArray(data_get($data, 'scMaxPayout')),
        ];

        return $attr;
    }

    public function getMemberRechargeBonus(Member $member)
    {
        $isMemberHasFirstTimeRecharged = $member->money_infos()->where('miType', \App\Models\MoneyInfo::TYPE_UD)->exists();
        $config = app(BonusConfig::TYPE_RECHARGE_BONUS);
        $bonusRecharge = $this->bonusConfigRepository->getValue($config);
        $key = $isMemberHasFirstTimeRecharged ? 'sports_recharge' : 'sports_first_time_recharge';
        $bonusRechargeStatus = $bonusRecharge['table'][$member->mLevel][$key]['is_payment_upon_withdraw'] ?? null;

        if (!$bonusRechargeStatus) {
            return null;
        }

        $rechargeConfig = $this->rechargeConfigService->getConfig();
        $isWeekend = Carbon::today()->isWeekend();

        return [
            'percent' => $isWeekend ? $bonusRecharge['table'][$member->mLevel][$key]['weekend_rate'] : $bonusRecharge['table'][$member->mLevel][$key]['weenday_rate'],
            'money' => $isMemberHasFirstTimeRecharged ? $rechargeConfig->rcMaxBonusSportsRecharge : $rechargeConfig->rcMaxBonusFirstTimeSportsRecharge,
            'char' => $isMemberHasFirstTimeRecharged ? '매' : '첫',
        ];
    }
}
