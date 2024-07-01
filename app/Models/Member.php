<?php

namespace App\Models;

use App\Observers\MemberObserver;
use Illuminate\Contracts\Auth\Authenticatable as ContractsAuth;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

#[ObservedBy([MemberObserver::class])]
class Member extends Authenticatable implements UserProvider
{
    use HasApiTokens, HasFactory, Notifiable;

    const M_LEVEL_ADMIN_MA = 'MA'; // Role Master Admin

    const M_LEVEL_ADMIN_AD = 'AD'; // Role Admin

    const M_LEVEL_MEMBER = '1'; // Role Member

    const M_BET_LEVEL_1_AND_2 = ['1', '2']; // Bet level 1 and 2

    protected $appends = ['sum_deposit', 'count_deposit', 'sum_withdraw', 'count_withdraw', 'sum_bet', 'count_bet', 'total_profit'];

    /**
     * Roles access login to page admin
     */
    const M_LEVEL_TO_LOGIN_ADMIN_PAGE = [
        'MA',
        'AD',
    ];

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'mRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'mModifyDateTime';

    const M_STATUS_TEST = 10; // Test

    const M_STATUS_NINE = 9; // Normal

    const M_STATUS_EIGHT = 8; // Stop

    const M_STATUS_SEVEN = 7; // Member in Black list

    const M_STATUS_THREE = 3; // lock by wrong password

    const M_STATUS_TWO = 2; // Stop by admin

    const M_STATUS_ONE = 1; // Pending

    const PARTNER = 1;


    const COUNT_MAX_PASS_WRONG = 4; // Count max input password error

    const COUNT_DEFAULT_PASS_WRONG = 0; // Count default password

    const STATUS_MEMBER_TO_STRING = [
        self::M_STATUS_NINE => '정상',
        self::M_STATUS_EIGHT => '정지',
        self::M_STATUS_SEVEN => '주의회원',
        self::M_STATUS_THREE => '비번오류차단',
        self::M_STATUS_TWO => '관리자경유',
        self::M_STATUS_ONE => '대기',
        self::M_STATUS_TEST => '테스트 계정'
    ];

    const LEVEL_MEMBER_TO_STRING = [
        self::M_LEVEL_ADMIN_MA => '마스터 관리자',
        self::M_LEVEL_ADMIN_AD => '관리자',
        self::M_LEVEL_MEMBER => '사용자',
    ];

    const WALLET_CASINO_SLOT = 'casino_slot'; // Wallet for casino slot games

    const WALLET_SPORTS = 'sports'; // Wallet for sports betting

    const WALLET_POINT = 'point'; // Wallet for point

    const MEMBER_WALLETS = [
        'casino_slot' => 'mMoney',
        'sports' => 'mSportsMoney',
        'point' => 'mPoint',
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member';

    /**
     * The column name of the password field using during authentication.
     *
     * @var string
     */
    protected $authPasswordName = 'mPW';

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    // protected $rememberTokenName = 'remember_token';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mID',
        'mNick',
        'mPW',
        'mRealName',
        'mLevel',
        'mStatus',
        'mMemberID',
        'mBankOwner',
        'mBankName',
        'mBankNumber',
        'mPhone',
        'mWrongPWCount',
        'mBankExchangePW',
        'mLoginDateTime',
        'mMoney',
        'mSportsMoney',
        'mBanProviders',
        'mBanGames',
        'mNote',
        'mApproveRegDate',
        'mSportsMoney',
        'mPosition',
        'mIsFirstLogin',
        'mPoint',
        'mPhoneCom',
        'mConsultBankName',
        'mConsultBankNameCom',
        'mConsultBankAccount',
        'mConsultBankAccountCom',
        'mIsPartner',
        'mPartnerCode',
        'mRoulette',
        'mPartnerName',
        'mPartnerPosition'
    ];

    // protected $with = ['member_disallow_ips'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mPW',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'mMoney' => 'decimal:2',
            'mPoint' => 'decimal:2',
            'mPW' => 'hashed',
            'mRegDate' => 'datetime:Y-m-d H:i:s',
            'mLoginDateTime' => 'datetime:Y-m-d H:i:s',
            'mModifyDateTime' => 'datetime:Y-m-d H:i:s',
            'mApproveRegDate' => 'datetime:Y-m-d H:i:s',
            'mBanProviders' => 'array',
            'mBanGames' => 'array',
            'mPhoneCom' => 'hashed'
        ];
    }

    protected $moneyInfos;

    protected $transaction;

    protected $point_history;
    protected $childrenInstance;

    protected $childrenMemberIDs;

    public function getMoneyInfos()
    {
        if (!$this->moneyInfos) {
            $this->moneyInfos = $this->money_infos()->where('miStatus', MoneyInfo::STATUS_NINE)->get();
        }

        return $this->moneyInfos;
    }

    public function getTransactions()
    {
        if (!$this->transaction) {
            $this->transaction = $this->transactions();
        }

        return $this->transaction;
    }

    public function getPointHistories()
    {
        if (!$this->point_history) {
            $this->point_history = $this->point_histories();
        }

        return $this->point_history;
    }

    public function getChildren()
    {
        if (!$this->childrenInstance) {
            $this->childrenInstance = $this->children();
        }

        return $this->childrenInstance;
    }

    public function getAllChildrenMemberID()
    {
        if (!$this->childrenMemberIDs) {
            $mIDs = $this->children->pluck('mID')->toArray();
            foreach ($this->children as $child) {
                $mIDs = array_merge($mIDs, $child->getAllChildrenMemberID());
            }

            $this->childrenMemberIDs = $mIDs;
        }

        return $this->childrenMemberIDs;
    }

    /**
     * Mutators & Casting
     */
    protected function getInfoBankAttribute()
    {
        return "{$this->mBankName}/{$this->mBankOwner}/{$this->mBankNumber}";
    }

    public function getMMoneyAttribute($value)
    {
        return $value ?? 0;
    }

    public function mLevelToString(): string
    {
        return self::LEVEL_MEMBER_TO_STRING[$this->mLevel] ?? '';
    }

    public function sumDeposit(): Attribute
    {
        return Attribute::make(
            fn () => $this->getMoneyInfos()->where('miType', MoneyInfo::TYPE_UD)->sum('miBankMoney')
        );
    }

    public function countDeposit(): Attribute
    {
        return Attribute::make(
            fn () => $this->getMoneyInfos()->where('miType', MoneyInfo::TYPE_UD)->count()
        );
    }

    public function sumWithdraw(): Attribute
    {
        return Attribute::make(
            fn () => $this->getMoneyInfos()->where('miType', MoneyInfo::TYPE_UW)->sum('miBankMoney')
        );
    }

    public function countWithdraw(): Attribute
    {
        return Attribute::make(
            fn () => $this->getMoneyInfos()->where('miType', MoneyInfo::TYPE_UW)->count()
        );
    }

    public function sumBet(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('tType', 'Bet')->sum('tAmount')
        );
    }

    public function countBet(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('tType', 'Bet')->count()
        );
    }

    public function sumWin(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('tType', 'Win')->sum('tAmount')
        );
    }

    public function countWin(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('tType', 'Win')->count()
        );
    }

    public function sumValidBet(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumValidBetCasino + $this->sumValidBetSlot
        );
    }

    public function sumRolling(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumRollingCasino + $this->sumRollingSlot
        );
    }

    public function sumRollingCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->getPointHistories()->where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)->where('phGameType', 'Live Casino')->sum('phPoint')
        );
    }

    public function sumRollingSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->getPointHistories()->where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)->where('phGameType', 'Slot')->sum('phPoint')
        );
    }

    public function sumProfit(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumBet - $this->sumWin - $this->sumRolling
        );
    }

    public function sumBetCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('gCategory', 'Live Casino')->where('tType', 'Bet')->sum('tAmount')
        );
    }

    public function countBetCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('gCategory', 'Live Casino')->where('tType', 'Bet')->count()
        );
    }

    public function sumWinCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('gCategory', 'Live Casino')->where('tType', 'Win')->sum('tAmount')
        );
    }

    public function countWinCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('gCategory', 'Live Casino')->where('tType', 'Win')->count()
        );
    }

    public function sumBetSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('gCategory', 'Slot')->where('tType', 'Bet')->sum('tAmount')
        );
    }

    public function countBetSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('gCategory', 'Slot')->where('tType', 'Bet')->count()
        );
    }

    public function sumWinSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('gCategory', 'Slot')->where('tType', 'Win')->sum('tAmount')
        );
    }

    public function countWinSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('gCategory', 'Slot')->where('tType', 'Win')->count()
        );
    }

    public function sumMoney(): Attribute
    {
        return Attribute::make(
            fn () => $this->mMoney + $this->mSportsMoney
        );
    }

    public function sumPoint(): Attribute
    {
        return Attribute::make(
            fn () => $this->mPoint
        );
    }

    public function sumValidBetCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('tType', 'Bet')
                ->where('gCategory', 'Live Casino')
                ->whereExists(function ($queryExists) {
                    $queryExists->selectRaw(1)
                        ->from('transaction as t2')
                        ->whereColumn('transaction.tRoundId', 't2.tRoundId')
                        ->where('t2.tType', 'Win')
                        ->whereColumn('transaction.tAmount', '<>', 't2.tAmount');
                })
                ->sum('tAmount')
        );
    }

    public function sumValidBetSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('tType', 'Bet')
                ->where('gCategory', 'Slot')
                ->whereExists(function ($queryExists) {
                    $queryExists->selectRaw(1)
                        ->from('transaction as t2')
                        ->whereColumn('transaction.tRoundId', 't2.tRoundId')
                        ->where('t2.tType', 'Win')
                        ->whereColumn('transaction.tAmount', '<>', 't2.tAmount');
                })
                ->sum('tAmount')
        );
    }

    public function sumProfitCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumBetCasino - $this->sumWinCasino - $this->sumRollingCasino
        );
    }

    public function sumProfitSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumBetSlot - $this->sumWinSlot - $this->sumRollingSlot
        );
    }

    public function sumLosing(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumLosingCasino + $this->sumLosingSlot
        );
    }

    public function sumLosingCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumLosingCasino < 0 ? $this->sumLosingCasino * $this->memberConfig->mcLossCasinoRate : 0
        );
    }

    public function sumLosingSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumLosingSlot < 0 ? $this->sumLosingSlot * $this->memberConfig->mcLossSlotRate : 0
        );
    }

    public function sumDeduct(): Attribute
    {
        return Attribute::make(
            fn () => $this->getTransactions()->where('tType', 'Deduct')->sum('tAmount')
        );
    }

    public function sumChildDeposit(): Attribute
    {
        return Attribute::make(
            fn () => MoneyInfo::where('miStatus', MoneyInfo::STATUS_NINE)->where('miType', MoneyInfo::TYPE_UD)->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('miBankMoney')
        );
    }

    public function sumChildWithdraw(): Attribute
    {
        return Attribute::make(
            fn () => MoneyInfo::where('miStatus', MoneyInfo::STATUS_NINE)->where('miType', MoneyInfo::TYPE_UW)->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('miBankMoney')
        );
    }

    public function sumChildBet(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('tType', 'Bet')->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('tAmount')
        );
    }

    public function sumChildWin(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('tType', 'Win')->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('tAmount')
        );
    }

    public function sumChildBetCasino(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('gCategory', 'Live Casino')->where('tType', 'Bet')->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('tAmount')
        );
    }

    public function sumChildWinCasino(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('gCategory', 'Live Casino')->where('tType', 'Win')->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('tAmount')
        );
    }

    public function sumChildBetSlot(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('gCategory', 'Slot')->where('tType', 'Bet')->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('tAmount')
        );
    }

    public function sumChildWinSlot(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('gCategory', 'Slot')->where('tType', 'Win')->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('tAmount')
        );
    }

    public function sumChildMoney(): Attribute
    {
        return Attribute::make(
            fn () => self::whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('mMoney') + self::whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('mSportsMoney')
        );
    }

    public function sumChildPoint(): Attribute
    {
        return Attribute::make(
            fn () => self::whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('mPoint')
        );
    }

    public function sumChildValidBet(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumChildValidBetCasino + $this->sumChildValidBetSlot
        );
    }

    public function sumChildValidBetCasino(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('tType', 'Bet')
                ->where('gCategory', 'Live Casino')
                ->whereExists(function ($queryExists) {
                    $queryExists->selectRaw(1)
                        ->from('transaction as t2')
                        ->whereColumn('transaction.tRoundId', 't2.tRoundId')
                        ->where('t2.tType', 'Win')
                        ->whereColumn('transaction.tAmount', '<>', 't2.tAmount');
                })
                ->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])
                ->sum('tAmount')
        );
    }

    public function sumChildValidBetSlot(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('tType', 'Bet')
                ->where('gCategory', 'Slot')
                ->whereExists(function ($queryExists) {
                    $queryExists->selectRaw(1)
                        ->from('transaction as t2')
                        ->whereColumn('transaction.tRoundId', 't2.tRoundId')
                        ->where('t2.tType', 'Win')
                        ->whereColumn('transaction.tAmount', '<>', 't2.tAmount');
                })
                ->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])
                ->sum('tAmount')
        );
    }

    public function sumChildRolling(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumChildRollingCasino + $this->sumChildRollingSlot
        );
    }

    public function sumChildRollingCasino(): Attribute
    {
        return Attribute::make(
            fn () => PointHistory::where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)
                ->where('phGameType', 'Live Casino')
                ->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])
                ->sum('phPoint')
        );
    }

    public function sumChildRollingSlot(): Attribute
    {
        return Attribute::make(
            fn () => PointHistory::where('phBonusType', BonusConfig::TYPE_ROLLING_BONUS)
                ->where('phGameType', 'Slot')
                ->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])
                ->sum('phPoint')
        );
    }

    public function sumChildProfit(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumChildBet - $this->sumChildWin - $this->sumChildRolling
        );
    }

    public function sumChildProfitCasino(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumChildBetCasino - $this->sumChildWinCasino - $this->sumChildRollingCasino
        );
    }

    public function sumChildProfitSlot(): Attribute
    {
        return Attribute::make(
            fn () => $this->sumChildBetSlot - $this->sumChildWinSlot - $this->sumChildRollingSlot
        );
    }

    public function sumChildDeduct(): Attribute
    {
        return Attribute::make(
            fn () => Transaction::where('tType', 'Deduct')->whereIn('mID', [...$this->getAllChildrenMemberID(), $this->mID])->sum('tAmount')
        );
    }

    /**
     * Handle Token member
     */
    public function retrieveById($identifier)
    {
        return $this->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(ContractsAuth $member, $token)
    {
        // TODO: Implement updateRememberToken() method.
        $member->mLoginDateTime = now();

        $member->save();
    }

    public function retrieveByCredentials(array $credentials)
    {
        return null;
    }

    public function validateCredentials($member, array $credentials)
    {
        $plain = $credentials['password'];

        return $this->hasher->check($plain, $member->getAuthPassword());
    }

    public function rehashPasswordIfRequired($member, array $credentials, bool $force = false)
    {
    }

    /**
     * Relationship with table member_disallow_ip
     */
    public function member_disallow_ips(): HasMany
    {
        return $this->hasMany(MemberDisallowIp::class, 'mID', 'mID');
    }

    /**
     * Relationship with table member_allow_ip
     */
    public function member_allow_ip(): HasMany
    {
        return $this->hasMany(MemberAllowIp::class, 'mID', 'mID');
    }

    /**
     * Relationship with table members_login
     */
    public function members_login(): HasOne
    {
        return $this->hasOne(MembersLogin::class, 'mID', 'mID');
    }

    public function loginFailures()
    {
        return $this->hasMany(MemberLoginFailed::class, 'mID', 'mID');
    }
    public function partner(): BelongsTo
    {
        return $this->belongsTo(self::class, 'mMemberID', 'mID');
    }

    public function notice_member(): HasMany
    {
        return $this->hasMany(NoticeMember::class, 'mID', 'mID');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'mMemberID', 'mID')->with('children');
    }

    public function money_infos(): HasMany
    {
        return $this->hasMany(MoneyInfo::class, 'mID', 'mID');
    }

    public function point_histories(): HasMany
    {
        return $this->hasMany(PointHistory::class, 'mID', 'mID');
    }

    public function getStatusTextAttribute()
    {
        if ($this->memberConfig->mcForceLogout) return 'force_logout';
        if ($this->mStatus == self::M_STATUS_EIGHT) return 'blocked';
        if ($this->memberConfig->mcIsAlbagi) return 'albagi';
        if ($this->mStatus == self::M_STATUS_ONE) return 'pending';

        return 'normal';
    }

    public function getStatusKrTextAttribute()
    {
        return config('constant_view.MEMBER_STATUS.' . $this->getStatusTextAttribute())['kr_text'];
    }

    public function getStatusBadgeTypeAttribute()
    {
        return config('constant_view.MEMBER_STATUS.' . $this->getStatusTextAttribute())['badge_type'];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'mID', 'mID');
    }

    public function tbTotalCarts()
    {
        return $this->hasMany(TbTotalCart::class, 'mem_idx', 'mNo');
    }

    public function memberConfig(): HasOne
    {
        return $this->hasOne(MemberConfig::class, 'mID', 'mID');
    }

    public function memberEnvironment(): HasMany
    {
        return $this->hasMany(MemberEnvironment::class, 'mID', 'mID');
    }

    public function totalMoney()
    {
        return $this->mMoney + $this->mSportsMoney;
    }

    public function totalPoint()
    {
        return $this->mPoint;
    }

    public function totalProfit(): Attribute
    {
        return Attribute::make(
            fn () => $this->sum_deposit - abs($this->sum_withdraw)
        );
    }

    public function loginFailed()
    {
        return $this->hasMany(MemberLoginFailed::class, 'mID', 'mID');
    }

    public function attendances()
    {
        return $this->hasMany(MemberAttendance::class, 'mID', 'mID');
    }

    public function memberRegisterInfo()
    {
        return $this->memberEnvironment()->where('meType', MemberEnvironment::ME_TYPE_REGISTER)->latest()->first();
    }

    public function memberLoginInfo()
    {
        return $this->memberEnvironment()->where('meType', MemberEnvironment::ME_TYPE_LOGIN)->latest()->first();
    }

    public function memberHasRechargedToday()
    {
        return $this->money_infos()->whereDate('mProcessDate', today())->where('miType', MoneyInfo::TYPE_UD)->exists();
    }

    public function memberHasWithdrawnToday()
    {
        return $this->money_infos()->whereDate('mProcessDate', today())->where('miType', MoneyInfo::TYPE_UW)->exists();
    }

    public function memberRechargedCount()
    {
        return $this->money_infos()->whereNotNull('mProcessDate')->where('miType', MoneyInfo::TYPE_UD)->count();
    }

    public function memberLatestRecharge()
    {
        return $this->money_infos()->whereNotNull('mProcessDate')->where('miType', MoneyInfo::TYPE_UD)->latest()->first();
    }

    public function countAllDescendants()
    {
        $count = 0;
        foreach ($this->children as $child) {
            $count += 1 + $child->countAllDescendants();
        }
        return $count;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'mMemberID', 'mID');
    }
}
