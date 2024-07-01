<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'dNo';
    protected $table = 'domain_web';
    const CREATED_AT = 'dRegDate';
    const UPDATED_AT = 'dUpdateDate';
    protected $fillable = [
        'dDomain',
        'dPartNer',
        'dPartNerName',
        'dCode',
        'dName',
        'dTitle',
        'dNote',
        'dIsMain',
        'dIsRefresh',
        'dRegDate',
        'dUpdateDate'
    ];

    protected function casts(): array
    {
        return [
            'dRegDate' => 'datetime:Y-m-d H:i:s',
            'dUpdateDate' => 'datetime:Y-m-d H:i:s',
            'dIsMain' => 'boolean',
            'dIsRefresh' => 'boolean',
        ];
    }
}
