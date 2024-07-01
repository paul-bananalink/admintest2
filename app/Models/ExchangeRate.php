<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;

    protected $table = 'exchange_rate';

    protected $fillable = [
        'rSoccer',
        'rBasketball',
        'rBaseball',
        'rVolleyball',
        'rIce_hockey',
        'rTable_tennis',
        'rHandball',
        'rTennis',
        'rAmerican_football',
        'rEsports',
        'rBoxing'
    ];
}
