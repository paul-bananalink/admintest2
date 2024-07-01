<?php

namespace App\Repositories;

class GameRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getGamesByGpCode(string $gp_code = '') {
        return $this->model
        ->where('gpCode', $gp_code)
        ->orderBy($this->model->getKeyName(), config('constant_view.QUERY_DATABASE.DESC'))
        ->get();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\Game::class;
    }

    public function getConfig(string $gNo)
    {
        return $this->model->where('gNo', $gNo)->first();
    }
}
