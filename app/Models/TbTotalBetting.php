<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbTotalBetting extends Model
{
    use HasFactory;

    protected $table = 'tb_total_betting';

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
        'betid',
        'sports_kind',
        'parent_idx',
        'game_type',
        'game_no',
        'GameSelect',
        'rate1',
        'rate2',
        'rate3',
        'select_rate',
        'select_line',
        'select_score',
        'result'
    ];

    public function cart()
    {
        return $this->belongsTo(TbTotalCart::class, 'game_no', 'game_no');
    }

    public function parent(){
        return $this->belongsTo(TbParent::class, 'parent_idx', 'idx');
    }
}
