<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minigame extends Model
{
    use HasFactory;

    protected $table = 'minigame';

    const CREATED_AT = 'mgRegDate';
    const UPDATED_AT = 'mgUpdateDate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mgNo',
        'mgName',
        'mgNameEn',
        'mgType',
        'mgOrder',
        'mgcNo',
        'mgRegDate',
        'mgUpdateDate',
    ];

    public function minigameResults()
    {
        return $this->hasMany(MinigameResult::class, 'mgNo', 'mgNo');
    }
}
