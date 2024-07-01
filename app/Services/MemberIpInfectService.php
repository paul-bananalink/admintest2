<?php

namespace App\Services;

use App\Repositories\MembersLoginRepository;
use App\Repositories\MemberEnvironmentRepository;

class MemberIpInfectService extends BaseService
{
    public function __construct(private MemberEnvironmentRepository $memberEnvironmentRepository)
    {
    }

    public function getMemberIpInfect(array $attributes = []): array
    {
        $data = $this->handleSearch($attributes);

        return [
            'data' => $data,
        ];
    }

    private function handleSearch(array $attributes = [])
    {
        $current_page = data_get($attributes, 'page', 1);

        return $this->memberEnvironmentRepository->getDuplicateIp(30, $current_page);
    }
}
