<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinigameCategory extends Model
{
    use HasFactory;

    protected $table = 'minigame_category';

    const CREATED_AT = 'mgcRegDate';
    const UPDATED_AT = 'mgcUpdateDate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mgcNo',
        'mgcName',
        'mgcNameEn',
        'mgcRegDate',
        'mgcUpdateDate',
    ];

}
