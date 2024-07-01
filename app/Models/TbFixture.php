<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbFixture extends Model
{
    use HasFactory;

    protected $table = 'tb_fixture';

    public $timestamps = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idx';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'home_team',
        'away_team ',
        'home_score',
        'away_score',
        'home_scores',
        'away_scores',
        'home_idx',
        'away_idx',
        'sports_idx',
        'league_idx',
        'location_idx',
        'location_name',
        'start_date',
        'status',
        'period',

    ];

    // public function location()
    // {
    //     return $this->belongsTo(TbLocation::class, 'location_idx', 'idx');
    // }

    // public function sport()
    // {
    //     return $this->belongsTo(TbSports::class, 'sports_idx', 'idx');
    // }
}
