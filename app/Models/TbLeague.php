<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbLeague extends Model
{
    use HasFactory;

    protected $table = 'tb_league';

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
        'mark',
        'name',
        'season',
        'sports_idx',
        'location_idx',
        'family',
        'sort1',
        'show',
    ];

    public function location()
    {
        return $this->belongsTo(TbLocation::class, 'location_idx', 'idx');
    }
}
