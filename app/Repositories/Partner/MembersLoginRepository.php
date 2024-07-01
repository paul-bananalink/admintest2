<?php

namespace App\Repositories\Partner;

use App\Repositories\MembersLoginRepository as MembersLoginRepo;

class MembersLoginRepository extends MembersLoginRepo
{
    public function __construct()
    {
        parent::__construct($this->partnerChilds());
    }
}
