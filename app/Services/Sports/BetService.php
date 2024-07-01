<?php

namespace App\Services\Sports;

use App\Exceptions\GraphQLException;
use App\Repositories\MemberRepository;
use Illuminate\Support\Facades\Http;
use App\Repositories\TbParentRepository;
use App\Repositories\TbTotalBettingRepository;
use App\Repositories\TbTotalCartRepository;
use Illuminate\Support\Str;
use App\Services\BaseService;

class BetService extends BaseService
{
    const ONE_MONTH = 1;

    const BET_RATE = 1;

    /**
     * Create a new class instance.
     */
    public function __construct(
        private TbParentRepository $tbParentRepository,
        private TbTotalBettingRepository $tbTotalBettingRepository,
        private TbTotalCartRepository $tbTotalCartRepository,
        private MemberRepository $memberRepository
    ) {
    }

    public function getBets($attributes)
    {
        $member = auth()->guard('sanctum')->user();

        $start_date = now()->subMonth(self::ONE_MONTH)->startOfDay();

        $end_date = now();

        $total = $this->tbTotalCartRepository->getTotalBet($member->mNo, [$start_date, $end_date], $attributes['game_type'],);

        $arr_game_no = $this->tbTotalCartRepository->getArrGameNo([$start_date, $end_date], $member->mNo, $attributes['game_type']);

        $data = $this->tbTotalBettingRepository->getBets($arr_game_no, $attributes['limit'], $attributes['offset']);

        return [
            'total' => $total,
            'list' => $data['cntInfo'],
            'detailList' => $data['detailInfo'],
            'length' => $attributes['limit']
        ];
    }

    public function bet($args)
    {
        $member = auth()->guard('sanctum')->user();
        $bet_rate = 1;
        $count_picked = $args['pick_list'] ? count($args['pick_list']) : 0;
        $bet_cash = $args['bet_cash'];
        $game_kind = $args['game_type'];
        $mNo = $member->mNo;
        $member_ip = request()->ip();
        $proto_id = uniqid();
        // $point = $member->mPoint;

        if (!$bet_cash || $count_picked == 0) {
            throw new GraphQLException('현재 베팅이 불가능합니다. 고객센터에 문의바랍니다.');
        }

        // TODO: Check if the user is allowed to bet

        if ($member->mSportsMoney < $bet_cash) {
            throw new GraphQLException('보유머니가 부족합니다.');
        }

        if ($count_picked < 1) {
            throw new GraphQLException('베팅을 선택해 주세요.');
        }

        if ($count_picked > 10) {
            throw new GraphQLException('최대 베팅 폴더 수는 10입니다.');
        }

        // TODO: Check min, max sports betting amount in the sports settings

        foreach ($args['pick_list'] as $picked) {
            $bet_rate *= (float)$picked['select_rate'];
            $fixture_idx = $picked['fixture_id'];
            $bet_idx = $picked['bet_code'];

            $parent = $this->tbParentRepository->getActiveParent($fixture_idx, $bet_idx);
            if (empty($parent)) {
                throw new GraphQLException('베팅시간이 마감되었습니다.');
            }

            $betid1 = $parent->betid1;
            $betid2 = $parent->betid2;
            $betid3 = $parent->betid3;

            $origin_rate1 = floatval($parent->rate1) ?? 0;
            $origin_rate2 = floatval($parent->rate2) ?? 0;
            $origin_rate3 = floatval($parent->rate3) ?? 0;

            $temp_rate1 = floatval($parent->add_rate1) ?? 0;
            $temp_rate2 = floatval($parent->add_rate2) ?? 0;
            $temp_rate3 = floatval($parent->add_rate3) ?? 0;

            $parent_idx = $parent->idx;
            $select_score = $parent->vs_team_sub;
            $game_type = $parent->game_type;

            $rate1 = $origin_rate1;
            $rate2 = $origin_rate2;
            $rate3 = $origin_rate3;

            if ($rate1 > $rate3) {
                $add_rate1 = $temp_rate1;
                $add_rate2 = $temp_rate2;
                $add_rate3 = $temp_rate3;
            } else if ($rate1 < $rate3) {
                $add_rate1 = $temp_rate1;
                $add_rate2 = $temp_rate2;
                $add_rate3 = $temp_rate3;
            } else {
                if ($game_type != 1 && $game_type != 4 && $game_type != 51) {
                    $add_rate1 = $temp_rate3;
                    $add_rate2 = $temp_rate2;
                    $add_rate3 = $temp_rate3;
                } else {
                    $add_rate1 = 0;
                    $add_rate2 = $temp_rate2;
                    $add_rate3 = 0;
                }
            }

            $total_rate1 = $rate1 + $add_rate1;
            $total_rate2 = $rate2 + $add_rate2;
            $total_rate3 = $rate3 + $add_rate3;

            if ($betid1 == $bet_idx) {
                $choice = 1;
                $select_rate = $total_rate1;
            } else if ($betid2 == $bet_idx) {
                $choice = 2;
                $select_rate = $total_rate2;
            } else if ($betid3 == $bet_idx) {
                $choice = 3;
                $select_rate = $total_rate3;
            }

            if ($select_rate != $picked['select_rate']) {
                throw new GraphQLException('배당이 변경되었습니다.');
            }

            $total_betting_data = [
                'sports_kind' => '',
                'parent_idx' => $parent_idx,
                'game_type' => $game_type,
                'game_no' => $proto_id,
                'GameSelect' => $choice,
                'rate1' => $total_rate1,
                'rate2' => $total_rate2,
                'rate3' => $total_rate3,
                'select_rate' => $select_rate,
                'select_line' => $origin_rate2,
                'select_score' => $select_score,
                'result' => '0',
                'betid' => $bet_idx
            ];

            $this->tbTotalBettingRepository->create($total_betting_data);
            if (in_array($member->mLevel, \App\Models\Member::M_BET_LEVEL_1_AND_2)) {
                $this->tbParentRepository->increaseSportsMoney($parent_idx, $bet_cash, $choice);
            }
        }

        $bet_rate = round($bet_rate, 2);

        $cartData = [
            "mem_idx" => $mNo,
            "game_no" => $proto_id,
            "regdate" => now(),
            "result" => '0',
            "betting_cnt" => $count_picked,
            "betting_money" => $bet_cash,
            "result_rate" => $bet_rate,
            "result_money" => '0',
            "visible" => 'Y',
            "bettingIP" => $member_ip,
            "confirmBetting" => '0',
            "reason" => '',
            "sports_type" => 'sports',
            "game_type" => $game_kind,
            'isCanceled' => 'N'
        ];

        $this->tbTotalCartRepository->create($cartData);

        $total_money = $member->mSportsMoney - $bet_cash;

        $this->memberRepository->updateByPK($mNo, ['mSportsMoney' => $total_money]);

        return $total_money;
    }

    public function updatePick($attributes)
    {
        $member = auth()->guard('sanctum')->user();
        if (!$member) {
            throw new GraphQLException('로그인를 해주세요.');
        }

        $bet_data = $attributes['pick_list'];

        if (!$bet_data) {
            throw new GraphQLException('현재 베팅이 불가능합니다. 고객센터에 문의바랍니다...');
        }

        $data = [];
        foreach ($bet_data as $bet) {
            $fixture_idx = $bet['fixture_id'];
            $bet_idx = $bet['bet_code'];

            $parent = $this->tbParentRepository->getParent($fixture_idx, $bet_idx);
            if (empty($parent)) {
                throw new GraphQLException('베팅시간이 마감되었습니다.');
            }

            $betid1 = $parent->betid1;
            $betid2 = $parent->betid2;
            $betid3 = $parent->betid3;
            $rate1 = $parent->rate1;
            $rate2 = $parent->rate2;
            $rate3 = $parent->rate3;
            $status = (int)$parent->status - 1;

            if ($betid1 == $bet_idx) {
                $select_rate = $rate1;
            } else if ($betid2 == $bet_idx) {
                $select_rate = $rate2;
            } else if ($betid3 == $bet_idx) {
                $select_rate = $rate3;
            }
            $data[] = ['bet_code' => $bet_idx, 'select_rate' => $select_rate, 'status' => $status];
        }

        return $data;
    }

    public function cancelBet($card_id)
    {
        $member = auth()->guard('sanctum')->user();
        if (!$member) {
            throw new GraphQLException('로그인를 해주세요.');
        }

        $cart = $this->tbTotalCartRepository->getCartActive($card_id);

        if (empty($cart)) {
            throw new GraphQLException('잘못된 접근입니다.');
        }

        $mNo = $cart->mem_idx;
        $betting_money = $cart->betting_money;
        $game_no = $cart->game_no;
        $total_money = $cart->member->mSportsMoney + $betting_money;

        if ($member->mNo !== $mNo) {
            throw new GraphQLException('로그인를 해주세요.');
        }

        $total_money = (float)$member->mSportsMoney + $betting_money;

        $this->tryCatchFuncDB(function () use ($mNo, $total_money, $game_no) {
            $this->memberRepository->updateByPK($mNo, ['mSportsMoney' => $total_money]);
            $this->tbTotalCartRepository->cancelCart($game_no);
        });

        if (in_array($member->mLevel, \App\Models\Member::M_BET_LEVEL_1_AND_2)) {
            $total_bettings = $this->tbTotalBettingRepository->getByGameNo($game_no);
            foreach ($total_bettings as $bet) {
                $choice = $bet->GameSelect;
                $parent_idx = $bet->parent_idx;
                $this->tryCatchFuncDB(function () use ($parent_idx, $betting_money, $choice) {
                    $this->tbParentRepository->decreaseSportsMoney($parent_idx, $betting_money, $choice);
                });
            }
        }

        return $total_money;
    }

    public function deleteBet($bet_id)
    {
        $member = auth()->guard('sanctum')->user();
        if (!$member) {
            throw new GraphQLException('로그인를 해주세요.');
        }

        $cart = $this->tbTotalCartRepository->getCartCancelled($bet_id);
        if (empty($cart)) {
            throw new GraphQLException('잘못된 접근입니다.');
        }

        $mNo = $cart->mem_idx;
        if ($member->mNo !== $mNo) {
            throw new GraphQLException('로그인를 해주세요.');
        }

        return $this->tryCatchFuncDB(function () use ($cart) {
            $this->tbParentRepository->updateByPK($cart, ['visible' => 'N']);
        });
    }
}
