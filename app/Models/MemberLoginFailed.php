<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLoginFailed extends Model
{
    use HasFactory;

    protected $table = 'member_login_failed';

    protected $primaryKey = 'mlfNo';
    public $timestamps = false;

    protected $fillable = [
        'mID', 'mlfIP', 'mlfOS', 'mlfRegDate', 'mlfReason'
    ];
    public function member()
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }
}
