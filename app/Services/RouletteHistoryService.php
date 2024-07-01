<?php

namespace App\Services;

use App\Repositories\RouletteHistoryRepository;

class RouletteHistoryService extends BaseService
{
    public function __construct(
        private RouletteHistoryRepository $rouletteHistoryRepository,
    ) {
    }
}
