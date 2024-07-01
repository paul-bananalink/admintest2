<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\Partner;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class PartnerRepository extends BaseRepository
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
        return \App\Models\Partner::class;
    }

    public function isExistsMemberIDByType(string $mID, string $pType): bool
    {
        if ($pType == 'distributor') {
            $type = 'deputy_headquarters';
        } else {
            $type = 'distributor';
        }

        return $this->model->where('mID', $mID)->where('pType', $type)->exists();
    }

    public function isUniqueMIDUpdate($mID, $pNo): bool
    {
        return $this->model->where('mID', $mID)->where('pNo', '!=', $pNo)->exists();
    }

    public function getDeputyHeadquarters(): Collection
    {
        $query = $this->model
            ->join('member', 'partners.mID', '=', 'member.mID')
            ->where('pType', 'deputy_headquarters');

        $params['start_date'] = request('start_date');
        $params['end_date'] = request('end_date');

        if (request('start_date') && request('end_date')) {

            $start = Carbon::parse(data_get($params, 'start_date'))->startOfDay();
            $end = Carbon::parse(data_get($params, 'end_date'))->endOfDay();

            $query->whereBetween('partners.pRegDate', [$start, $end]);
        }

        if ($input_search = request()->input('input_search')) {
            $query = $query->where(function ($query) use ($input_search) {
                $query->where('partners.mID', 'like', '%' . $input_search . '%')
                    ->orWhere('member.mNick', 'like', '%' . $input_search . '%');
            });
        }

        return $query->orderBy('partners.pRegDate', 'desc')->get();
    }

    public function getCurrentPartner(Member $member, ?string $pType): ?Partner
    {
        $query = $this->model->where('mID', $member->mID);

        if ($pType) {
            $query->where('pType', $pType);
        }

        if ($date_search = request()->input('date_search')) {
            $dateParts = explode(' - ', $date_search);

            if (count($dateParts) == 2) {
                $start_date = DateTime::createFromFormat('Y/m/d', $dateParts[0])->format('Y-m-d 00:00:00');
                $end_date = DateTime::createFromFormat('Y/m/d', $dateParts[1])->format('Y-m-d 23:59:59');

                $query->whereBetween('partners.pRegDate', [$start_date, $end_date]);
            }
        }

        if ($input_search = request()->input('input_search')) {
            $query = $query->where(function ($query) use ($input_search) {
                $query->where('partners.mID', 'like', '%' . $input_search . '%')
                    ->orWhere('member.mNick', 'like', '%' . $input_search . '%');
            });
        }

        return $query->first();
    }

    public function getPartnersByListType(array $type)
    {
        return $this->model->whereIn('pType', $type)->get();
    }

    public function isUniqueMemberID(string $m_id = ''): bool
    {
        if (empty($m_id)) {
            return false;
        }

        return $this->model->where('mID', $m_id)
            ->exists();
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
            ->exists();
    }

    public function getPartnerByType($type)
    {
        if ($type == 'all') {
            return $this->model->get();
        }
        return $this->model->where('pType', $type)->get();
    }
}
