<?php

namespace App\Repositories;

use App\Models\Cash;
use App\Models\MoneyInfo;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

class CashRepository extends BaseRepository
{
    const FILTER_ADMIN = 'admin';

    const FILTER_ROLLBACK = 'rollback';

    protected function getModel(): string
    {
        return Cash::class;
    }

    public function __construct(?array $params = [])
    {
        parent::__construct($params);
    }

    public function getListCashRelation(int $perPage = 30)
    {
        $filter = request('filter');
        $search = request('search');
        $money_info = in_array($filter, [MoneyInfo::TYPE_UD, MoneyInfo::TYPE_UW, MoneyInfo::TYPE_EM, self::FILTER_ADMIN, self::FILTER_ROLLBACK]);
        $transaction = in_array($filter, [Transaction::tTYPE_BET, Transaction::tTYPE_WIN, Transaction::tTYPE_CANCEL_WIN, Transaction::tTYPE_CANCEL_BET]);
        $query = $this->model->orderBy('cRegDate', 'desc')->where('cAmount', '!=', 0);
        if ($money_info) {
            $query->whereHas('money_info_history', function (Builder $query) use ($filter, $search) {
                if ($filter == self::FILTER_ADMIN) $query->whereIn('miType', [MoneyInfo::TYPE_AW, MoneyInfo::TYPE_AD])->where('mihStatus', MoneyInfo::STATUS_NINE);
                else if ($filter == self::FILTER_ROLLBACK) $query->where('mihStatus', MoneyInfo::STATUS_TWO);
                else $query->where('miType', $filter)->where('mihStatus', MoneyInfo::STATUS_NINE);
            });
        }

        if ($transaction) {
            $query->whereHas('transaction', function (Builder $query) use ($filter, $search) {
                $query->where('tType', $filter);
            });
        }

        if (request('start_date')) {
            $query->where('cRegDate', '>=', request('start_date'));
        }

        if (request('end_date')) {
            $query->where('cRegDate', '<=', request('end_date'));
        }

        if ($search) {
            $query->where('mID', 'like', "%$search%");
        }

        return $query->paginate($perPage);
    }
}
