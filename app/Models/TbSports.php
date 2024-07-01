<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbSports extends Model
{
    use HasFactory;

    protected $table = 'tb_sports';

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
        'sports_name',
        'sports_name_en',
        'mark',
        'sports_type',
        'sort'
    ];
}
