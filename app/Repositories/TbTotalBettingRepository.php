<?php

namespace App\Repositories;

class TbTotalBettingRepository extends BaseRepository
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
        return \App\Models\TbTotalBetting::class;
    }

    public function getByGameNo($game_no)
    {
        return $this->model->where('game_no', $game_no)->get();
    }

    public function getBets($arr_game_no, $limit, $offset)
    {
        $bets = $this->model->whereIn('game_no', $arr_game_no)->with('parent.market')->offset($offset)->limit($limit)->with('cart')->orderBy('idx', 'desc')->get();
        $data = [];
        $pre_id = null;
        foreach ($bets as $bet) {
            $id = $bet->cart->idx;
            $cart_result = $this->betResult($bet->cart);
            $bet_money = $bet->cart->betting_money;
            $bet_date = $bet->cart->regdate;
            $bet_rate = $bet->cart->result_rate;
            $bonus_rate = 0;
            $bet_result = $bet->result;
            if ($bet->cart->isCanceled == "Y") {
                $bet_result = 5;
            }
            $fixture_idx = $bet->parent->fixture_idx;
            $select_rate = $bet->rate1;
            $selectIdx = "3";
            if ($bet->game_type == "3") {
                $selPickName = "언더";
            } else if ($bet->game_type == "10") {
                $selPickName = $bet->parent->home_team;
            } else {
                $selPickName = "홈승";
            }
            if ($bet->game_select == "3") {
                $select_rate = $bet->rate3;
                $selectIdx = "1";
                if ($bet->game_type == "3") {
                    $selPickName = "오버";
                } else if ($bet->game_type == "10") {
                    $selPickName = $bet->parent->away_team;
                } else {
                    $selPickName = "원정승";
                }
            }
            if ($bet->game_select == "2") {
                $select_rate = $bet->rate2;
                $selectIdx = "2";
                $selPickName = "무승";
            }
            $market = $bet->parent->market->name;
            $game_time = $bet->parent->game_time;
            $base_line = "";
            if ($bet->game_type != "1" && $bet->game_type != "10") {
                $base_line = $bet->rate2;
                if ($bet->game_type == "2" && $bet->game_select == "3") {
                    $base_line = number_format(-1 * (float) $bet->rate2, 1);
                }
                $base_line .= $bet->select_score;
            }
            $gameType = "크로스";
            if ($bet->game_type == "2") {
                $gameType = "프리매치";
            } else if ($bet->game_type == "3") {
                $gameType = "인플레이";
            }
            if ($pre_id != $id) {
                $data['cntInfo'][] = [
                    'id' => $id,
                    'betDate' => $bet_date,
                    'status' => $cart_result,
                    'cashBet' => $bet_money,
                    'rateBet' => number_format($bet_rate, 2, '.', ''),
                    'rateBonus' => $bonus_rate,
                ];
            }
            $data['detailInfo'][] = [
                'betId' => $id,
                'status' => $bet_result,
                'fixtureId' => $fixture_idx,
                'selectRate' => $select_rate,
                'baseLine' => $base_line,
                'startDate' => $game_time,
                'selectIdx' => $selectIdx,
                'selPickName' => $selPickName,
                'homeTeamName' => $bet->parent->home_team,
                'awayTeamName' => $bet->parent->away_team,
                'marketName' => $market,
                'gameType' => $gameType,
            ];

            $pre_id = $id;
        }
        return $data;
    }

    private function betResult($cart)
    {
        $result = 0;
        if ($cart->result == 1) {
            $result = 2;
        } else if ($cart->result == 2) {
            $result = 1;
        } else if ($cart->result == 3) {
            $result = 4;
        } else if ($cart->isCanceled == "Y") {
            $result = 5;
        }
        return $result;
    }
}
