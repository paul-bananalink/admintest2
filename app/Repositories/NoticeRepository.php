<?php

namespace App\Repositories;

class NoticeRepository extends BaseRepository
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
        return \App\Models\Notice::class;
    }

    public function getAllNotice(array $attributes, int $page, int $limit, array $conditions = [])
    {
        $query = $this->model::query();

        if (isset($attributes['ntType'])) {
            $query = $query->where('ntType', $attributes['ntType']);
        }
    
        foreach ($conditions as $condition) {
            $query = $query->where($condition[0], $condition[1], $condition[2]);
        }

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    public function countUnreadByPartner(string $mID): int
    {
        return $this->model->where('ntType', config('constant_view.GUARD.PARTNER'))
            ->where('ntRegDate', '>', now()->subDay())
            ->whereHas('notice_member', function($query) use ($mID) {
                $query->where(['nmRead' => 0, 'mID' => $mID]);
            })
            ->count();
    }
}
