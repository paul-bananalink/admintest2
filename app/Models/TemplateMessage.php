<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateMessage extends Model
{
    use HasFactory;

    const TYPE_CONSULTATION = 1;
    const TYPE_NOTE = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'template_message';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'type', // Default 1 - consultation , 2 - note
        'content',
        'status',
    ];
}
