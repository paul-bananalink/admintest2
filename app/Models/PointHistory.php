<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointHistory extends Model
{
    use HasFactory;

    protected $table = 'point_history';

    const CREATED_AT = 'phRegDate';
    const UPDATED_AT = 'phUpdateDate';

    public const MONEY_INFO_TABLE = 'money_info';

    public const TRANSACTION_TABLE = 'transaction';

    const BONUS_TEXT = [
        BonusConfig::TYPE_BONUS => '보너스',
        BonusConfig::TYPE_RECHARGE_BONUS => '충전',
        BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE => '카지노첫충전',
        BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE => '카지노매충전',
        BonusConfig::TYPE_SIGNUP_BONUS => '가입머니',
        BonusConfig::TYPE_PARTICIPATE_BONUS => '입플',
        BonusConfig::TYPE_NEW_MEMBER_BONUS => '신규',
        BonusConfig::TYPE_ATTENDANCE_BONUS => '출석현황',
        BonusConfig::TYPE_REFERRAL_1_BONUS => '지인추천1',
        BonusConfig::TYPE_REFERRAL_2_BONUS => '지인추천2',
        BonusConfig::TYPE_HALL_OF_FAME_BONUS => '명예의 전당',
        BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS => '위로금',
        BonusConfig::TYPE_PAYBACK_BONUS => '페이백',
        BonusConfig::TYPE_ROLLING_BONUS => '롤링포인트',
        BonusConfig::TYPE_LOSING_BONUS => '낙첨포인트',
        BonusConfig::TYPE_LEVEL_UP_BONUS => '레벨업',
        BonusConfig::TYPE_COUPON_BONUS => '쿠폰현황 및 지급',
        BonusConfig::TYPE_SUDDEN_BONUS => '돌발보너스',
        BonusConfig::TYPE_PARTNER_SHARE_BONUS => '파트너롤링 쉐어',
        BonusConfig::TYPE_MONTHLY_ATTENDANCE_BONUS => '월출석현황',
        BonusConfig::TYPE_ADMIN_RECHARGE => '관리자지급',
        BonusConfig::TYPE_ROLLBACK => '롤백',
    ];

    const BONUS_DESCRIPTION_TITLE = [
        BonusConfig::TYPE_BONUS => '',
        BonusConfig::TYPE_RECHARGE_BONUS => '지급 포인트',
        BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE => '카지노첫충전',
        BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE => '카지노매충전',
        BonusConfig::TYPE_SIGNUP_BONUS => '가입머니 설졍',
        BonusConfig::TYPE_PARTICIPATE_BONUS => '입플보너스',
        BonusConfig::TYPE_NEW_MEMBER_BONUS => '신규보너스',
        BonusConfig::TYPE_ATTENDANCE_BONUS => '출석현황 주정산',
        BonusConfig::TYPE_REFERRAL_1_BONUS => '출석현황 월정산1',
        BonusConfig::TYPE_REFERRAL_2_BONUS => '출석현황 월정산2',
        BonusConfig::TYPE_HALL_OF_FAME_BONUS => '명예의 전당',
        BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS => '위로금 보너스',
        BonusConfig::TYPE_PAYBACK_BONUS => '페이백 보너스',
        BonusConfig::TYPE_ROLLING_BONUS => '콜링포인트',
        BonusConfig::TYPE_LOSING_BONUS => '낙첨 포인트',
        BonusConfig::TYPE_LEVEL_UP_BONUS => '레벨업',
        BonusConfig::TYPE_COUPON_BONUS => '쿠폰 사용',
        BonusConfig::TYPE_SUDDEN_BONUS => '돌발 입금 보너스 사용',
        BonusConfig::TYPE_PARTNER_SHARE_BONUS => '파트너롤링 쉐어',
        BonusConfig::TYPE_MONTHLY_ATTENDANCE_BONUS => '월출석현황',
        BonusConfig::TYPE_ADMIN_RECHARGE => '관리자지급',
        BonusConfig::TYPE_ROLLBACK => '롤백',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phNo',
        'phID',
        'phTable',
        'mID',
        'phPoint',
        'phMoney',
        'phSportsMoney',
        'mPoint',
        'mMoney',
        'mSportsMoney',
        'phExchangeRate',
        'phToWallet',
        'phDescription',
        'phBonusType',
        'phGameType',
    ];

    protected static function boot()
    {
        parent::boot();

        static::resolveRelationUsing('item', function ($pointHistory) {
            switch ($pointHistory->phTable) {
                case 'transaction':
                    return $pointHistory->hasOne(Transaction::class, 'uuid', 'phID')->with('member.partner');
                case 'money_info':
                    return $pointHistory->hasOne(MoneyInfo::class, 'miNo', 'phID')->with('member.partner');
                default:
                    return null;
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'mPoint' => 'float',
            'mMoney' => 'float',
            'mSportsMoney' => 'float',
            'phPoint' => 'float',
            'phMoney' => 'float',
            'phSportsMoney' => 'float',
            'phExchangeRate' => 'float',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }

    public function getMessageAttribute()
    {
        // if ($this->phTable == self::TRANSACTION_TABLE) {
        //     $formattedMoney = formatNumber($this->item->tAmount);
        //     if ($this->item->tType == 'Bet') {
        //         //Betting
        //         return "<span class='text-green-5'>[롤링]{$this->item->gName}/{$formattedMoney}원 배팅/ 고유코드 {$this->item->uuid}</span>";
        //     } else {
        //         //Winning
        //         return "<span class='text-yellow'>[낙첨][{$this->item->gName}]/고유코드 [{$this->item->uuid}][적중금액: {$formattedMoney}]</span>";
        //     }
        // } else {
        //     $formattedMoney = formatNumber($this->item->miBankMoney);
        //     if (in_array($this->item->miType, MoneyInfo::MI_TYPE_FILTER[MoneyInfo::RECHARGE])) {
        //         // Admin recharge
        //         if ($this->item->miType == MoneyInfo::TYPE_AD) {
        //             return "[관리자지급] / {$this->item->miDescription} / {$formattedMoney} 포인트";
        //         }

        //         //Recharge
        //         $wallet = MoneyInfo::MI_WALLET_TYPE[$this->item->miWallet];
        //         $char = $this->item->isFirstRecharge ? '첫' : '매';
        //         $miBonusPercent = data_get($this->item, 'miBonusPercent', 0);
        //         $miBankMoney = data_get($this->item, 'miBankMoney', 0);
        //         $bonusMoney = data_get($this->item, 'bonusMoney', 0);

        //         return '[' . $wallet . ' - ' . $char . ' 입금보너스](' . formatNumber($miBankMoney) . ' X ' . $miBonusPercent . '%) = ' . formatNumber($bonusMoney) . ' 포인트 지급완료';
        //     } else {
        //         //Withdraw
        //         return "<span class='red'>[카지노출금]{$formattedMoney} {$this->item->miStatus}/고유코드 [{$this->item->uuid}]</span>";
        //     }
        // }

        $title = self::BONUS_DESCRIPTION_TITLE[$this->phBonusType];
        $type = self::BONUS_TEXT[$this->phBonusType];
        $point = formatNumber($this->phPoint);
        $message = "{$title} / {$type} / {$point}";

        return $message;
    }

    public function getAmountAttribute()
    {
        return $this->phTable == self::TRANSACTION_TABLE ? $this->item->tAmount : $this->item->miBankMoney;
    }

    public function getPointTypeAttribute()
    {
        return $this->phBonusType ? self::BONUS_TEXT[$this->phBonusType] : '';
    }
}
