<?php

namespace App\Repositories;

use Carbon\Carbon;

class TransactionRepository extends BaseRepository
{
    public function __construct(?array $params = [])
    {
        parent::__construct($params);
    }

    public function countMemberBatting($date, string $category = '', bool $is_day = true)
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $query = $this->model->select('mID')
            ->where('tType', 'bet')
            ->whereYear('tRegDate', $year)
            ->whereMonth('tRegDate', $month)
            ->distinct('mID');
        if ($is_day) {
            $query->whereDay('tRegDate', $day);
        }
        if (!empty($category)) {
            $query = $query->whereIn('gCategory', \App\Models\GameProvider::$categories[$category]);
        }
        return $query->count();
    }

    public function getData(array $params = [])
    {
        return $this->model->where($params)->get();
    }

    /**
     * Sum tAmount bet by date & category
     *
     * @param mixed $data
     * @param string $category
     * @return double
     */
    public function sumBet($date, string $category = '', bool $is_day = true)
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $query = $this->model->select('tAmount')
            ->where('tType', 'bet')
            ->whereYear('tRegDate', $year)
            ->whereMonth('tRegDate', $month);
        if ($is_day) {
            $query->whereDay('tRegDate', $day);
        }
        if (!empty($category)) {
            $query = $query->whereIn('gCategory', \App\Models\GameProvider::$categories[$category]);
        }

        return $query->sum('tAmount');
    }

    /**
     * Sum tAmount Win by date & category
     *
     * @param mixed $data
     * @param string $category
     * @return double
     */
    public function sumWin($date, string $category = '', bool $is_day = true)
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $query = $this->model->select('tAmount')
            ->where('tType', 'win')
            ->whereYear('tRegDate', $year)
            ->whereMonth('tRegDate', $month);
        if ($is_day) {
            $query->whereDay('tRegDate', $day);
        }
        if (!empty($category)) {
            $query = $query->whereIn('gCategory', \App\Models\GameProvider::$categories[$category]);
        }

        return $query->sum('tAmount');
    }

    public function getBet($date)
    {
        return $this->model->where('tType', 'bet')->whereDate('tRegDate', $date)->get();
    }

    public function getWin($date)
    {
        return $this->model->where('tType', 'win')->whereDate('tRegDate', $date)->get();
    }

    public function getDataSlotAndCasinoPagination(array $params = [])
    {
        $query = $this->model->with(['member', 'member.partner', 'game_provider'])
            ->where('tRoundId', '!=', NULL)
            ->where('tType', 'Bet');

        if (data_get($params, 'gCategory')) {
            $query = $query->whereIn('gCategory', data_get($params, 'gCategory'));
        }

        if (data_get($params, 'start_date') && data_get($params, 'end_date')) {

            $start = Carbon::parse(data_get($params, 'start_date'))->startOfDay();
            $end = Carbon::parse(data_get($params, 'end_date'))->endOfDay();

            $query = $query->whereBetween('tRegDate', [$start, $end]);
        }

        if (data_get($params, 'search_input')) {

            $query = $query->where(function ($query) use ($params) {
                $query->whereHas('member.partner', function ($query) use ($params) {
                    $query->where('mPartnerName', 'like', '%' . data_get($params, 'search_input') . '%');
                })
                    ->orWhereHas('member', function ($query) use ($params) {
                        $query->where('mNick', 'like', '%' . data_get($params, 'search_input') . '%');
                    });
            });
        }

        if (data_get($params, 'provider')) {
            $query = $query->where('pCode', data_get($params, 'provider'));
        }

        return $query->orderBy('tRegDate', 'desc')->paginate(data_get($params, 'per_page'));
    }

    public function getRecentTransactionHistory($memberID, $limit = 10)
    {
        return $this->model->where('mID', $memberID)->latest()->take($limit)->get();
    }

    public function getBetTypeByRoundID($roundID)
    {
        return $this->model
            ->where('tType', 'Bet')
            ->where('tRoundId', $roundID)
            ->first();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\Transaction::class;
    }
}
