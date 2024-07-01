<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Newsletter extends Model
{
    use HasFactory;

    const TYPE_EVENT = 1;

    const TYPE_NEWSBOARD = 2;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 0;

    const CATEGORY_NOTICES = 1;

    const CATEGORY_BETTING_RULES = 2;

    const CATEGORY_USAGE_INQUIRIES = 3;

    const CATEGORY_FREQUENTLY_ASKED_QUESTIONS = 4;

    public static $categories_newboard = [
        self::CATEGORY_NOTICES => '공지사항',
        self::CATEGORY_BETTING_RULES => '배팅규정',
        self::CATEGORY_USAGE_INQUIRIES => '이용문의',
        self::CATEGORY_FREQUENTLY_ASKED_QUESTIONS => '자주하는 질문',
    ];

    public const STATUS_SHOW_UI = [
        self::STATUS_ACTIVE => '보이기',
        self::STATUS_INACTIVE => '감추기',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletters';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'type',
        'category',
        'mNo_writer',
        'views',
        'created_date',
        'status',
        'show_ui',
        'noticed', // Json
        'start_date',
        'end_date',
        'banner'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'mNo', 'mNo_writer')->withDefault();
    }

    public function label_category_newsboard(): string
    {
        return self::$categories_newboard[$this->category];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_date' => 'datetime:Y-m-d H:i:s',
            'start_date' => 'datetime:Y-m-d',
            'end_date' => 'datetime:Y-m-d'
        ];
    }
}
