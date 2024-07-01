<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    use HasFactory;

    protected $table = 'blacklist';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'blNo';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'blRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'blUpdateDate';

    public function member()
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }
}
