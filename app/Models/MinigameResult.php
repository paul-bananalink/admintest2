<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinigameResult extends Model
{
    use HasFactory;

    protected $table = 'minigame_result';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mgrNo';

    const CREATED_AT = 'mgrRegDate';
    const UPDATED_AT = 'mgrUpdateDate';
    const GAME_SUREPOWERBALL = 'surepowerball';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mgrNo',
        'mgrRound',
        'mgrMode',
        'mgrResult',
        'mgNo',
        'mgrRegDate',
        'mgrUpdateDate',
    ];

    protected $casts = [
        'mgrResult' => 'array',
    ];
}
