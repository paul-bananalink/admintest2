<?php

namespace App\Services;

use App\Models\BonusConfig;
use App\Repositories\PointHistoryRepository;

class PointHistoryService extends BaseService
{
    public function __construct(
        private PointHistoryRepository $pointHistoryRepository,
    ) {
    }

    public function getList($attributes = []): array
    {
        //convert to field
        $order_by = data_get($attributes, 'orderBy', 'phRegDate');
        //get sort field
        $sort = data_get($attributes, 'sort', config('constant_view.QUERY_DATABASE.DESC')) == config('constant_view.QUERY_DATABASE.DESC');

        if (data_get($attributes, 'filter') == 'recharge_bonus') {
            [
                'data' => $data,
            ] = $this->getRechargeBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'casino_first_time_recharge_bonus') {
            [
                'data' => $data,
            ] = $this->getCasinoFirstTimeRechargeBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'casino_next_time_recharge_bonus') {
            [
                'data' => $data,
            ] = $this->getCasinoNextTimeRechargeBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'signup_bonus') {
            [
                'data' => $data,
            ] = $this->getSignupBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'participate_bonus') {
            [
                'data' => $data,
            ] = $this->getParticipateBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'new_member_bonus') {
            [
                'data' => $data,
            ] = $this->getNewMemberBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'attendance_bonus') {
            [
                'data' => $data,
            ] = $this->getAttendanceBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'referral_1_bonus') {
            [
                'data' => $data,
            ] = $this->getReferral1Bonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'referral_2_bonus') {
            [
                'data' => $data,
            ] = $this->getReferral2Bonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'hall_of_fame_bonus') {
            [
                'data' => $data,
            ] = $this->getHallOfFameBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'consolation_prize_bonus') {
            [
                'data' => $data,
            ] = $this->getConsolationPrizeBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'payback_bonus') {
            [
                'data' => $data,
            ] = $this->getPaybackBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'rolling_bonus') {
            [
                'data' => $data,
            ] = $this->getRollingBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'losing_bonus') {
            [
                'data' => $data,
            ] = $this->getLosingBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'level_up_bonus') {
            [
                'data' => $data,
            ] = $this->getLevelUpBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'coupon_and_payment_bonus') {
            [
                'data' => $data,
            ] = $this->getCouponAndPaymentBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'sudden_bonus') {
            [
                'data' => $data,
            ] = $this->getSuddenBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'partner_share_bonus') {
            [
                'data' => $data,
            ] = $this->getPartnerShareBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'monthly_attendance_bonus') {
            [
                'data' => $data,
            ] = $this->getMonthlyAttendanceBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'admin_recharge') {
            [
                'data' => $data,
            ] = $this->getAdminRecharge($attributes, $order_by, $sort);
        } else {
            [
                'data' => $data,
            ] = $this->getBonusAll($attributes, $order_by, $sort);
        }

        return compact('data');
    }

    private function getBonusAll(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getRechargeBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_RECHARGE_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getCasinoFirstTimeRechargeBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getCasinoNextTimeRechargeBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getSignupBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_SIGNUP_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getParticipateBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_PARTICIPATE_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getNewMemberBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_NEW_MEMBER_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getAttendanceBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_ATTENDANCE_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getReferral1Bonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_REFERRAL_1_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getReferral2Bonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_REFERRAL_2_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getHallOfFameBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_HALL_OF_FAME_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getConsolationPrizeBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getPaybackBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_PAYBACK_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getRollingBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_ROLLING_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getLosingBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_LOSING_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getLevelUpBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_LEVEL_UP_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getCouponAndPaymentBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_COUPON_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getSuddenBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_SUDDEN_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getPartnerShareBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_PARTNER_SHARE_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getMonthlyAttendanceBonus(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_MONTHLY_ATTENDANCE_BONUS,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }

    private function getAdminRecharge(array $attributes, string $order_by = '', string $sort = 'desc'): array
    {
        $data = $this->pointHistoryRepository->getList(
            [
                'bonus_type' => BonusConfig::TYPE_ADMIN_RECHARGE,
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            ['order_by' => $order_by, 'sort' => $sort],
            request('per_page', 30),
        );
        return [
            'data' => $data,
        ];
    }
}
