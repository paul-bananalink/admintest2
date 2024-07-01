<?php

namespace App\Repositories;

class MoneyInfoHistoryRepository extends BaseRepository
{
    public function __construct(?array $params = [])
    {
        parent::__construct($params);
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\MoneyInfoHistory::class;
    }
}
