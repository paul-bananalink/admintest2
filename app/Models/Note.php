<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Note extends Model
{
    use HasFactory;

    const TYPE_ALL_USER = 1;

    const TYPE_ONLY_USER = 2;

    const TYPE_SEND_LIST_USER = 4;

    const TYPE_SEND_USER_LEVEL = 5;

    const TYPE_SEND_PARTNER = 6;

    protected static $types = [
        self::TYPE_ONLY_USER => '아이디',
        self::TYPE_ALL_USER => '전체발송',
        self::TYPE_SEND_LIST_USER => '개인발송',
        self::TYPE_SEND_USER_LEVEL => '레벨발송',
        self::TYPE_SEND_PARTNER => '파트너발송',
    ];

    public static $categories_send = [
        self::TYPE_ALL_USER => '전체발송',
        self::TYPE_SEND_LIST_USER => '개인발송',
        self::TYPE_SEND_USER_LEVEL => '레벨발송',
        self::TYPE_SEND_PARTNER => '파트너발송',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'mNo',
        'title',
        'content',
        'type',
        'mNo_receive',
        'mNo_receive_list',
        'is_read',
        'date_read',
        'status',
        'show_ui',
        'noticed',
        'deleted_by_list',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public static function getTypes()
    {
        return self::$types;
    }

    public function get_name_receive(): string
    {
        return self::$categories_send[$this->type] ?? '';
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'mNo', 'mNo_receive');
    }

    public function isRead()
    {
        if ($this->type == self::TYPE_ONLY_USER) {
            return $this->is_read ? 1 : 0;
        } else {
            return $this->getStatusIsReadTypeAll();
        }
    }

    private function getStatusIsReadTypeAll()
    {
        $listMember = json_decode($this->mNo_receive_list, true);

        if ($listMember === null) {
            return 0;
        }

        if (in_array(0, $listMember)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function get_members()
    {
        if (!$this->mNo_receive_list) return null;

        $keys = array_keys(json_decode($this->mNo_receive_list, true));

        return Member::select('mID')->whereIn('mNo', $keys)->get();
    }

    public function labelMemberID(): string
    {
        if ($this->type == self::TYPE_ONLY_USER) {
            return "[ ' " . $this->member->mID . " ' ]";
        } elseif ($this->type == self::TYPE_ALL_USER) {
            return "전체발송";
        } elseif ($this->type == self::TYPE_SEND_USER_LEVEL) {
            return "레벨발송";
        } elseif ($this->type == self::TYPE_SEND_PARTNER) {
            return "파트너발송";
        } else {
            $members = $this->get_members();
            if (!$members) {
                return '';
            }
            return "[ ' " . $members->map(function ($member) {
                return (string) data_get($member, 'mID');
            })->implode(" ', ' ") . " ' ]";
        }
    }
}
