<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberAttendance extends Model
{
    use HasFactory;

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'maRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_attendance';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'maNo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'maNo',
        'mID',
        'maRegDate',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'maRegDate' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }
}
