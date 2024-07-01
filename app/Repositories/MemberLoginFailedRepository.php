<?php

namespace App\Repositories;

use Carbon\Carbon;

class MemberLoginFailedRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */

    public function getModel(): string
    {
        return \App\Models\MemberLoginFailed::class;
    }

    public function createMemberLoginFailed(array $attributes = [])
    {
        $m_id = $attributes['m_id'] ?? null;

        $loginFailed = new \App\Models\MemberLoginFailed([
            'mID' => $m_id,
            'mlfOS' => request()->header('User-Agent'),
            'mlfIP' => request()->ip(),
            'mlfRegDate' => now(),
            'mlfReason' => '잘못된 비밀번호 입력.' //Password incorrect
        ]);

        $loginFailed->save();
    }

    public function blockMemberList(array $attributes = [])
    {
        $ipMemBlock = request()->ip();

        $siteInfo = app('site_info');
        if ($siteInfo) {
            $existingIPs = $siteInfo->siAutomationBlockIP;
            if (!empty($existingIPs)) {
                $ipList = explode("\n", $existingIPs);
            } else {
                $ipList = [];
            }

            if (!in_array($ipMemBlock, $ipList)) {
                $ipList[] = $ipMemBlock;
            }

            $siteInfo->siAutomationBlockIP = implode("\n", $ipList);
            $siteInfo->save();
        }
    }
    public function searchMemberLoginFailed($searchInput = null, $startDate = null, $endDate = null)
    {
        $modal = $this->model::query();

        if ($searchInput) {
            $modal->where(function ($q) use ($searchInput) {
                $q->where('mID', 'like', '%' . $searchInput . '%')
                    ->orWhere('mlfIP', 'like', '%' . $searchInput . '%');
            });
        }

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate)->endOfDay();

            if ($startDate->isSameDay($endDate)) {
                $modal->whereDate('mlfRegDate', $startDate);
            } else {
                $modal->whereBetween('mlfRegDate', [$startDate, $endDate]);
            }
        }
        $modal->orderBy('mlfRegDate', 'desc');

        return $modal->paginate(request('per_page', 30));
    }
}
