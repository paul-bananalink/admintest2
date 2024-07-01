<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Type\Decimal;

class Partner extends Model
{
    use HasFactory;

    const PROFIT_SHARE = 'profit_share';
    const PROFIT_BET = 'profit_bet';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partners';

    public $primaryKey = 'pNo';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'pRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'pUpdateDate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pNo',
        'mID',
        'pType',
        'pName',
        'pCommissions',
        'pProfitType',
        'pNote',
        'pIsCoupon',
        'pIsAutoPayRoulette',
        'pRegDate',
        'pUpdateDate',
        'pIsSubRateConfig'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pCommissions' => 'float',
            'pRegDate' => 'datetime:Y-m-d H:i:s',
            'pUpdateDate' => 'datetime:Y-m-d H:i:s',
            'pIsSubRateConfig' => 'boolean'
        ];
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'mID', 'mID');
    }

    public function total_children(): int
    {
        if (!$this->member) return 0;

        return $this->member->children->count();
    }

    public function total_money()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->mMoney + $child->mSportsMoney;
        });
    }

    public function total_point()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->mPoint;
        });
    }

    public function sum_recharge()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->sumDeposit;
        });
    }

    public function count_recharge()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->countDeposit;
        });
    }

    public function sum_withdraw()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->sumWithdraw;
        });
    }

    public function count_withdraw()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->countWithdraw;
        });
    }

    public function sum_revenue()
    {
        return $this->sum_recharge() - abs($this->sum_withdraw());
    }

    public function sum_bet()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->sumBet;
        });
    }

    public function count_bet()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->countBet;
        });
    }

    public function sum_win()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->sumWin;
        });
    }

    public function count_win()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->countWin;
        });
    }

    public function sum_bet_casino()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->sumBetCasino;
        });
    }

    public function count_bet_casino()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->countBetCasino;
        });
    }

    public function sum_win_casino()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->sumWinCasino;
        });
    }

    public function count_win_casino()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->countWinCasino;
        });
    }

    public function sum_bet_slot()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->sumBetSlot;
        });
    }

    public function count_bet_slot()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->countBetSlot;
        });
    }

    public function sum_win_slot()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->sumWinSlot;
        });
    }

    public function count_win_slot()
    {
        if (!$this->member) return 0;

        return $this->member->children->sum(function ($child) {
            return $child->countWinSlot;
        });
    }

    public function total_commissions()
    {
        $total = 0;

        if ($this->pProfitType == self::PROFIT_SHARE) {
            $total = $this->sum_recharge() - abs($this->sum_withdraw());
        }

        if ($this->pProfitType == self::PROFIT_BET) {
            $total = $this->sum_bet();
        }

        return $total * $this->pCommissions / 100;
    }

    public function getDistributors(): Collection
    {
        $distributors = self::where('pType', 'distributor')
            ->whereHas('member', function ($query) {
                $query->where('mMemberID', $this->mID);
            })
            ->get();

        if ($distributors) {
            foreach ($distributors as $item) {
                /** @var self $item */
                $item->childs = $item->getAgency();
            }
        }

        return $distributors;
    }

    public function getAgency(): Collection
    {
        return self::where('pType', 'agency')
            ->whereHas('member', function ($query) {
                $query->where('mMemberID', $this->mID);
            })
            ->get();
    }
}
