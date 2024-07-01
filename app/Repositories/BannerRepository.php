<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

class BannerRepository extends BaseRepository
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
        return \App\Models\Banner::class;
    }

    public function getPosition($position = null): Collection|array
    {
        if ($position === null) {
            return [];
        }

        return $this->model->where('bPosition', $position)->orderBy('bOrder')->get();
    }

    public function getPositionAPI(): Collection|array
    {
        return $this->model->where(['bStatus' => 1])->orderBy('bOrder')->get()->groupBy('bPosition');
    }
}
