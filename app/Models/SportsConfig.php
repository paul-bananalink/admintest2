<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportsConfig extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'scNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sports_config';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'scBlockBet',
        'scNoticeBlockBet',
        'scTimeBet',
        'scDuplicateBetCount',
        'scMaxBetFolderCount',
        'scIsUseBonusAllFolder',
        'scValueUseBonusAllFolder',
        'sc3FolderBonusOdds',
        'sc6FolderBonusOdds',
        'sc9FolderBonusOdds',
        'scCancelBet',
        'scMaxCancelSingleBet',
        'scSecondCancelAfterBet',
        'scMinusCancelAfterBet',
        'scAutoCancelBet',
        'scExitBet',
        'scFootballWinDrawLossOU',
        'scFootballWinLossOU',
        'scFootballHandicapOU',
        'scFootballDrawOU',
        'scBasketballWinLossOU',
        'scBasketballHandicapOU',
        'scBaseballWinLossOU',
        'scBaseballHandicapOU',
        'scVolleyballWinLossOU',
        'scVolleyballHandicapOU',
        'scHockeyWinDrawLossOU',
        'scHockeyWinLossOU',
        'scHockeyHandicapOU',
        'scHockeyDrawOU',
        'scVisibilityOfMainOdds',
        'scBasketballCrossExposure',
        'scBaseballCrossExposure',
        'scFilterCountOptionDistribution',
        'scSoccerFeed',
        'scBasketballFeed',
        'scBaseballFeed',
        'scVolleyballFeed',
        'scIceHockeyFeed',
        'scHandballFeed',
        'scTenisFeed',
        'scAmericanFootballFeed',
        'scEsportsFeed',
        'scPingPongFeed',
        'scBoxingFeed',
        'scMemberLosingPoints',
        'scMemberRollingPoints',
        'scMaxBetAmount',
        'scMaxBetWinAmount',
        'scMinBetAmount1',
        'scMinBetAmount2',
        'scMinBetAmount3',
        'scMaxBetAmount1',
        'scMaxBetAmount2',
        'scMaxBetAmount3',
        'scMaxBetPayout1',
        'scMaxBetPayout2',
        'scMaxBetPayout3',
        'scUserAllocationByLevel',
        'scMaxPayout'
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
            'scMemberLosingPoints' => 'array',
            'scMemberRollingPoints' => 'array',
            'scMaxBetAmount' => 'array',
            'scMaxBetWinAmount' => 'array',
            'scMinBetAmount1' => 'array',
            'scMinBetAmount2' => 'array',
            'scMinBetAmount3' => 'array',
            'scMaxBetAmount1' => 'array',
            'scMaxBetAmount2' => 'array',
            'scMaxBetAmount3' => 'array',
            'scMaxBetPayout1' => 'array',
            'scMaxBetPayout2' => 'array',
            'scMaxBetPayout3' => 'array',
            'scUserAllocationByLevel' => 'array',
            'scMaxPayout' => 'array',
        ];
    }
}
