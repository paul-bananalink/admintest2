<?php

namespace App\Repositories;

class CasinoConfigRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getConfig(string $ccType)
    {
        return $this->model->where('ccType', $ccType)->first();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\CasinoConfig::class;
    }
}
