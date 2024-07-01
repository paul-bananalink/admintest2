<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeMember extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notice_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nmNo',
        'mID',
        'ntNo',
        'nmRead',
        'nmRegDate',
        'nmUpdateDate'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'nmNo';

    const CREATED_AT = 'nmRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'nmUpdateDate';

    public function notice()
    {
        return $this->belongsTo(Notice::class, 'ntNo', 'ntNo');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }
}
