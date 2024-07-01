<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoReply extends Model
{
    use HasFactory;

    const QUICK_TYPE = 1;
    const NORMAL_TYPE = 2;

    protected $primaryKey = 'arNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auto_reply';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'arLink',
        'arLevel',
        'arContent',
        'arType',
    ];

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'arRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'arUpdateDate';
}
