<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberEnvironment extends Model
{
    use HasFactory;

    protected $primaryKey = 'meNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_environment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mID',
        'meType',
        'meIP',
        'meDeviceID',
        'meOS',
    ];

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'meRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'meUpdateDate';

    const ME_TYPE_REGISTER = 'register';
    const ME_TYPE_LOGIN = 'login';

    public function member()
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }
}
