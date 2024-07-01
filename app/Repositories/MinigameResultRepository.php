<?php

namespace App\Repositories;

use App\Models\MinigameResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MinigameResultRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModel(): string
    {
        return MinigameResult::class;
    }

    public function findLatestByMiniGame(int $mgNo): ?Model
    {
        return $this->model->where('mgNo', $mgNo)->latest()->first();
    }
    
    public function last(): ?Model
    {
        return MinigameResult::orderBy('mgrRound', 'desc')->first();
    }

    public function getResults(int $mgNo, ?string $mgrMode, int $limit = 288): ?Collection
    {
        return $this->model->where(['mgNo' => $mgNo, 'mgrMode' => $mgrMode])->latest()->take($limit)->get();
    }

    public function getRecordExist($mgrRound): ?MinigameResult
    {
        return $this->model->where('mgrRound', $mgrRound)->whereRaw('DATE(mgrRegDate) = ?', [now()->toDateString()])->first();
    }
}
