<?php

namespace App\Repositories;

use App\Models\BonusConfig;
use App\Models\PointHistory;
use Illuminate\Pagination\LengthAwarePaginator;

class PointHistoryRepository extends BaseRepository
{
    public function __construct(?array $params = [])
    {
        parent::__construct($params);
    }

    protected function getModel(): string
    {
        return PointHistory::class;
    }

    public function getList(array $conditions = [], array $order_sort = [], int $per_page = 30, array $partner_children = null): LengthAwarePaginator
    {
        @[
            'bonus_type' => $filter_bonus_type,
            'start_date' => $filter_start_date,
            'end_date' => $filter_end_date,
            'keyword' => $filter_keyword,
        ] = $conditions;

        @[
            'order_by' => $order_by,
            'sort' => $sort
        ] = $order_sort;

        return $this->model->latest()
            ->when($filter_start_date, function ($query) use ($filter_start_date) {
                $query->whereDate('phRegDate', '>=', $filter_start_date);
            })->when($filter_end_date, function ($query) use ($filter_end_date) {
                $query->whereDate('phRegDate', '<=', $filter_end_date);
            })->when($filter_bonus_type, function ($query) use ($filter_bonus_type) {
                $query->where('phBonusType', $filter_bonus_type);
            })->when($filter_keyword, function ($query) use ($filter_keyword) {
                $query->whereAny(['mID'], 'like', "%{$filter_keyword}%");
            })
            ->orderBy('phRegDate', config('constant_view.QUERY_DATABASE.DESC'))
            ->orderBy('phNo', config('constant_view.QUERY_DATABASE.DESC'))
            ->paginate($per_page);
    }

    public function getRecentPointHistory($memberID, $limit = 10)
    {
        return $this->model->where('mID', $memberID)->latest()->take($limit)->get();
    }

    public function getRolling($date)
    {
        return $this->model->where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)->whereDate('phRegDate', $date)->get();
    }
}
