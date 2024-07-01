<?php

namespace App\Repositories\Partner;

use App\Repositories\MoneyInfoRepository as MoneyInfoRepo;

class MoneyInfoRepository extends MoneyInfoRepo
{
    public function __construct()
    {
        parent::__construct($this->partnerChilds());
    }

    /**
     * get member logged from date to date
     *
     * @param string $date_from
     * @param string $date_to
     * @param array $order_sort
     * @param int $per_page
     * @param array $partner_children
     * @return mixed
     */
    public function getBonusByAdminFilter(string $wallet = null, bool $is_first = false, array $order_sort = [], array $filter_search = [], int $per_page = 30, array $partner_children = null)
    {
        return parent::getBonusByAdminFilter($wallet, $is_first, $order_sort, $filter_search, $per_page, partner_children: $this->arrChildren());
    }
}
