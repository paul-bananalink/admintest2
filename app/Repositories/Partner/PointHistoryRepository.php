<?php

namespace App\Repositories\Partner;

use App\Repositories\PointHistoryRepository as PointHistoryRepo;

class PointHistoryRepository extends PointHistoryRepo
{
    public function __construct()
    {
        parent::__construct(['whereIn' => [['mID', $this->arrChildren()]]]);
    }
}
