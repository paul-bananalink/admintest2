<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MoneyInfo extends Model
{
    use HasFactory;

    const TYPE_UD = 'UD'; //User recharge

    const TYPE_UW = 'UW'; //Currency exchange

    const TYPE_AD = 'AD'; //Admin recharge

    const TYPE_AW = 'AW'; //Admin currency exchange

    const TYPE_EM = 'EM'; //Exchange money

    const RECHARGE = 'recharge';

    const WITHDRAW = 'withdraw';

    const EXCHANGE = 'exchange';

    const MI_TYPE = [
        self::TYPE_UD => '유저충전',
        self::TYPE_UW => '유저환전',
        self::TYPE_AD => '관리자충전',
        self::TYPE_AW => '관리자환전',
        self::TYPE_EM => '머니이동',
    ];

    const MI_TYPE_FILTER = [
        'withdraw' => [
            self::TYPE_UW,
            self::TYPE_AW,
        ],
        'recharge' => [
            self::TYPE_UD,
            self::TYPE_AD,
        ],
        'exchange' => [
            self::TYPE_EM,
        ],
    ];

    const TYPE_WALLET_SPORTS = 'sports';

    const TYPE_WALLET_CASINO = 'casino_slot';

    const TYPE_WALLET_POINT = 'point';

    const MI_WALLET_TYPE = [
        self::TYPE_WALLET_SPORTS => '스포츠',
        self::TYPE_WALLET_CASINO => '카지노',
        self::TYPE_WALLET_POINT => '포인트',
    ];

    const TYPE_BONUS = 'bonus';

    const TYPE_NO_BONUS = 'no_bonus';

    const MI_BONUS_TYPE = [
        self::TYPE_BONUS,
        self::TYPE_NO_BONUS,
    ];

    const STATUS_ONE = 1; //waitting

    const STATUS_TWO = 2; //reject order

    const STATUS_THREE = 3; //deleted order

    const STATUS_NINE = 9; //Approval completed

    const MI_STATUS = [
        1 => '대기',
        2 => '취소',
        3 => '취소처리',
        9 => '승인완료',
    ];

    const MI_STATUS_FILTER = [
        'requested' => 1,
        'rollback' => 2,
        'cancelled' => 3,
        'approved' => 9,
    ];

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'miRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = null;

    protected $table = 'money_info';

    protected $appends = ['miAdminType', 'miAdminStatus'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'miNo';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'miNo',
        'mID',
        'miType',
        'miStatus',
        'miBankName',
        'miBankNumber',
        'miBankOwner',
        'miBankMoney',
        'mProcessDate',
        'miProcess_miID',
        'miWallet',
        'miDescription',
        'miBonusPercent',
        'miBetPercent',
        'miMaxBonusRecharge',
        'miBonuses',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'miBonuses' => 'array',
            'miBankMoney' => 'float',
            'miRegDate' => 'datetime:Y-m-d H:i:s',
            'mProcessDate' => 'datetime:Y-m-d H:i:s',
        ];
    }

    /**
     * Member recharge/withdraw money
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mID', 'mID');
    }

    /**
     * Member handle process recharge/withdraw money
     */
    public function process_member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'miProcess_miID', 'mID');
    }

    public function money_info_histories(): HasMany
    {
        return $this->hasMany(MoneyInfoHistory::class, 'miNo', 'miNo');
    }

    public function point_history(): BelongsTo
    {
        return $this->belongsTo(PointHistory::class, 'miNo', 'phID');
    }

    public function miStatus(): Attribute
    {
        return Attribute::make(
            fn ($value) => self::MI_STATUS[$value]
        );
    }

    public function getMihTypeAttribute($value): string
    {
        return self::MI_TYPE[$value];
    }

    public function getMiAdminStatusAttribute(): string
    {
        return self::MI_STATUS[$this->getRawOriginal('miStatus')];
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

    public function getType(): string
    {
        $miType = $this->getRawOriginal('miType');

        foreach (static::MI_TYPE_FILTER as $key => $item) {
            if (in_array($miType, $item)) {
                return $key;
            }
        }

        return '';
    }

    public function getBonusTextAttribute(): string
    {
        $wallet = MoneyInfo::MI_WALLET_TYPE[$this->miWallet];
        $char = $this->isFirstRecharge ? '첫' : '매';
        $miBonusPercent = data_get($this, 'miBonusPercent', 0);
        $miBankMoney = data_get($this, 'miBankMoney', 0);
        $bonusMoney = data_get($this, 'bonusMoney', 0);

        return '[' . $wallet . ' - ' . $char . ' 입금보너스](' . formatNumber($miBankMoney) . ' X ' . $miBonusPercent . '%) = ' . formatNumber($bonusMoney) . '원 지급완료';
    }
}
