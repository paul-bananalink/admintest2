<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\MoneyInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class MoneyInfoRepository extends BaseRepository
{
    public function __construct(?array $params = [])
    {
        parent::__construct($params);
    }

    /**
     * Get count order register withdraw by date
     *
     * @param mixed $date
     * @param bool $is_day
     * @return int
     */
    public function getCountOrderWithdrawRegisterByDate($date, bool $is_day = true): int
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $query = $this->model->whereIn('miType', [\App\Models\MoneyInfo::TYPE_UW, \App\Models\MoneyInfo::TYPE_AW])
            ->whereYear('miRegDate', $year)
            ->whereMonth('miRegDate', $month);
        if ($is_day) {
            $query->whereDay('miRegDate', $day);
        }
        return $query->count();
    }

    /**
     * Get money order Withdraw register today
     */
    public function getMoneyOrderWithdrawRegisterToday(): int
    {
        return $this->model->whereDate('miRegDate', now()->today())
            ->whereIn('miType', [\App\Models\MoneyInfo::TYPE_UW, \App\Models\MoneyInfo::TYPE_AW])
            ->sum("{$this->tableName}.miBankMoney");
    }

    /**
     * Get sum money register withdraw approved by date
     *
     * @param mixed $date
     * @param bool $is_day
     * @return mixed
     */
    public function getMoneyRegisterWithdrawApprovedByDate($date, bool $is_day = true)
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $query = $this->model->whereIn('miType', [\App\Models\MoneyInfo::TYPE_UW, \App\Models\MoneyInfo::TYPE_UW])
        ->where('miStatus', \App\Models\MoneyInfo::STATUS_NINE)  // Check for both STATUS_NINE
            ->whereYear('miRegDate', $year)
            ->whereMonth('miRegDate', $month);
        if ($is_day) {
            $query->whereDay('miRegDate', $day);
        }
        return $query->get();
    }

    /**
     * Get count order register deposite by date
     *
     * @param mixed $date
     * @return int
     */
    public function getCountOrderDepositeRegisterByDate($date, bool $is_day = true): int
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $query = $this->model->where('miType', \App\Models\MoneyInfo::TYPE_UD)
            ->whereYear('miRegDate', $year)
            ->whereMonth('miRegDate', $month);
        if ($is_day) {
            $query->whereDay('miRegDate', $day);
        }
        return $query->count();
    }

    /**
     * Get sum money register deposite today
     *
     * @return int|float
     */
    public function getMoneyOrderDepositeRegisterToday(): int
    {
        return $this->model->whereDate('miRegDate', now()->today())
            ->where('miType', [\App\Models\MoneyInfo::TYPE_UD])
            ->sum("{$this->tableName}.miBankMoney");
    }

    /**
     * Get sum money register deposite approved by date
     *
     * @param mixed $date
     * @return mixed
     */
    public function getMoneyRegisterRechargeApprovedByDate($date, bool $is_day = true)
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));

        $query = $this->model
            ->where('miStatus', \App\Models\MoneyInfo::STATUS_NINE)
            ->whereIn('miType', [\App\Models\MoneyInfo::TYPE_UD, \App\Models\MoneyInfo::TYPE_UW])
            ->whereYear('miRegDate', $year)
            ->whereMonth('miRegDate', $month);
        if ($is_day) {
            $query = $query->whereDay('miRegDate', $day);
        }
        
        return $query->get();
    }

    public function countUserRechargeByDate($date, bool $is_day = true)
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        $query = $this->model->where('miType', \App\Models\MoneyInfo::TYPE_UD)
            ->distinct('mID')
            ->whereYear('miRegDate', $year)
            ->whereMonth('miRegDate', $month);
        if ($is_day) {
            $query->whereDay('miRegDate', $day);
        }
        return $query->count();
    }

    public function deleteByDays(array $attributes)
    {
        $type = $attributes['type'];
        $days = $attributes['days'];
        $startDay = now()->subDays($days)->startOfDay();

        if ($type == "recharge") {
            $miType = MoneyInfo::TYPE_UD;
        } else {
            $miType = MoneyInfo::TYPE_UW;
        }

        return $this->model->whereDate('miRegDate', '>=', $startDay)->where('miType', $miType)->delete();
    }

    public function sumMoneyPerDay(Member $member, string $miType): int
    {
        return $member->money_infos()->where('miType', $miType)->where('miStatus', MoneyInfo::STATUS_NINE)->whereDate('miRegDate', now())->sum('miBankMoney');
    }

    public function moneyInfosMiRegDateLatest(Member $member, string $miType): ?Carbon
    {
        return $member->money_infos()->where('miType', $miType)->latest()->first()?->miRegDate;
    }

    public function getRecentRechargeWithdrawHistory($memberID, $type = 'recharge', $limit = 10)
    {
        return $this->model->where('mID', $memberID)->whereIn('miType', MoneyInfo::MI_TYPE_FILTER[$type])->latest()->take($limit)->get();
    }

    /**
     * get member logged from date to date
     *
     * @param string $date_from
     * @param string $date_to
     * @param array $order_sort
     * @param int $per_page
     * @return mixed
     */
    public function getBonusByAdminFilter(string $wallet = null, bool $is_first = false, array $order_sort = [], array $filter_search = [], int $per_page = 30, array $partner_children = null)
    {
        [
            'order_by' => $order_by,
            'sort' => $sort
        ] = $order_sort;

        [
            'keyword' => $keyword,
            'start_date' => $start_date,
            'end_date' => $end_date
        ] = $filter_search;

        return $this->model->select('*')
            ->from(function ($query) use ($wallet, $order_by, $sort, $keyword, $start_date, $end_date, $partner_children) {
                $query->select(
                    'money_info.*',
                    DB::raw('(CASE WHEN ROW_NUMBER() OVER (PARTITION BY MID ORDER BY mProcessDate) = 1 THEN 1 ELSE 0 END) AS isFirstRecharge'),
                    DB::raw('(CASE WHEN COALESCE(miBankMoney, 0) * COALESCE(miBonusPercent, 0) / 100 > COALESCE(miMaxBonusRecharge, 0) / 100 THEN COALESCE(miMaxBonusRecharge, 0) ELSE COALESCE(miBankMoney, 0) * COALESCE(miBonusPercent, 0) / 100 END) AS bonusMoney')
                )
                    ->from('money_info')
                    ->join('member', 'member.mID', '=', 'money_info.mID')
                    ->leftJoin('partners', 'partners.mID', '=', 'member.mMemberID')
                    ->where('miType', MoneyInfo::TYPE_UD)
                    ->whereNotIn('member.mLevel', Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
                    ->when($wallet, function ($query) use ($wallet) {
                        $query->where('miWallet', $wallet);
                    })
                    ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                        $start = Carbon::parse($start_date)->startOfDay();
                        $end = Carbon::parse($end_date)->endOfDay();
                        $query->whereBetween('mProcessDate', [$start, $end]);
                    })
                    ->when($keyword, function ($query, $keyword) {
                        $query->where(function ($query) use ($keyword) {
                            $query->where('member.mID', 'like', "%{$keyword}%")
                                ->orWhere('member.mNick', 'like', "%{$keyword}%")
                                ->orWhere('member.mLevel', $keyword)
                                ->orWhere('partners.pName', 'like', "%{$keyword}%");
                        });
                    })
                    ->when($partner_children, function ($query, $partner_children) {
                        $query->whereIn('member.mID', $partner_children);
                    })
                    ->whereNotNull('mProcessDate')
                    ->orderBy(
                        $order_by ?? 'mProcessDate',
                        $sort ? config('constant_view.QUERY_DATABASE.DESC') : config('constant_view.QUERY_DATABASE.ASC')
                    );
            }, 'subquery')
            ->when($wallet || $is_first, function ($query) use ($is_first) {
                $query->where('isFirstRecharge', $is_first);
            })
            ->paginate($per_page);
    }

    public function getApprovedRechargeByDateTimeRange($dateTimeRange): Collection
    {
        [$from, $to] = explode(' - ', $dateTimeRange);

        return $this->model->where('miType', MoneyInfo::TYPE_UD)->whereBetween('mProcessDate', [$from, $to])->get();
    }

    public function countMemberRechargeByDay($mID, $date)
    {
        return $this->model->whereDate('miRegDate', $date)->where(['mID' => $mID, 'miType' => MoneyInfo::TYPE_UD, 'miStatus' => MoneyInfo::STATUS_NINE])->count();
    }

    public function getAmountRechagreByProcessDate(int $limit, string $start_date, string $end_date, bool $count_record = false): float
    {
        $query = $this->model->whereBetween('mProcessDate', [$start_date, $end_date])
            ->where('miType', [\App\Models\MoneyInfo::TYPE_UD])
            ->where('miStatus', \App\Models\MoneyInfo::STATUS_NINE)
            ->limit($limit);

        if ($count_record) return $query->count();

        return $query->sum("{$this->tableName}.miBankMoney");
    }

    /**
     * Abstract Function's serve for initialize model transmission
     *
     * @return string path model
     */
    protected function getModel(): string
    {
        return \App\Models\MoneyInfo::class;
    }
}
