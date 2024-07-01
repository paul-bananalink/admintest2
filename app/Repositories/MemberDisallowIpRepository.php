<?php

namespace App\Repositories;

class MemberDisallowIpRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\MemberDisallowIp::class;
    }
}
