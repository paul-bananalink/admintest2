<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasinoConfig extends Model
{
    use HasFactory;

    const TYPE_CASINO = 'casino';
    const TYPE_SLOT = 'slot';

    const TYPES = [
        self::TYPE_CASINO => '카지노',
        self::TYPE_SLOT => '슬롯',
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ccNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'casino_config';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ccType',
        'ccBlockBet',
        'ccNoticeBlockBet',
        'ccMemberLosingPoints',
        'ccMemberRollingPoints',
        'ccMinBetAmount',
        'ccMaxBetPayout',
        'ccUserAllocationByLevel',
        'ccMaxPayout'

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
            'ccMemberLosingPoints' => 'array',
            'ccMemberRollingPoints' => 'array',
            'ccMinBetAmount' => 'array',
            'ccMaxBetPayout' => 'array',
            'ccUserAllocationByLevel' => 'array',
            'ccMaxPayout' => 'array'
        ];
    }
}
