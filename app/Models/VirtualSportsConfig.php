<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualSportsConfig extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'vcNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'virtual_sports_config';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vcVisibilityAllStatus',
        'vcBlockBet',
        'vcNoticeBlockBet',
        'vcTimeBet',
        'vcDuplicateBetCount',
        'vcMaxBetFolderCount',

        'vcMemberLosingPoints',
        'vcMemberRollingPoints',

        'vcMinBetAmount1',
        'vcMinBetAmount2',
        'vcMinBetAmount3',
        'vcMaxBetAmount1',
        'vcMaxBetAmount2',
        'vcMaxBetAmount3',
        'vcMaxBetPayout1',
        'vcMaxBetPayout2',
        'vcMaxBetPayout3',
        'vcUserAllocationByLevel',
        'vcMaxPayout'
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
            'vcMemberLosingPoints' => 'array',
            'vcMemberRollingPoints' => 'array',

            'vcMinBetAmount1' => 'array',
            'vcMinBetAmount2' => 'array',
            'vcMinBetAmount3' => 'array',

            'vcMaxBetAmount1' => 'array',
            'vcMaxBetAmount2' => 'array',
            'vcMaxBetAmount3' => 'array',

            'vcMaxBetPayout1' => 'array',
            'vcMaxBetPayout2' => 'array',
            'vcMaxBetPayout3' => 'array',

            'vcUserAllocationByLevel' => 'array',
            'vcMaxPayout' => 'array',
        ];
    }
}
