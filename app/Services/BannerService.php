<?php

namespace App\Services;

use App\Repositories\BannerRepository;
use Illuminate\Support\Collection;

class BannerService extends BaseService
{
    private BannerRepository $bannerRepository;

    public function __construct()
    {
        $this->bannerRepository = new BannerRepository;
    }

    /**
     * Get site info by current user login
     */
    public function getBanner($position = null): Collection|array
    {
        $banner = $this->bannerRepository->getPosition($position);

        return $banner;
    }

    public function update(array $attributes = [])
    {
        return $this->tryCatchFuncDB(function () use ($attributes) {
            $index = 1;
            foreach ($attributes['data'] as $value) {
                $value['bPosition'] = $attributes['bPosition'];
                $value['bStatus'] = array_key_exists('bStatus', $value);
                $value['bOrder'] = $index;
                if (isset($value['bNo'])) {
                    $this->bannerRepository->updateByPK($value['bNo'], $value);
                } else {
                    $this->bannerRepository->create($value);
                }
                $index++;
            } 
        });
    }
}
