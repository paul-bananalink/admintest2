<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberConfig extends Model
{
    use HasFactory;

    const ROLLING_RATE = ['Live Casino' => 'mcRollingCasinoRate', 'Slot' => 'mcRollingSlotRate'];

    const PUBLIC_BETTING = ['Live Casino' => 'mcPublicBettingCasino', 'Slot' => 'mcPublicBettingSlot'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mcNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_config';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'mcRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'mcUpdateDate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mcNo',
        'mID',
        'mcForceLogout',
        'mcIsRechargeLimit',
        'mcIsWithdrawLimit',
        'mcIsAlbagi',
        'mcSport',
        'mcMiniGame',
        'mcCasino',
        'mcSlot',
        'mcSportsRolling',
        'mcCasinoRolling',
        'mcRegDate',
        'mcUpdateDate',
        'mcMultiPoleAmount',
        'mcSinglePoleAmount',
        'mcEnableMultiPole',
        'mcEnableSinglePole',
        'mcSportsMoneyWithdraw',
        'mcCasinoMoneyWithdraw',
        'mcIsAttentionMember',
        'mcSuspicion',
        'mcGameProvider',
        'mcSlotRate',
        'mcLossSlot',
        'mcPublicBettingSlot',
        'mcPublicBettingCasino',
        'mcMaxWinCasinoMoney',
        'mcMaxWinSlotMoney',
        'mcEventRestrictions',
        'mcRollingCasinoRate',
        'mcRollingSlotRate',
        'mcLossCasinoRate',
        'mcLossSlotRate'
    ];


    const MONEY_WITHDRAW_UPDATE_FIELD = [
        'sports' => 'mcSportsMoneyWithdraw',
        'casino_slot' => 'mcCasinoMoneyWithdraw',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'mcRegDate' => 'datetime:Y-m-d H:i:s',
            'mcUpdateDate' => 'datetime:Y-m-d H:i:s',
            'mcGameProvider' => 'array',
            'mcMaxWinCasinoMoney' => 'decimal:2',
            'mcMaxWinSlotMoney' => 'decimal:2',
            'mcEventRestrictions' => 'array'
        ];
    }

    public function resetRollingWhenRecharge($miType)
    {
        if (in_array($miType, MoneyInfo::MI_TYPE_FILTER['recharge'])) {
            return $this->update(['mcSportsRolling' => false, 'mcCasinoRolling' => false]);
        }
    }
}
