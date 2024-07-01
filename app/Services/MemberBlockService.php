<?php

namespace App\Services;

use App\Repositories\MemberLoginFailedRepository;

class MemberBlockService extends BaseService
{
    public function __construct(private MemberLoginFailedRepository $memLoginRepo)
    {
        $this->memLoginRepo = new MemberLoginFailedRepository();
    }

    public function getAllMemberLoginFailed()
    {
        return $this->memLoginRepo->getModel();
    }

    public function searchMemberLoginFailed($searchInput = null, $startDate = null, $endDate = null)
    {
        return $this->memLoginRepo->searchMemberLoginFailed($searchInput, $startDate, $endDate);
    }
}
