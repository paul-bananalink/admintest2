<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * Update model by primary key on data update
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function updateByPK(?int $pk = null, array $update = []);

    /**
     * Create or update model by conditions on data attributes
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $conditions = [], array $attributes = []);

    /**
     * Create model by attributes
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes = []);

    /**
     * Get model by id primary key
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function getByPK(?int $id = null);
}
