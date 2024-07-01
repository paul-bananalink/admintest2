<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notice';

    const RULE_TYPE = 'rule';

    const EVENT_TYPE = 'event';

    const PARTNER_TYPE = 'partner';

    const VOTE_TYPE = 'vote';

    // public static $categories_notice =[

    // ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ntNo',
        'ntType',
        'ntCategory',
        'ntTitle',
        'ntContent',
        'ntStatus',
        'ntLogo',
        'ntImage',
        'ntPartnerType',
        'ntRegDate',
        'ntUpdateDate'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ntNo';

    const CREATED_AT = 'ntRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'ntUpdateDate';

    public function notice_member()
    {
        return $this->hasMany(NoticeMember::class, 'ntNo', 'ntNo');
    }

    public function config()
    {
        return $this->hasOne(NoticeConfig::class, 'ntNo', 'ntNo');
    }
}
