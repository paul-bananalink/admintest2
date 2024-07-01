<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealtimeConfig extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'rtcNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'realtime_config';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rtcBlockBet',
        'rtcNoticeBlockBet',
        'rtcDuplicateBetCount',
        'rtcMaxBetFolderCount',
        'rtcRealtimeSoccer',
        'rtcRealtimeBasketball',
        'rtcRealtimeBaseball',
        'rtcRealtimeVolleyball',
        'rtcRealtimeHockey',
        'rtcRealtimeEsports',
        'rtcVisibilityOfMainOdds',
        'rtcFeed',
        'rtcBasketballCrossExposure',
        'rtcMemberLosingPoints',
        'rtcMemberRollingPoints',
        'rtcMinBetAmount1',
        'rtcMinBetAmount2',
        'rtcMinBetAmount3',
        'rtcMaxBetAmount1',
        'rtcMaxBetAmount2',
        'rtcMaxBetAmount3',
        'rtcMaxBetPayout1',
        'rtcMaxBetPayout2',
        'rtcMaxBetPayout3',
        'rtcUserAllocationByLevel',
        'rtcMaxPayout'

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
            'rtcMemberLosingPoints' => 'array',
            'rtcMemberRollingPoints' => 'array',
            'rtcMinBetAmount1' => 'array',
            'rtcMinBetAmount2' => 'array',
            'rtcMinBetAmount3' => 'array',
            'rtcMaxBetAmount1' => 'array',
            'rtcMaxBetAmount2' => 'array',
            'rtcMaxBetAmount3' => 'array',
            'rtcMaxBetPayout1' => 'array',
            'rtcMaxBetPayout2' => 'array',
            'rtcMaxBetPayout3' => 'array',
            'rtcUserAllocationByLevel' => 'array',
            'rtcMaxPayout' => 'array',
        ];
    }
}
