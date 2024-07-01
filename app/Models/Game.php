<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $table = 'game';

    protected $primaryKey = 'gNo';

    public $timestamps = false;

    const NON_CATEGORIZE = 'NON_CATEGORIZE';

    const CASINO_CATEGORY = 'Live Casino';

    const SLOT_CATEGORY = 'Slot';

    const GAME_CATE = [
        'Live Casino',
        'Slot'
    ];

    protected $fillable = [
        'gCode',
        'gName',
        'gpCode',
        'gNameEn',
        'gCategory',
        'gIconUrl',
        'gpCode',
        'gStatus',
        'gPoint',
        'gPlatform',
        'gType',
        'gResponsiveType',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gStatus' => 'boolean',
        ];
    }
}
