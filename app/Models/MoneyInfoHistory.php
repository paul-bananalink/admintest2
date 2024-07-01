<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MoneyInfoHistory extends Model
{
    use HasFactory;

    const TYPE_UD = 'UD'; //User recharge

    const TYPE_UW = 'UW'; //Currency exchange

    const TYPE_AD = 'AD'; //Admin recharge

    const TYPE_AW = 'AW'; //Admin currency exchange

    const MI_TYPE = ['UD' => '유저충전', 'UW' => '유저환전', 'AD' => '관리자충전', 'AW' => '관리자환전'];

    const STATUS_ONE = 1; //waitting

    const STATUS_TWO = 2; //reject order

    const STATUS_THREE = 3; //deleted order

    const STATUS_NINE = 9; //Approval completed

    const MIH_STATUS = [1 => '접수', 2 => '대기', 9 => '승인완료'];

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'mihRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'mihProcessDate';

    protected $table = 'money_info_history';

    protected $appends = ['miAdminType'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mihNo';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'miNo',
        'mID',
        'mihStatus',
        'miType',
        'mihRegDate',
        'mihProcessDate',
        'miProcess_miID',
        'miBankName',
        'miBankNumber',
        'miBankOwner',
        'miBankMoney',
        'miWallet'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }

    public function money_info(): BelongsTo
    {
        return $this->belongsTo(MoneyInfo::class, 'miNo', 'miNo');
    }

    /**
     * Member handle process recharge/withdraw money
     */
    public function process_member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'miProcess_miID', 'mID');
    }

    public function getMihStatusAttribute($value): string
    {
        return self::MIH_STATUS[$value];
    }

    public function getMihTypeAttribute($value): string
    {
        return self::MI_TYPE[$value];
    }

    public function getMiAdminTypeAttribute(): string
    {
        $type = '';

        if (in_array($this->getRawOriginal('miType'), [self::TYPE_UD, self::TYPE_UW])) {
            $type = 'User';
        }

        if (in_array($this->getRawOriginal('miType'), [self::TYPE_AD, self::TYPE_AW])) {
            $type = 'Admin';
        }

        return $type;
    }
}
