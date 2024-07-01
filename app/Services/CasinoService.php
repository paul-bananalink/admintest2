<?php

namespace App\Services;

use App\Repositories\GameProviderRepository;

class CasinoService extends BaseService
{
    public function __construct(
        private GameProviderRepository $gameProviderRepo
    ) {
    }

    public function getGameProviders(string $type)
    {
        $categories = $this->gameProviderRepo->getCategories($type);
        return $this->gameProviderRepo->getAllByCategories($categories);
    }
}
