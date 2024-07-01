<?php

namespace App\Repositories;

class RechargeConfigRepository extends BaseRepository
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
        return \App\Models\RechargeConfig::class;
    }
}
