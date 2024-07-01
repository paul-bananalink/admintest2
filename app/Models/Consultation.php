<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Consultation extends Model
{
    use HasFactory;

    const STATUS_RECEIVED = 1;

    const STATUS_REPLIED = 2;

    const TYPE_ENTER_TEXT = 1;

    const TYPE_AUTO_SEND = 2;

    const SEARCH_TYPE_IS_REPLIED = 2;

    const SEARCH_TYPE_NO_REPLIED = 1;

    public const STATUS = [
        self::STATUS_RECEIVED => '접수',
        self::STATUS_REPLIED => '답변',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consultations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type', // 1: Enter text, 2: Auto send
        'title',
        'content',
        'content_reply',
        'mNo',
        'mNo_receive',
        'status',
        'date_feedback',
        'views',
        'show_ui',
    ];

    public function get_name_receive(): string
    {
        return $this->mNo_receive ? $this->member_receive->mID : '';
    }

    public function member_receive(): HasOne
    {
        return $this->hasOne(Member::class, 'mNo', 'mNo_receive');
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'mNo', 'mNo');
    }

    public function get_status(): string
    {
        return self::STATUS[$this->status];
    }

    public function getHtmlReplied()
    {
        return $this->content_reply ? '<div class="content-td mt-12">' . $this->content_reply . '</div>' : '';
    }
}
