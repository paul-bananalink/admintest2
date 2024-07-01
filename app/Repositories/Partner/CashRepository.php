<?php

namespace App\Repositories\Partner;

use App\Repositories\CashRepository as AdminCashRepository;

class CashRepository extends AdminCashRepository
{
    public function __construct()
    {
        parent::__construct($this->partnerChilds());
    }
}
