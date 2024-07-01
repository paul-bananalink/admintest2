<?php

namespace App\Repositories;

class DomainRepository extends BaseRepository
{
    protected function getModel(): string {
        return \App\Models\Domain::class;
    }

    public function getConfig()
    {
        return $this->model->first();
    }
}

