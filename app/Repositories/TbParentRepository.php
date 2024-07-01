<?php

namespace App\Repositories;

class TbParentRepository extends BaseRepository
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
        return \App\Models\TbParent::class;
    }

    public function getActiveParent($fixture_idx, $bet_idx)
    {
        return $this->model->where('fixture_idx', $fixture_idx)
            ->where('isStop', 'N')
            ->where('status', 1)
            ->where(function ($query) use ($bet_idx) {
                $query->where('betid1', $bet_idx)
                    ->orWhere('betid2', $bet_idx)
                    ->orWhere('betid3', $bet_idx);
            })->select('betid1', 'betid2', 'betid3', 'rate1', 'rate2', 'rate3', 'add_rate1', 'add_rate2', 'add_rate3', 'idx', 'vs_team_sub', 'game_time', 'game_id', 'home_team', 'game_type')
            ->first();
    }

    public function getParent($fixture_idx, $bet_idx)
    {
        return $this->model->where('fixture_idx', $fixture_idx)
            ->where(function ($query) use ($bet_idx) {
                $query->where('betid1', $bet_idx)
                    ->orWhere('betid2', $bet_idx)
                    ->orWhere('betid3', $bet_idx);
            })->select('betid1', 'betid2', 'betid3', 'rate1', 'rate2', 'rate3', 'idx', 'game_time', 'game_id', 'home_team', 'game_type', 'status')
            ->first();
    }

    public function increaseSportsMoney($parent_idx, $money, $choice)
    {
        $parent = $this->model->where('idx', $parent_idx)->first();
        $parent->increment("money{$choice}", $money);
    }

    public function decreaseSportsMoney($parent_idx, $money, $choice)
    {
        $parent = $this->model->where('idx', $parent_idx)->first();
        $parent->decrement("money{$choice}", $money);
    }
}
