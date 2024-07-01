<?php

namespace App\Repositories;

use App\Models\BonusConfig;
use App\Models\MoneyInfo;
use App\Models\MemberConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class MemberRepository extends BaseRepository
{
    public function __construct(?array $params = [])
    {
        parent::__construct($params);
    }

    /**
     * Get count member suspended by date
     *
     * @param mixed $date Y-m-d H:m:s
     * @param bool $is_day
     * @return int
     */
    public function getCountMemberSuspendedByDate($date, bool $is_day = true): int
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));

        $query = $this->model->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->where('mStatus', \App\Models\Member::M_STATUS_EIGHT)
            ->whereYear('mModifyDateTime', $year)
            ->whereMonth('mModifyDateTime', $month);
        if ($is_day) {
            $query->whereDay('mModifyDateTime', $day);
        }
        return $query->count();
    }

    /**
     * Get count member register approved today
     */
    public function getCountMemberRegisterApprovedToday(): int
    {
        return $this->model->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->whereDate('mModifyDateTime', now()->today())
            ->where('mStatus', $this->model::M_STATUS_NINE)
            ->whereNull('mLoginDateTime')
            ->count();
    }

    /**
     * Get count member register by date
     *
     * @param mixed $date Y-m-d H:m:s
     * @param bool $is_day
     * @return int
     */
    public function getCountMemberRegisterByDate($date, bool $is_day = true): int
    {
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));

        $query = $this->model->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->whereYear('mRegDate', $year)
            ->whereMonth('mRegDate', $month);
        if ($is_day) {
            $query->whereDay('mRegDate', $day);
        }

        return $query->count();
    }

    /**
     * Check exist member ID
     */
    public function isExistMemberID(string $m_id = ''): bool
    {
        if (empty($m_id)) {
            return false;
        }

        return $this->model->where('mID', $m_id)
            ->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->exists();
    }

    public function isUniqueMemberID(string $m_id = ''): bool
    {
        if (empty($m_id)) {
            return false;
        }

        return $this->model->where('mMemberId', $m_id)->whereNotIn('mLevel',  \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->exists();
    }

    public function isPartnerCode(string $m_id = ''): bool
    {
        if (empty($m_id)) {
            return false;
        }

        return $this->model->where('mPartnerCode', $m_id)->whereNotIn('mLevel',  \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->exists();
    }

    public function isMemberNick(string $m_nick = ''): bool
    {
        if (empty($m_nick)) {
            return false;
        }

        return $this->model->where('mNick', $m_nick)
            ->exists();
    }

    /**
     * Get List Admin only role AD
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getListAdmin()
    {
        return $this->model->where('mLevel', $this->model::M_LEVEL_ADMIN_AD)
            ->get()
            ->sortDesc();
    }

    /**
     * @return Modal
     */
    public function getMemberByMID(string $m_id = '')
    {
        return $this->model->where('mID', $m_id)->first();
    }

    public function getListMemberStatusAccessNew(array $conditions = [], array $order_sort = [], int $per_page = 30, array $partner_children = null): LengthAwarePaginator
    {
        @[
            'logged_from' => $logged_from,
            'profit_member' => $profit_member,
            'm_status' => $m_status,
            'filter' => $filter,
            'cash_casino' => $cash_casino,
            'mc_bool' => $mc_bool,
            'mc_suspicion' => $mc_suspicion,
            'member_online' => $member_online,
        ] = $conditions;

        @[
            'profit_member_count' => $profit_member_count,
            'profit_member_sort' => $profit_member_sort,
        ] = $profit_member;

        @[
            'start_date' => $filter_start_date,
            'end_date' => $filter_end_date,
            'column' => $filter_column,
            'search' => $filter_keyword,
        ] = $filter;

        @[
            'order_by' => $order_by,
            'sort' => $sort
        ] = $order_sort;

        return $this->model->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->when($logged_from, function (Builder $query) use ($logged_from) {
                // Filter member by logged in day
                $query->whereDate('mLoginDateTime', '<=', $logged_from);
            })
            ->when($cash_casino, function (Builder $query) {
                $query->where('mMoney', '>', 0);
            })
            ->when($profit_member, function (Builder $query) use ($profit_member_count, $profit_member_sort) {
                // Filter member profit by top or bottom
                $query->selectRaw("member.*, COALESCE(SUM(CASE WHEN money_info.miType = 'UD' THEN money_info.miBankMoney WHEN money_info.miType = 'AD' THEN money_info.miBankMoney ELSE 0 END), 0) - ABS(COALESCE(SUM(CASE WHEN money_info.miType = 'UW' THEN money_info.miBankMoney WHEN money_info.miType = 'AW' THEN money_info.miBankMoney ELSE 0 END), 0)) AS profit")
                    ->leftJoin(
                        'money_info',
                        'money_info.mID',
                        '=',
                        'member.mID'
                    )->orderBy(
                        'profit',
                        $profit_member_sort,
                    )->groupBy('member.mID')->take($profit_member_count);
            })
            ->when($m_status, function (Builder $query) use ($m_status) {
                // Filter member by status
                $query->whereIn('mStatus', $m_status);
            })
            ->when($member_online, function (Builder $query) use ($member_online) {
                // Filter member by status
                $query->whereIn('mID', $member_online);
            })
            ->when($filter, function (Builder $query) use ($filter_start_date, $filter_end_date, $filter_column, $filter_keyword) {
                // Filter member by keyword or by regdate from to
                $query->when($filter_start_date, function (Builder $query) use ($filter_start_date) {
                    $query->whereDate('mRegDate', '>=', $filter_start_date);
                })->when($filter_end_date, function (Builder $query) use ($filter_end_date) {
                    $query->whereDate('mRegDate', '<=', $filter_end_date);
                })->when($filter_keyword, function (Builder $query) use ($filter_column, $filter_keyword) {
                    $query->when($filter_column, function (Builder $query) use ($filter_column, $filter_keyword) {
                        if (request('type_s') === 'equal') {
                            $query->where($filter_column, $filter_keyword);
                        } else $query->where($filter_column, 'like', "%{$filter_keyword}%");
                    }, function (Builder $query) use ($filter_keyword) {
                        $query->whereAny(['mMemberID', 'mID', 'mNick', 'mBankNumber', 'mBankOwner', 'mBankName', 'mNote', 'mLevel', 'mLoginIP', 'mPhone'], 'like', "%{$filter_keyword}%");
                    });
                });
            })->when(!is_null($partner_children), function ($query) use ($partner_children) {
                $query->whereIn('member.mID', $partner_children);
            })->when($mc_bool, function ($query, $mc_bool) {
                $query->whereHas('memberConfig', function ($query) use ($mc_bool) {
                    return $query->where($mc_bool, 1);
                });
            })->when($mc_suspicion, function ($query) {
                $query->whereHas('memberConfig', function ($query) {
                    return $query->whereIn('mcSuspicion', config('site_config.SUSPICION_LIST'));
                });
            })
            ->orderBy($order_by ?? 'mRegDate', $sort ?? config('constant_view.QUERY_DATABASE.DESC'))
            ->paginate($per_page);
    }

    public function getSumMoneyAllMember(): int
    {
        return $this->model->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->whereNotNull('mMoney')
            ->sum("{$this->tableName}.mMoney");
    }

    public function getListMember()
    {
        return $this->model->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)->get();
    }

    public function getListMemberHashPhone()
    {
        return $this->model->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)->whereNotNull('mPhone')->whereNull('mPhoneCom')->get();
    }

    public function getListMemberHashConsultation()
    {
        return $this->model->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->where(function ($query) {
                $query->whereNotNull('mConsultBankName')->whereNull('mConsultBankNameCom');
            })->orWhere(function ($query) {
                $query->whereNotNull('mConsultBankAccount')->whereNull('mConsultBankAccountCom');
            })->get();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     *
     * @return string path model
     */
    protected function getModel(): string
    {
        return \App\Models\Member::class;
    }

    public function getOnlineMembers(): array
    {
        $onlineUsers = [];
        $onlineMemberCount = 0;

        foreach (\App\Models\Member::all() as $user) {
            if (Cache::has('member-is-online-' . $user->mID)) {
                $onlineUsers[] = $user->mID;
                $onlineMemberCount++;
            }
        }

        return [
            'onlineMembers' => $onlineUsers,
            'onlineMemberCount' => $onlineMemberCount,
        ];
    }

    public function getPartners()
    {
        return $this->model
            ->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->where('mMemberID', NULL)
            ->where('mIsPartner', 1)
            ->orderBy('mPartnerPosition', 'asc')
            ->get();
    }
    public function getListMemberConsolationPrize(int $day_count = 10): Collection
    {
        $from_date = now()->subDays($day_count);

        return $this->model
            ->whereHas('money_infos', function ($query) use ($from_date) {
                $query->where(['miStatus' => MoneyInfo::STATUS_NINE, 'miType' => MoneyInfo::TYPE_UD])
                    ->whereBetween('mProcessDate', [$from_date, now()]);
            })
            ->whereDoesntHave('point_histories', function ($query) use ($from_date) {
                $query->where(['phBonusType' => BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS])
                    ->whereBetween('phRegDate', [$from_date, now()]);
            })
            ->groupBy('member.mID')
            ->get();
    }

    public function existsPartnerChilds(string $mMemberID): bool
    {
        return $this->model->where('mMemberID', $mMemberID)->where('mIsPartner', 1)->exists();
    }

    public function getListMemberPayBackBonus(string $start_of_week, string $end_of_week): Collection
    {
        return $this->model
            ->whereHas('money_infos', function ($query) use ($start_of_week, $end_of_week) {
                $query->where(['miStatus' => MoneyInfo::STATUS_NINE])
                    ->whereIn('miType', [MoneyInfo::TYPE_UD, MoneyInfo::TYPE_UW])
                    ->whereBetween('mProcessDate', [$start_of_week, $end_of_week]);
            })
            ->get();
    }

    public function partner($mID)
    {
        return $this->model->where('mID', $mID)->where('mIsPartner', 1)->first();
    }

    public function getRate($member, $field): ?float
    {
        if (!$member || !$field || !isset(MemberConfig::ROLLING_RATE[$field])) {
            return null;
        }

        if (!$member) {
            return null;
        }

        $memberConfig = $member->memberConfig;

        if (!$memberConfig) {
            return null;
        }

        $field = MemberConfig::ROLLING_RATE[$field];

        return (float)$memberConfig->{$field};
    }

    public function getPublicBetting($member, $field): ?float
    {
        if (!$member || !$field || !isset(MemberConfig::PUBLIC_BETTING[$field])) {
            return null;
        }

        if (!$member) {
            return null;
        }

        $memberConfig = $member->memberConfig;

        if (!$memberConfig) {
            return null;
        }

        $field = MemberConfig::PUBLIC_BETTING[$field];

        return (float)$memberConfig->{$field};
    }
}
