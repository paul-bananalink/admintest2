<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawConfig extends Model
{
    use HasFactory;

    protected $table = 'withdraw_config';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'wcNo';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'wcRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'wcUpdateDate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wcNo',
        'wcMinWithdraw',
        'wcDelayTime',
        'wcEnableDelayTime',
        'wcAutoPayRoll',
        'wcRollingRules',
        'wcManualWithdraw',
        'wcTimeOffWithdraw',
        'wcEnableWithdraw',
        'wcDisableWithdrawContent',
        'wcMaxRechargePerDay',
        'wcMaxRechargePerTime',
        'wcNoBonus',
        'wcBonus',
        'wcWithdrawRules',
        'wcRegDate',
        'wcUpdateDate',
        'wcExchangeMoneyContent',
        'wcNoBonusContent',
        'wcEnableTimeOffWithdraw',
        'wcRuleWithdrawContent'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'wcMinWithdraw' => 'decimal:2',
            'wcMaxRechargePerTime' => 'array',
            'wcMaxRechargePerDay' => 'array',
            'wcNoBonus' => 'array',
            'wcBonus' => 'array',
            'wcRegDate' => 'datetime:Y-m-d H:i:s',
            'wcUpdateDate' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
