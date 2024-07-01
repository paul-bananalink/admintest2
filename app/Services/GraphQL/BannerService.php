<?php

namespace App\Services\GraphQL;

use App\Repositories\BannerRepository;
use Illuminate\Support\Collection;

class BannerService
{
    private BannerRepository $bannerRepository;

    public function __construct()
    {
        $this->bannerRepository = new BannerRepository;
    }

    /**
     * Get site info by current user login
     */
    public function getBanner(): Collection|array
    {
        $banner = $this->bannerRepository->getPositionAPI();

        return $banner;
    }
}
