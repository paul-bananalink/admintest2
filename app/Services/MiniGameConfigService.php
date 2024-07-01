<?php

namespace App\Services;

use App\Repositories\MiniGameConfigRepository;
use App\Models\MiniGameConfig;

class MiniGameConfigService extends BaseService
{
    public function __construct(
        private MiniGameConfigRepository $miniGameConfigRepository
    ) {
    }

    public function update(array $data, string $gcType): bool
    {
        $config = $this->miniGameConfigRepository->getConfig($gcType);

        if (empty($config)) {
            return false;
        }

        if ($gcType == MiniGameConfig::TYPE_MINI_GAME)
            $attr = $this->initDataMiniGame($data);
        elseif ($gcType == MiniGameConfig::TYPE_LOTUS)
            $attr = $this->initDataLotus($data);
        elseif ($gcType == MiniGameConfig::TYPE_MGM)
            $attr = $this->initDataMGM($data);
        elseif ($gcType == MiniGameConfig::TYPE_BET_GAGME_TV)
            $attr = $this->initDataBetGameTV($data);


        return $this->tryCatchFuncDB(function () use ($config, $attr) {
            $this->miniGameConfigRepository->updateByPK($config, $attr);
        });
    }

    public function toggleField(string $field, string $gcType): bool
    {
        $config = $this->miniGameConfigRepository->getConfig($gcType);

        if (empty($config)) {
            return false;
        }

        $data = [];
        $data[$field] = data_get($config, $field) ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->miniGameConfigRepository->updateByPK($config, $data);
        });
    }

    public function initDataMiniGame(array $data): array
    {

        $attr = [
            'gcNoticeBlockBet' => data_get($data, 'gcNoticeBlockBet'),
            'gcDuplicateBetCount' => data_get($data, 'gcDuplicateBetCount'),

            'gcTimeBet' => data_get($data, 'gcTimeBet'),
            'gcPower_OddEven_OverUnder_BettingOdds' => data_get($data, 'gcPower_OddEven_OverUnder_BettingOdds'),
            'gcGeneral_OddEven_OverUnder_BettingOdds' => data_get($data, 'gcGeneral_OddEven_OverUnder_BettingOdds'),
            'gcGeneral_SmallBettingOdds' => data_get($data, 'gcGeneral_SmallBettingOdds'),
            'gcGeneral_MediumBettingOdds' => data_get($data, 'gcGeneral_MediumBettingOdds'),
            'gcGeneral_LargeBettingOdds' => data_get($data, 'gcGeneral_LargeBettingOdds'),
            'gcPowerNumberBettingOdds' => data_get($data, 'gcPowerNumberBettingOdds'),
            'gcPowerOdd_OverEven_UnderBettingOdds' => data_get($data, 'gcPowerOdd_OverEven_UnderBettingOdds'),
            'gcPowerOdd_UnderEven_OverBettingOdds' => data_get($data, 'gcPowerOdd_UnderEven_OverBettingOdds'),

            'gcGeneralOdd_OverEven_UnderBettingOdds' => data_get($data, 'gcGeneralOdd_OverEven_UnderBettingOdds'),
            'gcGeneralOdd_UnderEven_OverBettingOdds' => data_get($data, 'gcGeneralOdd_UnderEven_OverBettingOdds'),
            'gcPowerGeneralCombinationBettingOdds' => data_get($data, 'gcPowerGeneralCombinationBettingOdds'),
            'gcGeneralOddEven_SmallBettingOdds' => data_get($data, 'gcGeneralOddEven_SmallBettingOdds'),
            'gcGeneralOddEven_MediumBettingOdds' => data_get($data, 'gcGeneralOddEven_MediumBettingOdds'),
            'gcGeneralOddEven_LargeBettingOdds' => data_get($data, 'gcGeneralOddEven_LargeBettingOdds'),

            'gcMemberLosingPoints' => $this->convertFloatInArray(data_get($data, 'gcMemberLosingPoints')),
            'gcMemberRollingPoints' => $this->convertFloatInArray(data_get($data, 'gcMemberRollingPoints')),

            'gcMinBetAmount' => $this->convertFloatInArray(data_get($data, 'gcMinBetAmount')),
            'gcMaxBetAmount' => $this->convertFloatInArray(data_get($data, 'gcMaxBetAmount')),
            'gcMaxBetPayout' => $this->convertFloatInArray(data_get($data, 'gcMaxBetPayout')),
            'gcMaxPayout' => $this->convertFloatInArray(data_get($data, 'gcMaxPayout')),
        ];

        return $attr;
    }

    public function initDataLotus(array $data): array
    {

        $attr = [
            'gcNoticeBlockBet' => data_get($data, 'gcNoticeBlockBet'),
            'gcDuplicateBetCount' => data_get($data, 'gcDuplicateBetCount'),
            'gcTimeBet' => data_get($data, 'gcTimeBet'),

            'gcPlayerOdds' => data_get($data, 'gcPlayerOdds'),
            'gcBankerOdds' => data_get($data, 'gcBankerOdds'),
            'gcPairOdds' => data_get($data, 'gcPairOdds'),
            'gcTieOdds' => data_get($data, 'gcTieOdds'),

            'gcMemberLosingPoints' => $this->convertFloatInArray(data_get($data, 'gcMemberLosingPoints')),
            'gcMemberRollingPoints' => $this->convertFloatInArray(data_get($data, 'gcMemberRollingPoints')),

            'gcMinBetAmount' => $this->convertFloatInArray(data_get($data, 'gcMinBetAmount')),
            'gcMaxBetAmount' => $this->convertFloatInArray(data_get($data, 'gcMaxBetAmount')),
            'gcMaxBetPayout' => $this->convertFloatInArray(data_get($data, 'gcMaxBetPayout')),
            'gcMaxPayout' => $this->convertFloatInArray(data_get($data, 'gcMaxPayout')),
        ];

        return $attr;
    }

    public function initDataMGM(array $data): array
    {

        $attr = [
            'gcNoticeBlockBet' => data_get($data, 'gcNoticeBlockBet'),
            'gcDuplicateBetCount' => data_get($data, 'gcDuplicateBetCount'),
            'gcTimeBet' => data_get($data, 'gcTimeBet'),

            'gcPlayerOdds' => data_get($data, 'gcPlayerOdds'),
            'gcBankerOdds' => data_get($data, 'gcBankerOdds'),
            'gcPairOdds' => data_get($data, 'gcPairOdds'),
            'gcTieOdds' => data_get($data, 'gcTieOdds'),

            'gcMemberLosingPoints' => $this->convertFloatInArray(data_get($data, 'gcMemberLosingPoints')),
            'gcMemberRollingPoints' => $this->convertFloatInArray(data_get($data, 'gcMemberRollingPoints')),

            'gcMinBetAmount' => $this->convertFloatInArray(data_get($data, 'gcMinBetAmount')),
            'gcMaxBetAmount' => $this->convertFloatInArray(data_get($data, 'gcMaxBetAmount')),
            'gcMaxBetPayout' => $this->convertFloatInArray(data_get($data, 'gcMaxBetPayout')),
            'gcMaxPayout' => $this->convertFloatInArray(data_get($data, 'gcMaxPayout')),
        ];

        return $attr;
    }

    public function initDataBetGameTV(array $data): array
    {

        $attr = [
            'gcNoticeBlockBet' => data_get($data, 'gcNoticeBlockBet'),
            'gcDuplicateBetCount' => data_get($data, 'gcDuplicateBetCount'),

            'gcMemberLosingPoints' => $this->convertFloatInArray(data_get($data, 'gcMemberLosingPoints')),
            'gcMemberRollingPoints' => $this->convertFloatInArray(data_get($data, 'gcMemberRollingPoints')),

            'gcMinBetAmount' => $this->convertFloatInArray(data_get($data, 'gcMinBetAmount')),
            'gcMaxBetAmount' => $this->convertFloatInArray(data_get($data, 'gcMaxBetAmount')),
            'gcMaxBetPayout' => $this->convertFloatInArray(data_get($data, 'gcMaxBetPayout')),
            'gcMaxPayout' => $this->convertFloatInArray(data_get($data, 'gcMaxPayout')),
        ];

        return $attr;
    }
}
