<?php

namespace App\Repositories\Partner;

use App\Repositories\TransactionRepository as TransactionRepo;

class TransactionRepository extends TransactionRepo
{
    public function __construct()
    {
        parent::__construct($this->partnerChilds());
    }
}
