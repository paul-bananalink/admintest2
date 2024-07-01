<?php

namespace App\Services;

use App\Repositories\DisplayRepository;
use Illuminate\Support\Collection;

class DisplayService extends BaseService
{

    public function __construct(private DisplayRepository $displayRepository)
    {
    }

    public function getDisplay(): Collection
    {
        return $this->displayRepository->get()->keyBy('dpTable');
    }

    public function updateOrCreate(array $attributes = [])
    {
        if (isset($attributes['_token'])) unset($attributes['_token']);

        return $this->tryCatchFuncDB(function () use ($attributes) {
            foreach ($attributes as $table => $value) {
                $data = [];
                $data['dpTable'] = $table;
                $data['dpData'] = array_values($value);

                $this->displayRepository->updateOrCreate(['dpTable' => $table], $data);
            }
        });
    }
}
