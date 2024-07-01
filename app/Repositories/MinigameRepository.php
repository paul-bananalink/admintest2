<?php

namespace App\Repositories;

class MinigameRepository extends BaseRepository
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
        return \App\Models\Minigame::class;
    }

    public function findByName($mgName)
    {
        return $this->model->where('mgName', $mgName)->first();
    }
}
