<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeConfig extends Model
{
    use HasFactory;

    protected $table = 'recharge_config';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'rcNo';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'rcRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'rcUpdateDate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rcNo',
        'rcMinRecharge',
        'rcDelayTime',
        'rcEnableRecharge',
        'rcAutoBonus',
        'rcMaxBonusFirstTimeSportsRecharge',
        'rcMaxBonusSportsRecharge',
        'rcMaxBonusFirstTimeCasinoRecharge',
        'rcMaxBonusCasinoRecharge',
        'rcDisableRechargeContent',
        'rcMaxRecharge',
        'rcWarningRechargeContent',
        'rcBonusWarningMessage',
        'rcEnableTimeOffRecharge',
        'rcTimeOffRecharge',
        'rcBanks',
        'rcInfoTopComment',
        'rcInfoButtonComment',
        'rcManualRecharge',
        'rcEnableConfigBonus',
        'rcEnableThousandMoney',
        'rcAmountNoBonus',
        'rcMaxBonusPokerRecharge',
        'rcMaxBonusFirstTimePokerRecharge'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rcMinRecharge' => 'decimal:2',
            'rcMaxBonusFirstTimeSportsRecharge' => 'decimal:2',
            'rcMaxBonusSportsRecharge' => 'decimal:2',
            'rcMaxBonusFirstTimeCasinoRecharge' => 'decimal:2',
            'rcMaxBonusCasinoRecharge' => 'decimal:2',
            'rcMaxRecharge' => 'array',
            'rcRegDate' => 'datetime:Y-m-d H:i:s',
            'rcUpdateDate' => 'datetime:Y-m-d H:i:s',
            'rcBonusWarningMessage' => 'array'
        ];
    }
}
