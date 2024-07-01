<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Cash extends Model
{
    use HasFactory;

    protected $table = 'cash';

    public $timestamps = false;

    const CREATED_AT = 'cRegDate';
    const UPDATED_AT = null;

    public const MONEY_INFO_TABLE_HISTORY = 'money_info_history';

    public const TRANSACTION_TABLE = 'transaction';

    public const M_MONEY = 'mMoney';

    public const M_SPORT_MONEY = 'mSportsMoney';

    protected $primaryKey = 'cNo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cNo',
        'cID',
        'cTable',
        'mMoney',
        'mSportsMoney',
        'cRegDate',
        'cAmount',
        'mID',
    ];


    protected static function boot()
    {
        parent::boot();

        static::resolveRelationUsing('item', function ($cash) {
            switch ($cash->cTable) {
                case self::TRANSACTION_TABLE:
                    return $cash->hasOne(Transaction::class, 'uuid', 'cID')->with('member.partner');
                case self::MONEY_INFO_TABLE_HISTORY:
                    return $cash->hasOne(MoneyInfoHistory::class, 'mihNo', 'cID')->with('member.partner');
                default:
                    return null;
            }
        });
    }

    public function money_info_history()
    {
        return $this->hasOne(MoneyInfoHistory::class, 'mihNo', 'cID');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'uuid', 'cID');
    }

    public function member()
    {
        return $this->belongs(Member::class, 'mID', 'mID');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'mMoney' => 'float',
            'mSportsMoney' => 'float',
        ];
    }

    public function getMessageAttribute()
    {
        if ($this->cTable == self::TRANSACTION_TABLE) {
            $dataAction = 'data-action="' . route('admin.ajax-get-transaction-detail', ['uuid' => $this->item->uuid]) . '"';;

            if ($this->item->tType == 'Bet') {
                //Betting
                $message = '<span ' . $dataAction . ' data-modal="modal_transaction_detail" class="text-green-5 modal-transaction-detail"> ' . '[배팅]' . $this->item->gName . '/' . formatNumber($this->item->tAmount) . '원 배팅' . '/ 고유코드 ' . $this->item->uuid . ' </span>';
            } elseif ($this->item->tType == 'Deduct') {
                //Deduct
                $message = '<span ' . $dataAction . ' data-modal="modal_transaction_detail" class="text-pink-1 modal-transaction-detail"> ' . '[상한공제]' . $this->item->gName . '/' . formatNumber($this->item->tAmount) . '원 배팅' . '/ 고유코드 ' . $this->item->uuid . ' </span>';
            } else {
                //Winning
                $message = '<span ' . $dataAction . ' data-modal="modal_transaction_detail" class="text-yellow modal-transaction-detail"> ' . '[당첨][' . $this->item->gName . ']/고유코드 ' .  '[' . $this->item->uuid . '][적중금액: ' . formatNumber($this->item->tAmount) . ']' . ' </span>';
            }
        } else {
            $description = $this->item->money_info->miDescription ? $this->item->money_info->miDescription . ' / ' : '';
            $message = '';
            $status = $this->item->getRawOriginal('mihStatus');

            if ($status == MoneyInfoHistory::STATUS_NINE) {
                if (in_array($this->item->miType, MoneyInfo::MI_TYPE_FILTER[MoneyInfo::RECHARGE])) {
                    //Recharge
                    $message = '<span class="text-blue-6 "> ' . '[카지노입금]/ ' . $description . formatNumber($this->item->miBankMoney) . $this->item->miStatus . '/ 고유코드' . $this->cID . ' </span>';
                } else {
                    //Withdraw
                    $message =  '<span class="red"> ' . '[카지노출금]' . $description . formatNumber($this->item->miBankMoney) . $this->item->miStatus . '/고유코드 ' .  '[' . $this->cID . ']' . ' </span>';
                }
            } else if ($status == MoneyInfoHistory::STATUS_TWO) {
                $message =  '<span class="warning"> ' . '[카지노환수]' . $description . formatNumber($this->item->miBankMoney) . $this->item->miStatus . '/고유코드 ' .  '[' . $this->cID . ']' . ' </span>';
            }
        }

        return $message;
    }

    public function getAmountAttribute()
    {
        if ($this->cTable == self::TRANSACTION_TABLE) return $this->item->tAmount;

        if ($this->item->getRawOriginal('miStatus') == 2) {
            return $this->item->miBankMoney * (-1);
        }

        return $this->item->miBankMoney;
    }

    public function getTypeAttribute(): string
    {
        if ($this->cTable == self::TRANSACTION_TABLE) {
            return Transaction::TYPES[$this->item->tType] ?? '';
        }

        return MoneyInfoHistory::MI_TYPE[$this->item->miType] ?? '';
    }
}
