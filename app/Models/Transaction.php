<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use ParagonIE\Sodium\Core\Curve25519\H;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'tRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'tUpdateDate';

    const tTYPE_BET = 'Bet';
    const tTYPE_WIN = 'Win';

    const tTYPE_DEDUCT = 'Deduct';
    const tTYPE_CLOSE = 'Close';
    const tTYPE_CANCEL_BET = 'CancelBet';
    const tTYPE_CANCEL_WIN = 'CancelWin';
    const tTYPE_CANCEL_OTHER = 'Other';

    const TYPE_DEDUCT = 'Deduct';

    const TYPES = [
        self::tTYPE_BET => '배팅',
        self::tTYPE_CANCEL_BET => '배팅취소',
        self::tTYPE_WIN => '당첨',
        self::tTYPE_DEDUCT => '상한공제',
    ];

    protected $table = 'transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'mID',
        'pCode',
        'gCode',
        'gName',
        'gNameEn',
        'gCategory',
        'tRoundId',
        'tType',
        'tAmount',
        'tReferenceUuid',
        'tRoundStarted',
        'tRoundFinished',
        'tDetails',
        'tRegDate',
        'tUpdateDate'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tAmount' => 'float',
            'tRegDate' => 'datetime:Y-m-d H:i:s',
            'tUpdateDate' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function setTAmountAttribute($value)
    {
        $this->attributes['tAmount'] = $value ?? 0;
    }

    public function convertResult(): array
    {
        $tAmount = '- ' . formatNumber($this->tAmount);
        $tType = $this->tType == self::tTYPE_BET ? '배팅' : $this->tType;

        if ($this->tType === self::tTYPE_WIN) { // Win
            $tType = '승';
            $tAmount = '+ ' . formatNumber($this->tAmount);

            if ($this->tAmount < $this->getBetAmount()) { // Close
                $tAmount = '+ ' . formatNumber($this->tAmount);
            }
        }

        return [
            'tAmount' => $tAmount,
            'tType' => $tType
        ];
    }

    public function record_casino_and_slot_win(): HasMany
    {
        return $this->hasMany(static::class, 'tRoundId', 'tRoundId')->where('tType', self::tTYPE_WIN);
    }

    public function calcAmountCasinoAndSlotWin(): float
    {
        return $this->record_casino_and_slot_win->sum('tAmount');
    }

    public function getBetAmount(): float
    {
        $res = $this->where('tRoundId', $this->tRoundId)
            ->where('tType', self::tTYPE_BET)
            ->where('tRoundStarted', 1)
            ->first();

        return $res ? $res->tAmount : 0;
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'mID', 'mID');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'gCode', 'gCode');
    }

    public function game_provider(): HasOne
    {
        return $this->hasOne(GameProvider::class, 'gpCode', 'pCode');
    }

    public function point_history(): BelongsTo
    {
        return $this->belongsTo(PointHistory::class, 'phID', 'uuid')->where('phTable', 'transaction');
    }
}
