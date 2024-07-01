<?php

namespace App\Repositories;

use App\Models\BonusConfig;
use App\Models\Member;
use App\Models\MoneyInfo;
use App\Models\PointHistory;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class SettlementRepository extends BaseRepository
{
    public function __construct($params = [])
    {
        parent::__construct($params);
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\Member::class;
    }

    public function getData(?Member $partner = null): array
    {
        $members = $partner ? $partner->children : $this->model->whereNull('mMemberID')->where('mIsPartner', true)->get();
        $data = [];
        foreach ($members as $member) {
            $data[] = $this->getDataDetail($member);
        }

        if ($partner) {
            return [
                'partner' => $this->getDataDetail($partner),
                'children' => $data,
            ];
        }

        return $data;
    }

    private function getDataDetail(Member $member): array
    {
        $all_child_member_id = $member->getAllChildrenMemberID();
        
        $money_infos = $this->filterData($member->money_infos()->where('miStatus', MoneyInfo::STATUS_NINE)->getQuery(), 'mProcessDate');
        $point_histories = $this->filterData($member->point_histories()->getQuery(), 'phRegDate');
        $transactions = $this->filterData($member->transactions()->getQuery(), 'tRegDate');

        $child_member = $this->model->whereIn('mID', [...$all_child_member_id, $member->mID]);
        $child_money_infos = $this->filterData(MoneyInfo::where('miStatus', MoneyInfo::STATUS_NINE)->whereIn('mID', [...$all_child_member_id, $member->mID])->getQuery(), 'mProcessDate');
        $child_point_histories = $this->filterData(PointHistory::whereIn('mID', [...$all_child_member_id, $member->mID])->getQuery(), 'phRegDate');
        $child_transactions = $this->filterData(Transaction::whereIn('mID', [...$all_child_member_id, $member->mID])->getQuery(), 'tRegDate');

        // Get sum parent
        $sum_money = $member->mMoney + $member->mSportsMoney;
        $sum_point = $member->mPoint;
        $sum_recharge = $money_infos->clone()->where('miType', MoneyInfo::TYPE_UD)->sum('miBankMoney');
        $sum_withdraw = $money_infos->clone()->where('miType', MoneyInfo::TYPE_UW)->sum('miBankMoney');
        $sum_bet_slot = $transactions->clone()->where('gCategory', 'Slot')->where('tType', 'Bet')->sum('tAmount');
        $sum_bet_casino = $transactions->clone()->where('gCategory', 'Live Casino')->where('tType', 'Bet')->sum('tAmount');
        $sum_win_slot = $transactions->clone()->where('gCategory', 'Slot')->where('tType', 'Win')->sum('tAmount');
        $sum_win_casino = $transactions->clone()->where('gCategory', 'Live Casino')->where('tType', 'Win')->sum('tAmount');
        $sum_valid_bet_slot = $transactions->clone()->where('gCategory', 'Slot')->where('tType', 'Bet')->whereExists(function ($queryExists) {
            $queryExists->selectRaw(1)->from('transaction as t2')->whereColumn('transaction.tRoundId', 't2.tRoundId')->where('t2.tType', 'Win')->whereColumn('transaction.tAmount', '<>', 't2.tAmount');
        })->sum('tAmount');
        $sum_valid_bet_casino = $transactions->clone()->where('gCategory', 'Live Casino')->where('tType', 'Bet')->whereExists(function ($queryExists) {
            $queryExists->selectRaw(1)->from('transaction as t2')->whereColumn('transaction.tRoundId', 't2.tRoundId')->where('t2.tType', 'Win')->whereColumn('transaction.tAmount', '<>', 't2.tAmount');
        })->sum('tAmount');
        $sum_rolling_slot = $point_histories->clone()->where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)->where('phGameType', 'Slot')->sum('phPoint');
        $sum_rolling_casino = $point_histories->clone()->where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)->where('phGameType', 'Live Casino')->sum('phPoint');
        $sum_profit_bet_win_slot = $sum_bet_slot - $sum_win_slot - $sum_rolling_slot;
        $sum_profit_bet_win_casino = $sum_bet_casino - $sum_win_casino - $sum_rolling_casino;
        $sum_loss_slot = $sum_profit_bet_win_slot < 0 ? $sum_profit_bet_win_slot * data_get($member->memberConfig, 'mcLossSlotRate', 0) / 100 : 0;
        $sum_loss_casino = $sum_profit_bet_win_casino < 0 ? $sum_profit_bet_win_casino * data_get($member->memberConfig, 'mcLossCasinoRate', 0) / 100 : 0;
        $sum_deduct = $transactions->clone()->where('tType', 'Deduct')->sum('tAmount');

        // Get sum total child
        $sum_child_money = $child_member->sum('mMoney') + $child_member->sum('mSportsMoney');
        $sum_child_point = $child_member->sum('mPoint');
        $sum_child_recharge = $child_money_infos->clone()->where('miType', MoneyInfo::TYPE_UD)->sum('miBankMoney');
        $sum_child_withdraw = $child_money_infos->clone()->where('miType', MoneyInfo::TYPE_UW)->sum('miBankMoney');
        $sum_child_bet_slot = $child_transactions->clone()->where('gCategory', 'Slot')->where('tType', 'Bet')->sum('tAmount');
        $sum_child_bet_casino = $child_transactions->clone()->where('gCategory', 'Live Casino')->where('tType', 'Bet')->sum('tAmount');
        $sum_child_win_slot = $child_transactions->clone()->where('gCategory', 'Slot')->where('tType', 'Win')->sum('tAmount');
        $sum_child_win_casino = $child_transactions->clone()->where('gCategory', 'Live Casino')->where('tType', 'Win')->sum('tAmount');
        $sum_child_valid_bet_slot = $child_transactions->clone()->where('gCategory', 'Slot')->where('tType', 'Bet')->whereExists(function ($queryExists) {
            $queryExists->selectRaw(1)->from('transaction as t2')->whereColumn('transaction.tRoundId', 't2.tRoundId')->where('t2.tType', 'Win')->whereColumn('transaction.tAmount', '<>', 't2.tAmount');
        })->sum('tAmount');
        $sum_child_valid_bet_casino = $child_transactions->clone()->where('gCategory', 'Live Casino')->where('tType', 'Bet')->whereExists(function ($queryExists) {
            $queryExists->selectRaw(1)->from('transaction as t2')->whereColumn('transaction.tRoundId', 't2.tRoundId')->where('t2.tType', 'Win')->whereColumn('transaction.tAmount', '<>', 't2.tAmount');
        })->sum('tAmount');
        $sum_child_rolling_slot = $child_point_histories->clone()->where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)->where('phGameType', 'Slot')->sum('phPoint');
        $sum_child_rolling_casino = $child_point_histories->clone()->where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)->where('phGameType', 'Live Casino')->sum('phPoint');
        $sum_child_profit_bet_win_slot = $sum_child_bet_slot - $sum_child_win_slot - $sum_child_rolling_slot;
        $sum_child_profit_bet_win_casino = $sum_child_bet_casino - $sum_child_win_casino - $sum_child_rolling_casino;
        $sum_child_loss_slot = $sum_child_profit_bet_win_slot < 0 ? $sum_child_profit_bet_win_slot * data_get($member->memberConfig, 'mcLossSlotRate', 0) / 100 : 0;
        $sum_child_loss_casino = $sum_child_profit_bet_win_casino < 0 ? $sum_child_profit_bet_win_casino * data_get($member->memberConfig, 'mcLossCasinoRate', 0) / 100 : 0;
        $sum_child_deduct = $child_transactions->clone()->where('tType', 'Deduct')->sum('tAmount');

        return [
            'member' => $member,
            'count_children' => count($all_child_member_id),
            'parent' => [
                'sum_money' => $sum_money,
                'sum_point' => $sum_point,
                'sum_recharge' => $sum_recharge,
                'sum_withdraw' => $sum_withdraw,
                'sum_profit_recharge_withdraw' => $sum_recharge + $sum_withdraw,
                'sum_bet' => $sum_bet_slot + $sum_bet_casino,
                'sum_win' => $sum_win_slot + $sum_win_casino,
                'sum_valid_bet' => $sum_valid_bet_slot + $sum_valid_bet_casino,
                'sum_rolling' => $sum_rolling_slot + $sum_rolling_casino,
                'sum_profit_bet_win_rolling' => $sum_profit_bet_win_slot + $sum_profit_bet_win_casino,
                'sum_loss' => $sum_loss_slot + $sum_loss_casino,
                'sum_bet_slot' => $sum_bet_slot,
                'sum_win_slot' => $sum_win_slot,
                'sum_valid_bet_slot' => $sum_valid_bet_slot,
                'sum_rolling_slot' => $sum_rolling_slot,
                'sum_profit_bet_win_rolling_slot' => $sum_bet_slot - $sum_win_slot - $sum_rolling_slot,
                'sum_loss_slot' => $sum_loss_slot,
                'sum_bet_casino' => $sum_bet_casino,
                'sum_win_casino' => $sum_win_casino,
                'sum_valid_bet_casino' => $sum_valid_bet_casino,
                'sum_rolling_casino' => $sum_rolling_casino,
                'sum_profit_bet_win_rolling_casino' => $sum_bet_casino - $sum_win_casino - $sum_rolling_casino,
                'sum_loss_casino' => $sum_loss_casino,
                'sum_deduct' => $sum_deduct,
            ],
            'child' => [
                'sum_money' => $sum_child_money,
                'sum_point' => $sum_child_point,
                'sum_recharge' => $sum_child_recharge,
                'sum_withdraw' => $sum_child_withdraw,
                'sum_profit_recharge_withdraw' => $sum_child_recharge + $sum_child_withdraw,
                'sum_bet' => $sum_child_bet_slot + $sum_child_bet_casino,
                'sum_win' => $sum_child_win_slot + $sum_child_win_casino,
                'sum_valid_bet' => $sum_child_valid_bet_slot + $sum_child_valid_bet_casino,
                'sum_rolling' => $sum_child_rolling_slot + $sum_child_rolling_casino,
                'sum_profit_bet_win_rolling' => $sum_child_profit_bet_win_slot + $sum_child_profit_bet_win_casino,
                'sum_loss' => $sum_child_loss_slot + $sum_child_loss_casino,
                'sum_bet_slot' => $sum_child_bet_slot,
                'sum_win_slot' => $sum_child_win_slot,
                'sum_valid_bet_slot' => $sum_child_valid_bet_slot,
                'sum_rolling_slot' => $sum_child_rolling_slot,
                'sum_profit_bet_win_rolling_slot' => $sum_child_bet_slot - $sum_child_win_slot - $sum_child_rolling_slot,
                'sum_loss_slot' => $sum_child_loss_slot,
                'sum_bet_casino' => $sum_child_bet_casino,
                'sum_win_casino' => $sum_child_win_casino,
                'sum_valid_bet_casino' => $sum_child_valid_bet_casino,
                'sum_rolling_casino' => $sum_child_rolling_casino,
                'sum_profit_bet_win_rolling_casino' => $sum_child_bet_casino - $sum_child_win_casino - $sum_child_rolling_casino,
                'sum_loss_casino' => $sum_child_loss_casino,
                'sum_deduct' => $sum_child_deduct,
            ],
        ];
    }

    private function filterData(EloquentBuilder|QueryBuilder $query, string $fieldName): EloquentBuilder|QueryBuilder
    {
        $start_date = request('start_date', today());
        $end_date = request('end_date', today());

        return $query
            ->when($start_date, function ($query) use ($fieldName, $start_date) {
                $query->whereDate($fieldName, '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($fieldName, $end_date) {
                $query->whereDate($fieldName, '<=', $end_date);
            });
    }

    public function getDataWeb($search = []): array
    {
        $date = null;

        $fromDate = $search['start_date'] ?? Carbon::today()->subWeek()->startOfDay();
        $toDate = $search['end_date'] ?? Carbon::today()->endOfDay();

        $dates = CarbonPeriod::create($fromDate, $toDate)->toArray();
        $data = [];

        foreach ($dates as $date) {
            $date = $date->format('Y-m-d');
            $dataRow = (array) DB::query()
                ->selectSub(function ($query) use ($date) {
                    $query->from('money_info')
                        ->selectRaw('COALESCE(SUM(miBankMoney), 0) as sumDepositMoney')
                        ->where('miType', 'UD')
                        ->when($date, function ($query) use ($date) {
                            $query->whereDate('mProcessDate', $date);
                        })
                        ->where('miStatus', 9);
                }, 'sumDepositMoney')
                ->selectSub(function ($query) use ($date) {
                    $query->from('money_info')
                        ->selectRaw('COALESCE(ABS(SUM(miBankMoney)), 0) as sumWithdrawMoney')
                        ->where('miType', 'UW')
                        ->when($date, function ($query) use ($date) {
                            $query->whereDate('mProcessDate', $date);
                        })
                        ->where('miStatus', 9);
                }, 'sumWithdrawMoney')
                ->selectSub(function ($query) use ($date) {
                    $query->from('money_info')
                        ->selectRaw('COALESCE(CAST((SUM(case when miType = "UD" and miStatus = 9 then miBankMoney else 0 end) - ABS(SUM(case when miType = "UW" and miStatus = 9 then miBankMoney else 0 end))) AS DECIMAL(10,2)), 0) as profit')
                        ->when($date, function ($query) use ($date) {
                            $query->whereDate('mProcessDate', $date);
                        });
                }, 'profit')
                ->selectSub(function ($query) use ($date) {
                    $query->from('transaction')
                        ->selectRaw('COALESCE(SUM(tAmount), 0) as sumTransBet')
                        ->where('tType', 'Bet')
                        ->when($date, function ($query) use ($date) {
                            $query->whereDate('tRegDate', $date);
                        });
                }, 'sumTransBet')
                ->selectSub(function ($query) use ($date) {
                    $query->from('transaction')
                        ->selectRaw('COALESCE(SUM(tAmount), 0) as sumTransBetWin')
                        ->where('tType', 'Win')
                        ->when($date, function ($query) use ($date) {
                            $query->whereDate('tRegDate', $date);
                        });
                }, 'sumTransBetWin')
                ->selectSub(function ($query) use ($date) {
                    $query->from('transaction')
                        ->selectRaw('SUM(case when tType = "Win" then tAmount else 0 end) - SUM(case when tType = "Bet" then tAmount else 0 end) as winningRate')
                        ->when($date, function ($query) use ($date) {
                            $query->whereDate('tRegDate', $date);
                        });
                }, 'winningRate')
                ->first();

            $dataRow['date'] = $date;
            $data[] = $dataRow;
        }

        return $data;
    }

    public function getDataUser($search = []): Paginator
    {
        $fieldSort = 'mRegDate';
        $sort = 'desc';
        $date = null;

        if (isset($search['date_search'])) {
            $date = $search['date_search'];
        }

        $qr = $this->model
            ->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->select('*')
            ->selectSub(function ($query) use ($date) {
                $query->from('money_info')
                    ->selectRaw('COALESCE(SUM(miBankMoney), 0) as sumDepositMoney')
                    ->where('miType', 'UD')
                    ->when($date, function ($query) use ($date) {
                        $query->whereDate('mProcessDate', $date);
                    })
                    ->where('miStatus', 9)
                    ->whereColumn('mID', 'member.mID');
            }, 'sumDepositMoney')
            ->selectSub(function ($query) use ($date) {
                $query->from('money_info')
                    ->selectRaw('COALESCE(ABS(SUM(miBankMoney)), 0) as sumWithdrawMoney')
                    ->where('miType', 'UW')
                    ->when($date, function ($query) use ($date) {
                        $query->whereDate('mProcessDate', $date);
                    })
                    ->where('miStatus', 9)
                    ->whereColumn('mID', 'member.mID');
            }, 'sumWithdrawMoney')
            ->selectSub(function ($query) use ($date) {
                $query->from('money_info')
                    ->selectRaw('COALESCE(CAST((SUM(case when miType = "UD" and miStatus = 9 then miBankMoney else 0 end) - ABS(SUM(case when miType = "UW" and miStatus = 9 then miBankMoney else 0 end))) AS DECIMAL(10,2)), 0) as profit')
                    ->when($date, function ($query) use ($date) {
                        $query->whereDate('mProcessDate', $date);
                    })
                    ->whereColumn('mID', 'member.mID');
            }, 'profit')
            ->selectSub(function ($query) use ($date) {
                $query->from('transaction')
                    ->selectRaw('COALESCE(SUM(tAmount), 0) as sumTransBet')
                    ->where('tType', 'Bet')
                    ->when($date, function ($query) use ($date) {
                        $query->whereDate('tRegDate', $date);
                    })
                    ->whereColumn('mID', 'member.mID');
            }, 'sumTransBet')
            ->selectSub(function ($query) use ($date) {
                $query->from('transaction')
                    ->selectRaw('COALESCE(SUM(tAmount), 0) as sumTransBetWin')
                    ->where('tType', 'Win')
                    ->when($date, function ($query) use ($date) {
                        $query->whereDate('tRegDate', $date);
                    })
                    ->whereColumn('mID', 'member.mID');
            }, 'sumTransBetWin')
            ->selectSub(function ($query) use ($date) {
                $query->from('transaction')
                    ->selectRaw('CASE WHEN SUM(case when tType = "Bet" then tAmount else 0 end) > 0 THEN ROUND(((SUM(case when tType = "Bet" then tAmount else 0 end) - SUM(case when tType = "Win" then tAmount else 0 end)) / SUM(case when tType = "Bet" then tAmount else 0 end)) * 100, 2) ELSE 0 END as winningRate')
                    ->when($date, function ($query) use ($date) {
                        $query->whereDate('tRegDate', $date);
                    })
                    ->whereColumn('mID', 'member.mID');
            }, 'winningRate');


        if (data_get($search, 'mID')) {
            $qr->where('mID', 'like', "%" . data_get($search, 'mID') . "%");
        }

        if (data_get($search, 'orderBy') && data_get($search, 'sort')) {
            $fieldSort = data_get($search, 'orderBy');
            $sort = data_get($search, 'sort');
        }

        $qr->orderBy($fieldSort, $sort);

        $per_page = data_get($search, 'per_page', \App\Services\BaseService::COUNT_PER_PAGE);

        return $qr->paginate($per_page);
    }
}
