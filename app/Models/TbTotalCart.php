<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbTotalCart extends Model
{
    use HasFactory;

    protected $table = 'tb_total_cart';

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
        'mem_idx',
        'game_no',
        'regdate',
        'result',
        'betting_cnt',
        'betting_money',
        'result_rate',
        'result_money',
        'visible',
        'bettingIP',
        'confirmBetting',
        'reason',
        'isCanceled',
        'sports_type',
        'printed',
        'game_type'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'mem_idx', 'mNo');
    }

    public function bets()
    {
        return $this->hasMany(TbTotalBetting::class, 'game_no', 'game_no');
    }
}
