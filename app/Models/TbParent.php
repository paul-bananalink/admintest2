<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbParent extends Model
{
    use HasFactory;

    protected $table = 'tb_parent';

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
        'idx',
        'game_id',
        'sports_name',
        'fixture_idx',
        'sports_idx',
        'league_idx',
        'game_type',
        'game_kind',
        'game_time',
        'play_time',
        'home_team',
        'away_team',
        'home_team_sub',
        'vs_team_sub',
        'away_team_sub',
        'rate1',
        'rate2',
        'rate3',
        'score1',
        'score2',
        'score3',
        'score4',
        'result',
        'isStop',
        'state',
        'money1',
        'money2',
        'money3',
        'auto_rate',
        'auto_result',
        'add_rate1',
        'add_rate2',
        'add_rate3',
        'betid1',
        'betid2',
        'betid3',
        'isMain',
        'main_line',
        'status'
    ];

    public function market()
    {
        return $this->hasOne(TbMarket::class, 'idx', 'game_id');
    }

    public function sport()
    {
        return $this->belongsTo(TbSports::class, 'sports_idx', 'idx');
    }

    public function league()
    {
        return $this->belongsTo(TbLeague::class, 'league_idx', 'idx');
    }
}
