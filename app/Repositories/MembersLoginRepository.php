<?php

namespace App\Repositories;

class MembersLoginRepository extends BaseRepository
{
    private MemberRepository $memRepo;

    /**
     * Create a new class instance.
     */
    public function __construct(?array $params = [])
    {
        parent::__construct($params);
        $this->memRepo = new MemberRepository();
    }

    /**
     * Get member ip infect by query search
     *
     * @param array $ips ip infect
     * @param string $key keyword search
     * @param string $column column convert to field in db
     * @return mixed
     */
    public function getMemberIpInfectQuerySearch(
        array $ips = [],
        string $key = '',
        string $column = '',
        int $per_page = 30
    ) {
        if (empty($ips)) {
            return [];
        }
        return $this->model->whereIn('mlIpv4', $ips)
            ->leftJoin('member', "{$this->tableName}.mNo", '=', 'member.mNo')
            ->where(function ($q) use ($key, $column) {
                if ($column == config('constant_view.VIEW.SELECT_ALL_FIELD')) {
                    return $q->where('member.mID', 'like', "%{$key}%")
                        ->orWhere('mlIpv4', 'like', "%{$key}%")
                        ->orWhere('mlBrowserSystem', 'like', "%{$key}%")
                        ->orWhere(function ($q2) use ($key) {
                            return $q2->whereDate('updated_at', $key)->orWhere(function ($q3) use ($key) {
                                return $q3->whereTime('updated_at', $key);
                            });
                        });
                }
                if ($column != 'updated_at') {
                    return $q->where($column, 'like', "%{$key}%");
                }
                return $q->whereDate('updated_at', $key)->orWhere(function ($q3) use ($key) {
                    return $q3->whereTime('updated_at', $key);
                });
            })->orderBy(
                'mlNo',
                config('constant_view.QUERY_DATABASE.DESC')
            )->paginate($per_page);
    }

    /**
     * Get member logined by query search
     *
     * @param string $key keyword search
     * @param string $column column convert to field in db
     * @return mixed
     */
    public function getMemberAccessQuerySearch(string $key = '', string $column = '', int $per_page = 30)
    {
        return $this->model->leftJoin('member', "{$this->tableName}.mNo", '=', 'member.mNo')
            ->where(function ($q) use ($key, $column) {
                if ($column == config('constant_view.VIEW.SELECT_ALL_FIELD')) {
                    return $q->where('member.mID', 'like', "%{$key}%")
                        ->orWhere('mlIpv4', 'like', "%{$key}%")
                        ->orWhere('mlBrowserSystem', 'like', "%{$key}%")
                        ->orWhere(function ($q2) use ($key) {
                            return $q2->whereDate('updated_at', $key)->orWhere(function ($q3) use ($key) {
                                return $q3->whereTime('updated_at', $key);
                            });
                        });
                }
                if ($column != 'updated_at') {
                    return $q->where($column, 'like', "%{$key}%");
                }
                return $q->whereDate('updated_at', $key)->orWhere(function ($q3) use ($key) {
                    return $q3->whereTime('updated_at', $key);
                });
            })->orderBy(
                'mlNo',
                config('constant_view.QUERY_DATABASE.DESC')
            )->paginate($per_page);
    }

    public function getCountMemberAccess(array $conditions = []): int
    {
        if (empty($conditions)) {
            return $this->model->count();
        }

        return $this->model->whereBetween(...$conditions)->count();
    }

    /**
     * Get all member login
     */
    public function getMemberAccessAll()
    {
        return $this->model->all();
    }

    /**
     * @return Illuminate\Support\Collection|array
     */
    public function getIpInfect($conditions)
    {
        return $this->model
            ->select('mlIpv4')
            ->whereBetween(...$conditions)
            ->groupBy('mlIpv4')
            ->havingRaw('COUNT(mlIpv4) > 1')
            ->get() // Exec Query here
            ->pluck('mlIpv4');
    }

    /**
     * @return Illuminate\Support\Collection|array
     */
    public function getMemberIpInfect($listIp = [], int $per_page = 30)
    {
        return $this->model
            ->whereIn('mlIpv4', $listIp)
            ->orderBy($this->model->getKeyName(), config('constant_view.QUERY_DATABASE.DESC'))
            ->paginate($per_page);
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator|array
     */
    public function getMembersLoginBymID(string $m_id = '', int $per_page = 30)
    {
        if (empty($m_id)) {
            return [];
        }
        if ($member = $this->memRepo->getMemberByMID($m_id)) {
            return $member->members_login()->paginate($per_page);
        }

        return [];
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator|array
     */
    public function getMembersLoginByIP(string $ipv4 = '', int $per_page = 30)
    {
        if (empty($ipv4)) {
            return [];
        }

        return $this->model->where('mlIpv4', $ipv4)->paginate($per_page);
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator|array
     */
    public function getMembersLoginByBrowerSystem(string $brower_sytem = '', int $per_page = 30)
    {
        if (empty($brower_sytem)) {
            return [];
        }

        return $this->model->where('mlBrowserSystem', 'like', "%{$brower_sytem}%")->paginate($per_page);
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator|array
     */
    public function getMembersLoginByLoginAt(string $date_time = '', int $per_page = 30)
    {
        if (empty($date_time)) {
            return [];
        }

        return $this->model->where('updated_at', '>=', $date_time)->paginate($per_page);
    }

    protected function getModel(): string
    {
        return \App\Models\MembersLogin::class;
    }
}
