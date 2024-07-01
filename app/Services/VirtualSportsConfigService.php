<?php

namespace App\Services;

use App\Repositories\VirtualSportsConfigRepository;

class VirtualSportsConfigService extends BaseService
{
    public function __construct(
        private VirtualSportsConfigRepository $virtualSportsConfigRepo
    ) {
    }

    public function update(array $data): bool
    {
        $config = $this->virtualSportsConfigRepo->getConfig();

        if (empty($config)) {
            $attr = $this->initData($data);
            $created = $this->virtualSportsConfigRepo->create($attr);

            return $created ? true : false;
        }

        $attr = $this->initData($data);

        return $this->tryCatchFuncDB(function () use ($config, $attr) {
            $this->virtualSportsConfigRepo->updateByPK($config, $attr);
        });
    }

    public function toggleField(string $field): bool
    {
        $config = $this->virtualSportsConfigRepo->getConfig();

        if (empty($config)) {
            return false;
        }

        $data = [];
        $data[$field] = data_get($config, $field) ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->virtualSportsConfigRepo->updateByPK($config, $data);
        });
    }

    public function initData(array $data): array
    {

        $attr = [
            'vcNoticeBlockBet' => data_get($data, 'vcNoticeBlockBet'),
            'vcTimeBet' => data_get($data, 'vcTimeBet'),
            'vcDuplicateBetCount' => data_get($data, 'vcDuplicateBetCount'),
            'vcMaxBetFolderCount' => data_get($data, 'vcMaxBetFolderCount'),


            'vcMemberLosingPoints' => $this->convertFloatInArray(data_get($data, 'vcMemberLosingPoints')),
            'vcMemberRollingPoints' => $this->convertFloatInArray(data_get($data, 'vcMemberRollingPoints')),

            'vcMinBetAmount1' => $this->convertFloatInArray(data_get($data, 'vcMinBetAmount1')),
            'vcMinBetAmount2' => $this->convertFloatInArray(data_get($data, 'vcMinBetAmount2')),
            'vcMinBetAmount3' => $this->convertFloatInArray(data_get($data, 'vcMinBetAmount3')),

            'vcMaxBetAmount1' => $this->convertFloatInArray(data_get($data, 'vcMaxBetAmount1')),
            'vcMaxBetAmount2' => $this->convertFloatInArray(data_get($data, 'vcMaxBetAmount2')),
            'vcMaxBetAmount3' => $this->convertFloatInArray(data_get($data, 'vcMaxBetAmount3')),

            'vcMaxBetPayout1' => $this->convertFloatInArray(data_get($data, 'vcMaxBetPayout1')),
            'vcMaxBetPayout2' => $this->convertFloatInArray(data_get($data, 'vcMaxBetPayout2')),
            'vcMaxBetPayout3' => $this->convertFloatInArray(data_get($data, 'vcMaxBetPayout3')),

            'vcUserAllocationByLevel' => $this->convertFloatInArray(data_get($data, 'vcUserAllocationByLevel')),
            'vcMaxPayout' => $this->convertFloatInArray(data_get($data, 'vcMaxPayout')),
        ];

        return $attr;
    }
}
