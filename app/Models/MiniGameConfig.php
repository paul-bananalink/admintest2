<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiniGameConfig extends Model
{
    use HasFactory;

    const TYPE_MINI_GAME = 'mini-game';
    const TYPE_LOTUS = 'lotus';
    const TYPE_MGM = 'mgm';
    const TYPE_BET_GAGME_TV = 'bet-game-tv';
    const TYPE_VIRTUAL_SPORTS = 'virtual-sports'; // Đã có bảng riêng virtual_sports_config

    const TYPES = [
        self::TYPE_MINI_GAME => '미니게임',
        self::TYPE_LOTUS => '로투스',
        self::TYPE_MGM => 'MGM',
        self::TYPE_BET_GAGME_TV => '벳게임티비',
        self::TYPE_VIRTUAL_SPORTS => '가상스포츠' // Đã có bảng riêng virtual_sports_config
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'gcNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mini_game_config';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        //All
        'gcType',
        'gcBlockBet',
        'gcNoticeBlockBet',
        'gcDuplicateBetCount',
        'gcVisibilityStatus',
        'gcVisibilityAllStatus',

        'gcTimeBet', // Not BetgameTV
        //All

        //All - json
        'gcMemberLosingPoints',
        'gcMemberRollingPoints',

        'gcMinBetAmount',
        'gcMaxBetAmount',
        'gcMaxBetPayout',
        'gcMaxPayout',
        //All - json

        'gcPlayerOdds',
        'gcBankerOdds',
        'gcPairOdds',
        'gcTieOdds',


        // mini-game
        'gcPower_OddEven_OverUnder_BettingOdds',
        'gcGeneral_OddEven_OverUnder_BettingOdds',
        'gcGeneral_SmallBettingOdds',
        'gcGeneral_MediumBettingOdds',
        'gcGeneral_LargeBettingOdds',
        'gcPowerNumberBettingOdds',
        'gcPowerOdd_OverEven_UnderBettingOdds',
        'gcPowerOdd_UnderEven_OverBettingOdds',
        'gcGeneralOdd_OverEven_UnderBettingOdds',
        'gcGeneralOdd_UnderEven_OverBettingOdds',
        'gcPowerGeneralCombinationBettingOdds',
        'gcGeneralOddEven_SmallBettingOdds',
        'gcGeneralOddEven_MediumBettingOdds',
        'gcGeneralOddEven_LargeBettingOdds',
        // mini-game

        'gcSameOptionBettingStatus',
        'gcCombinationBettingStatus',
        'gcNumberBettingStatus',
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
            'gcMemberLosingPoints' => 'array',
            'gcMemberRollingPoints' => 'array',

            'gcMinBetAmount' => 'array',
            'gcMaxBetAmount' => 'array',
            'gcMaxBetPayout' => 'array',
            'gcMaxPayout' => 'array',
        ];
    }
}
