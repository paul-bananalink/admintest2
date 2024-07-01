<?php

namespace App\Repositories;

class MiniGameConfigRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getConfig(string $gcType)
    {
        return $this->model->where('gcType', $gcType)->first();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\MiniGameConfig::class;
    }
}
