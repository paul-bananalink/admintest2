<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeConfig extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notice_config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ncNo',
        'ntNo',
        'ncAvailableOfComments',
        'ncNumberOfPollItems',
        'ncPollDurationHour',
        'ncVotingMemberLevel',
        'ncEnableMultipleSelection',
        'ncEnablePollCancel',
        'ncDivideByItem',
        'ncItem1',
        'ncValue1',
        'ncItem2',
        'ncValue2',
        'ncItem3',
        'ncValue3',
        'ncItem4',
        'ncValue4',
        'ncItem5',
        'ncValue5',
        'ncRegDate',
        'ncUpdateDate',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ncAvailableOfComments' => 'array',
            'ncEnableMultipleSelection' => 'boolean',
            'ncEnablePollCancel' => 'boolean',
        ];
    }

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ncNo';

    const CREATED_AT = 'ncRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'ncUpdateDate';

    public function notice()
    {
        return $this->belongsTo(Notice::class, 'ntNo', 'ntNo');
    }
}
