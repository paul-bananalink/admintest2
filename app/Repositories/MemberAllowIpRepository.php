<?php

namespace App\Repositories;

class MemberAllowIpRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getMemberAllowIP(array $conditions = [])
    {
        return $this->model->where($conditions)->get()->sortDesc();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\MemberAllowIp::class;
    }
}
