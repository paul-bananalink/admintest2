<?php

namespace App\Repositories;

use DateTime;

class ConsultationRepository extends BaseRepository
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
        return \App\Models\Consultation::class;
    }

    public function getTotal()
    {
        return $this->model->count();
    }
    public function GetUnansweredCount()
    {
        return $this->model->where('status', \App\Models\Consultation::STATUS_RECEIVED)->count();
    }
    public function checkRequireReply(int $mNo)
    {
        return $this->model->where('mNo', $mNo)->where('status', \App\Models\Consultation::STATUS_RECEIVED)->where('show_ui', 1)->exists();
    }

    public function getLatest(int $mNo)
    {
        return $this->model->where('mNo', $mNo)->where('show_ui', 1)->latest()->first();
    }

    public function getAll()
    {
        $per_page = request('per_page', \App\Services\BaseService::COUNT_PER_PAGE);

        $query = $this->model->with(['member'])->join('member', 'consultations.mNo', '=', 'member.mNo');

        if (request()->input('type')) {
            $query->where('consultations.status', request()->input('type'));
        }

        if (request()->get('start_date') && request()->input('end_date')) {
            $query->whereBetween('consultations.created_at', [request()->input('start_date'), request()->input('end_date')]);
        }

        if ($search_input = request()->input('search_input')) {
            $query->where(function ($query) use ($search_input) {
                $query->where('consultations.content', 'like', '%' . $search_input . '%')
                    ->orWhere('member.mID', 'like', '%' . $search_input . '%');
            });
        }

        if ($mLevel = request()->input('mLevel')) {
            $query->where('member.mLevel', $mLevel);
        }

        $res = $query->orderBy('consultations.created_at', 'desc')
            ->paginate($per_page);

        return $res;
    }

    public function totalItemByStatus(int $status): int
    {
        return $this->model->where('status', $status)->count();
    }

    public function deleteByListId(array $ids)
    {
        return $this->deleteMultiple($ids);
    }

    public function clearData()
    {
        return $this->model->truncate();
    }
}
