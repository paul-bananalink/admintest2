<?php

namespace App\Services\Partner;

use App\Repositories\Partner\PointHistoryRepository;
use App\Services\PointHistoryService as AdminPointHistoryService;

class PointHistoryService extends AdminPointHistoryService
{
    public function __construct(
        private PointHistoryRepository $pointHistoryRepository,
    ) {
        parent::__construct(
            $pointHistoryRepository,
        );
    }
}
