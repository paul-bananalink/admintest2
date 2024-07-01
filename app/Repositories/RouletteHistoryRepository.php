<?php

namespace App\Repositories;

class RouletteHistoryRepository extends BaseRepository
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
        return \App\Models\RouletteHistory::class;
    }

    public function isFirstRound(string $mID): mixed
    {
        $res = $this->model->where('mID', $mID)
            ->where('rhStatus', 0)
            ->first();

        return $res ?? false;
    }
}
