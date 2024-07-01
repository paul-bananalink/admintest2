<?php

namespace App\Repositories;

class WithdrawConfigRepository extends BaseRepository
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
        return \App\Models\WithdrawConfig::class;
    }
}
