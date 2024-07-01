<?php

namespace App\Services;

use App\Models\Member;
use App\Repositories\SettlementRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class SettlementService extends BaseService
{
    public function __construct(
        private SettlementRepository $settlementRepo
    ) {
    }

    public function index(): array
    {
        return $this->settlementRepo->getData();
    }

    public function detail(int $id): array
    {
        $partner = $this->settlementRepo->getByPK($id);

        return $this->settlementRepo->getData($partner);
    }

    public function web($params = []): array
    {
        return $this->settlementRepo->getDataWeb($params);
    }

    public function user($params = []): Paginator
    {
        return $this->settlementRepo->getDataUser($params);
    }
}
