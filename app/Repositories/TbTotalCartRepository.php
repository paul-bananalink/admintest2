<?php

namespace App\Repositories;

class TbTotalCartRepository extends BaseRepository
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
        return \App\Models\TbTotalCart::class;
    }

    public function getCartActive($idx)
    {
        return $this->model->where('idx', $idx)->where('isCanceled', 'N')->first();
    }

    public function getCartCancelled($idx)
    {
        return $this->model->where('idx', $idx)->where('isCanceled', 'Y')->first();
    }

    public function cancelCart($game_no)
    {
        $cart = $this->model->where('game_no', $game_no)->first();
        $cart->isCanceled = "Y";
        $cart->save();
    }

    public function getArrGameNo($between_date, $mNo, $game_type)
    {
        return $this->model->whereBetween('regdate', $between_date)
            ->where('visible', 'Y')
            ->where('mem_idx', $mNo)
            ->where('game_type', $game_type)
            ->select('game_no')
            ->pluck('game_no')->toArray();
    }

    public function getTotalBet($m_no, $date_range, $game_type)
    {
        return $this->model->where('mem_idx', $m_no)
            ->whereBetween('regdate', $date_range)
            ->where('sports_type', 'sports')
            ->where('visible', 'Y')
            ->where('game_type', $game_type)
            ->count();
    }
}
