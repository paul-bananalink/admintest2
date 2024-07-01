<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusConfig extends Model
{
    use HasFactory;

    protected $table = 'bonus_config';

    protected $primaryKey = 'bcNo';

    public $timestamps = false;

    protected $fillable = [
        'bcType',
        'bcKey',
        'bcValue'
    ];

    const TYPE_BONUS = "bonus";
    const TYPE_RECHARGE_BONUS = "recharge_bonus";
    const TYPE_CASINO_FIRST_TIME_RECHARGE = "casino_first_time_recharge_bonus";
    const TYPE_CASINO_NEXT_TIME_RECHARGE = "casino_next_time_recharge_bonus";
    const TYPE_SIGNUP_BONUS = "signup_bonus";
    const TYPE_PARTICIPATE_BONUS = "participate_bonus";
    const TYPE_NEW_MEMBER_BONUS = "new_member_bonus";
    const TYPE_ATTENDANCE_BONUS = "attendance_bonus";
    const TYPE_REFERRAL_1_BONUS = "referral_1_bonus";
    const TYPE_REFERRAL_2_BONUS = "referral_2_bonus";
    const TYPE_HALL_OF_FAME_BONUS = "hall_of_fame_bonus";
    const TYPE_CONSOLATION_PRIZE_BONUS = "consolation_prize_bonus";
    const TYPE_PAYBACK_BONUS = "payback_bonus";
    const TYPE_ROLLING_BONUS = "rolling_bonus";
    const TYPE_LOSING_BONUS = "losing_bonus";
    const TYPE_COUPON_BONUS = "coupon_bonus";
    const TYPE_SUDDEN_BONUS = "sudden_bonus";
    const TYPE_PARTNER_SHARE_BONUS = "partner_share_bonus";
    const TYPE_MONTHLY_ATTENDANCE_BONUS = "monthly_attendance_bonus";
    const TYPE_ADMIN_RECHARGE = "admin_recharge";
    const TYPE_REFERRAL_BONUS = "referral_bonus";
    const TYPE_LEVEL_UP_BONUS = "level_up_bonus";
    const TYPE_ROLLBACK = "rollback";

    const LIST_EVENT_RESTRICTIONS = [
        self::TYPE_BONUS => '보너스',
        self::TYPE_RECHARGE_BONUS => '충전 보너스',
        self::TYPE_CASINO_FIRST_TIME_RECHARGE => '카지노 첫 충전 보너스',
        self::TYPE_CASINO_NEXT_TIME_RECHARGE => '카지노 다음 충전 보너스',
        self::TYPE_SIGNUP_BONUS => '회원가입 보너스',
        self::TYPE_PARTICIPATE_BONUS => '참여 보너스',
        self::TYPE_NEW_MEMBER_BONUS => '신규회원 보너스',
        self::TYPE_ATTENDANCE_BONUS => '출석 보너스',
        self::TYPE_REFERRAL_1_BONUS => '추천인 1순위 보너스',
        self::TYPE_REFERRAL_2_BONUS => '추천인 2순위 보너스',
        self::TYPE_HALL_OF_FAME_BONUS => '명예의 전당 보너스',
        self::TYPE_CONSOLATION_PRIZE_BONUS => '위로 보너스',
        self::TYPE_PAYBACK_BONUS => '페이백 보너스',
        self::TYPE_ROLLING_BONUS => '롤링 보너스',
        self::TYPE_LOSING_BONUS => '루징 보너스',
        self::TYPE_COUPON_BONUS => '쿠폰 보너스',
        self::TYPE_SUDDEN_BONUS => '급여 보너스',
        self::TYPE_PARTNER_SHARE_BONUS => '파트너 쉐어 보너스',
        self::TYPE_MONTHLY_ATTENDANCE_BONUS => '월간 출석 보너스',
        self::TYPE_ADMIN_RECHARGE => '관리자 충전',
        self::TYPE_REFERRAL_BONUS => '추천 보너스',
        self::TYPE_LEVEL_UP_BONUS => '레벨업 보너스',
        self::TYPE_ROLLBACK => '롤백',
    ];

    const CASINO_RECHARGE = 'casino_recharge';

    const CASINO_FIRST_TIME_RECHARGE = 'casino_first_time_recharge';

    const WEEKEND_RATE = 'weekend_rate';

    const WEEKDAY_RATE = 'weekday_rate';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'bcValue' => 'array',
        ];
    }
}
