<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

class MemberAttendanceRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\MemberAttendance::class;
    }

    public function isAttended($mID): bool
    {
        $conditions = [
            'whereDate' => [
                ['maRegDate', date('Y-m-d')]
            ],
            'where' => [
                ['mID', $mID]
            ]
        ];

        return $this->exists($conditions);
    }

    public function attendanceInMonth($mID, $month): Collection
    {
        $conditions = [
            'where' => [
                ['mID', $mID],
                ['maRegDate', '>=', $month->copy()->startOfMonth()],
                ['maRegDate', '<=', $month->copy()->endOfMonth()]
            ]
        ];

        return $this->getListWithConditions($conditions);
    }
}
