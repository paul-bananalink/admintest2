<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouletteHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'rhNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roulette_history';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rhNo',
        'mID',
        'rhStartDate',
        'rhEndDate',
        'rhValue',
        'rhStatus',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rhValue' => 'array',
            'rhStartDate' => 'datetime:Y-m-d H:i:s',
            'rhEndDate' => 'datetime:Y-m-d H:i:s',
            'rhStatus' => 'boolean',
        ];
    }
}
