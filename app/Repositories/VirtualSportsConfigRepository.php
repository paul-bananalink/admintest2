<?php

namespace App\Repositories;

class VirtualSportsConfigRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getConfig()
    {
        return $this->model->first();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\VirtualSportsConfig::class;
    }
}