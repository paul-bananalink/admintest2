<?php

namespace App\Repositories\Partner;

use App\Repositories\MemberRepository as MemberRepo;
use Illuminate\Pagination\LengthAwarePaginator;

class MemberRepository extends MemberRepo
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getListMemberStatusAccessNew(array $conditions = [], array $order_sort = [], int $per_page = 30, array $partner_children = null): LengthAwarePaginator
    {
        return parent::getListMemberStatusAccessNew($conditions, $order_sort, $per_page, partner_children: $this->arrChildren());
    }
}
