<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberDisallowIp extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mdiiNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_disallow_ip';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mID',
        'mdiIp',
        'mdiRegDate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'mdiRegDate' => 'datetime:Y-m-d H:i:s',
        ];
    }

    /**
     * Relationship with table member
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }
}
