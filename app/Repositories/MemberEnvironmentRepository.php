<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

class MemberEnvironmentRepository extends BaseRepository
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
        return \App\Models\MemberEnvironment::class;
    }

    public function getDuplicateIp($perPage = 10, $page = null, $options = []): LengthAwarePaginator
    {
        $dateRange = request('start_date') && request('end_date') ? [request('start_date'), request('end_date')] : null;
        $search = request('search');

        $items = $this->model->when($search, function ($q1) use ($search) {
            $q1->where('mID', 'like', '%' . $search . '%');
        })->when($dateRange, function ($q2) use ($dateRange) {
            $q2->whereBetween('meRegDate', $dateRange);
        })->get()->groupBy('meIP')->map(function ($item) {
            if ($item->count() > 1) {
                return $item->unique('mID');
            }
        })->filter()->flatten();

        $lap = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => url()->current(),
                'pageName' => 'page',
                ...$options
            ]
        );

        return $lap;
    }
}
