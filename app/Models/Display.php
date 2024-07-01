<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Display extends Model
{
    use HasFactory;

    const CREATED_AT = 'dpRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'dpUpdateDate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dpNo',
        'dpTable',
        'dpData'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'dpNo';

    protected $table = 'display';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dpData' => 'array',
        ];
    }
}
