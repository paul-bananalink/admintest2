<?php

namespace App\Repositories\Partner;

use App\Repositories\PartnerRepository as PartnerRepo;

class PartnerRepository extends PartnerRepo
{
    public function __construct()
    {
        parent::__construct($this->partnerChilds());
    }
}
