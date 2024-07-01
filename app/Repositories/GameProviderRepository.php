<?php

namespace App\Repositories;

class GameProviderRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModel(): string
    {
        return \App\Models\GameProvider::class;
    }

    public function getAllByCategories(array $categories = [])
    {
        return $this->model->whereIn('gpCategory', $categories)->get();
    }

    public function getCategories(string $type)
    {
        return $this->model::$categories[$type] ?? [];
    }

    public function getGpCodesCasino()
    {
        return $this->model->select('gpName', 'gpCode')
            ->whereIn('gpCategory', $this->model::CATEGORY_CASINO)
            ->where('gpIsGameProvider', true)
            ->get();
    }

    public function findByGpCode(string $gpCode)
    {
        return $this->model->where('gpCode', $gpCode)->first();
    }

    public function firstByType(string $type)
    {
        return $this->model->whereIn('gpCategory', $this->model::$categories[$type])->first();
    }

    public function getGpCodesSlot()
    {
        return $this->model->whereIn('gpCategory', $this->model::CATEGORY_SLOT)->select('gpName', 'gpCode')->get();
    }
}
