<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

class PopupRepository extends BaseRepository
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
        return \App\Models\Popup::class;
    }

    public function getData(): Collection
    {
        $filter = request('filter');
        $search_input = request('search_input');

        $query =  $this->model->query();

        if (empty($filter)) return $query->get();

        if ($filter === 'poUsed') {
            $query->where('poUsed', 1);
        } elseif ($filter === 'poNotUsed') {
            $query->where('poUsed', 0);
        } elseif ($filter === 'poOpenNewWindow') {
            $query->where('poOpenNewWindow', 1);
        }

        if ($search_input) {
            $query->where('poContent',  'like', '%' . $search_input . '%'); // search
        }

        return $query->get();
    }

    public function getDataApi()
    {
        return $this->model
            ->where('poUsed', 1)
            ->get();
    }
}
