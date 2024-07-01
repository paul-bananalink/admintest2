<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbTeam extends Model
{
    use HasFactory;

    protected $table = 'tb_team';

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
        'kind',
        'sports_idx',
        'location_idx',
        'league_idx',
        'team_name',
        'team_name_kor',
        'team_logo'
    ];

    public function location()
    {
        return $this->belongsTo(TbLocation::class, 'location_idx', 'idx');
    }

    public function sport()
    {
        return $this->belongsTo(TbSports::class, 'sports_idx', 'idx');
    }
}
