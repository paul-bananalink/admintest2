<?php

namespace App\Services;

use App\Repositories\CashRepository;
use App\Models\Cash;

class CashService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly CashRepository $cashRepository,
    ) {
    }

    public function getRepo(): CashRepository
    {
        return $this->cashRepository;
    }

    public function init($data, $table): array
    {
        if ($table == Cash::MONEY_INFO_TABLE_HISTORY) {
            $cID = $data->mihNo;
            $mMoney = $data->member->mMoney ?? 0;
            $mSportsMoney = $data->member->mSportsMoney ?? 0;
            $amount = $data->miBankMoney ?? 0;
        } else {
            $cID = $data->uuid;
            $mMoney = $data->member->mMoney ?? 0;
            $mSportsMoney = $data->member->mSportsMoney ?? 0;
            $amount = $data->tAmount ?? 0;
        }
        return [
            'cID' => $cID,
            'cTable' => $table,
            'mMoney' => $mMoney,
            'mSportsMoney' => $mSportsMoney,
            'cAmount' => $amount,
            'cRegDate' => date('Y-m-d H:i:s'),
            'mID' => $data->member->mID,
        ];
    }
}
