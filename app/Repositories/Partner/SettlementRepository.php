<?php

namespace App\Repositories\Partner;

use App\Repositories\SettlementRepository as AdminSettlementRepo;

class SettlementRepository extends AdminSettlementRepo
{
    public function __construct()
    {
        parent::__construct($this->partnerChilds());
    }
}
