<?php

namespace App\Services;

use App\Repositories\RealtimeConfigRepository;

class RealtimeConfigService extends BaseService
{
    public function __construct(
        private RealtimeConfigRepository $realtimeConfigRepo
    ) {
    }

    public function update(array $data): bool
    {
        $config = $this->realtimeConfigRepo->getConfig();

        if (empty($config)) {
            return false;
        }

        $attr = $this->initData($data);

        return $this->tryCatchFuncDB(function () use ($config, $attr) {
            $this->realtimeConfigRepo->updateByPK($config, $attr);
        });
    }

    public function convertFloat(array $data): array
    {
        return array_map(function ($value) {
            $value = str_replace(',', '', $value);
            return floatval($value);
        }, $data);
    }

    public function toggleField(string $field): bool
    {
        $config = $this->realtimeConfigRepo->getConfig();

        if (empty($config)) {
            return false;
        }

        $data = [];
        $data[$field] = data_get($config, $field) ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->realtimeConfigRepo->updateByPK($config, $data);
        });
    }

    public function initData(array $data): array
    {

        $attr = [
            'rtcNoticeBlockBet' => data_get($data, 'rtcNoticeBlockBet'),
            'rtcDuplicateBetCount' => data_get($data, 'rtcDuplicateBetCount'),
            'rtcMaxBetFolderCount' => data_get($data, 'rtcMaxBetFolderCount'),
            'rtcRealtimeSoccer' => data_get($data, 'rtcRealtimeSoccer'),
            'rtcRealtimeBasketball' => data_get($data, 'rtcRealtimeBasketball'),
            'rtcRealtimeBaseball' => data_get($data, 'rtcRealtimeBaseball'),
            'rtcRealtimeVolleyball' => data_get($data, 'rtcRealtimeVolleyball'),
            'rtcRealtimeHockey' => data_get($data, 'rtcRealtimeHockey'),
            'rtcRealtimeEsports' => data_get($data, 'rtcRealtimeEsports'),
            'rtcFeed' => data_get($data, 'rtcFeed'),

            'rtcMemberLosingPoints' => $this->convertFloat(data_get($data, 'rtcMemberLosingPoints')),
            'rtcMemberRollingPoints' => $this->convertFloat(data_get($data, 'rtcMemberRollingPoints')),

            'rtcMinBetAmount1' => $this->convertFloat(data_get($data, 'rtcMinBetAmount1')),
            'rtcMinBetAmount2' => $this->convertFloat(data_get($data, 'rtcMinBetAmount2')),
            'rtcMinBetAmount3' => $this->convertFloat(data_get($data, 'rtcMinBetAmount3')),
            'rtcMaxBetAmount1' => $this->convertFloat(data_get($data, 'rtcMaxBetAmount1')),
            'rtcMaxBetAmount2' => $this->convertFloat(data_get($data, 'rtcMaxBetAmount2')),
            'rtcMaxBetAmount3' => $this->convertFloat(data_get($data, 'rtcMaxBetAmount3')),
            'rtcMaxBetPayout1' => $this->convertFloat(data_get($data, 'rtcMaxBetPayout1')),
            'rtcMaxBetPayout2' => $this->convertFloat(data_get($data, 'rtcMaxBetPayout2')),
            'rtcMaxBetPayout3' => $this->convertFloat(data_get($data, 'rtcMaxBetPayout3')),

            'rtcUserAllocationByLevel' => $this->convertFloat(data_get($data, 'rtcUserAllocationByLevel')),
            'rtcMaxPayout' => $this->convertFloat(data_get($data, 'rtcMaxPayout')),
        ];

        return $attr;
    }
}
