<?php

namespace App\Exports;

use App\Services\MoneyInfoService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MoneyInfoExport implements FromCollection, WithHeadings
{
    private $type = null;

    public function __construct(private MoneyInfoService $moneyInfoService, $type)
    {
        $this->type = $type;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $attributes = request()->all();

        $attributes['type'] = $this->type;

        $data = $this->moneyInfoService->get($attributes);

        return $this->formatCollection($data);
    }

    public function headings(): array
    {
        return [
            "파트너명",
            "레벨",
            "아이디 (넉네임)",
            "보유머니",
            "입금수",
            "출금수",
            "수익(입금-출금)",
            "예금주",
            "입금신청 금액",
            "보너스명",
            "신청 시간",
            "처리시간"
        ];
    }

    private function formatCollection($data)
    {
        $result = collect();
        foreach ($data as $item) {
            $result->push([
                data_get($item->member, 'partner.pName', ''),
                data_get($item->member, 'mLevel'),
                $item->member->mID ?? '' . ($item->member->mNick ?? ''),
                formatNumber(data_get($item->member, 'mMoney', 0) + data_get($item->member, 'mSportsMoney', 0)),
                formatNumber(data_get($item->member, 'sum_deposit', 0)) . '(' . data_get($item->member, 'count_deposit', 0) . ')',
                formatNumber(data_get($item->member, 'sum_withdraw', 0)) . '(' . data_get($item->member, 'count_withdraw', 0) . ')',
                formatNumber(data_get($item->member, 'totalProfit', 0)) . '원',
                data_get($item, 'miBankOwner'),
                formatNumber(data_get($item, 'miBankMoney')),
                '보너 스없음',
                data_get($item, 'miRegDate'),
                data_get($item, 'mProcessDate')

            ]);
        }
        return $result;
    }
}
