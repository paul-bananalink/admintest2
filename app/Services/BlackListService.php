<?php

namespace App\Services;

use App\Repositories\BlackListRepository;

class BlackListService extends BaseService
{

    /**
     * Create a new class instance.
     */
    public function __construct(private BlackListRepository $blackListRepository)
    {
    }

    public function paginateBlackList(array $attributes)
    {
        $blacklist = $this->blackListRepository->paginate([], [['blRegDate', 'DESC']], ['member']);

        return ['blacklist' => $blacklist];
    }
}
