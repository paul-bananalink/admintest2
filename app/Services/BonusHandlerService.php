<?php

namespace App\Services;

use App\Models\BonusConfig;
use App\Models\Member;
use App\Models\MoneyInfo;
use App\Models\RouletteHistory;
use App\Models\Transaction;
use App\Repositories\BonusConfigRepository;
use App\Repositories\MemberConfigRepository;
use App\Repositories\MemberRepository;
use App\Repositories\MoneyInfoRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\PointHistoryRepository;
use App\Repositories\RouletteHistoryRepository;

class BonusHandlerService extends BaseService
{
    const PAYMENT_METHOD_MONEY = 'money';
    const PAYMENT_METHOD_POINT = 'point';

    private array $paymentMethods = [
        self::PAYMENT_METHOD_MONEY,
        self::PAYMENT_METHOD_POINT,
    ];

    private array $bonusRecharge;
    private array $bonusSignup;
    private array $bonusNewMember;
    private array $bonusPayback;
    private array $bonusRolling;
    private array $bonusLosing;
    private array $bonusParticipate;
    private array $bonusSudden;
    private array $bonusCoupon;

    public function __construct(
        private PointHistoryRepository $pointHistoryRepository,
        private MemberRepository $memberRepository,
        private MoneyInfoRepository $moneyInfoRepository,
        private BonusConfigRepository $bonusConfigRepository,
        private MemberConfigRepository $memberConfigRepository,
        private RouletteHistoryRepository $rouletteHistoryRepository,
        private TransactionRepository $transactionRepository
    ) {
        $this->bonusRecharge = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_RECHARGE_BONUS));
        $this->bonusSignup = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_SIGNUP_BONUS));
        $this->bonusNewMember = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_NEW_MEMBER_BONUS));
        $this->bonusPayback = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_PAYBACK_BONUS));
        $this->bonusRolling = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_ROLLING_BONUS));
        $this->bonusLosing = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_LOSING_BONUS));
        $this->bonusParticipate = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_PARTICIPATE_BONUS));
        $this->bonusSudden = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_SUDDEN_BONUS));
        $this->bonusCoupon = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_COUPON_BONUS));
    }

    public function addBonusMoneyInfo(MoneyInfo $moneyInfo, ?string $bonusType = null, string $paymentMethod = 'point', string $description = 'add point'): bool
    {
        $amount = $moneyInfo->miBankMoney;
        $column = $this->validateParams($paymentMethod, $bonusType);
        $is_add = $this->checkIsAdd($column, $bonusType);

        if ($is_add) {
            if ($paymentMethod == self::PAYMENT_METHOD_MONEY && $moneyInfo->miWallet == MoneyInfo::TYPE_WALLET_SPORTS) {
                return $this->addMoneySportsMoneyInfo($moneyInfo, $amount, $bonusType, $description);
            }
            if ($paymentMethod == self::PAYMENT_METHOD_MONEY && $moneyInfo->miWallet == MoneyInfo::TYPE_WALLET_CASINO) {
                return $this->addMoneyCasinoMoneyInfo($moneyInfo, $amount, $bonusType, $description);
            }
            if ($paymentMethod == self::PAYMENT_METHOD_POINT) {
                return $this->addPointMoneyInfo($moneyInfo, $amount, $bonusType, $description);
            }
        }

        return false;
    }

    public function addBonusTransaction(Transaction $transaction, ?string $bonusType = null, string $paymentMethod = 'point', string $description = 'add point'): bool
    {
        $column = $this->validateParams($paymentMethod, $bonusType);
        $is_add = $this->checkIsAdd($column, $bonusType);

        if ($is_add) {
            // if ($paymentMethod == self::PAYMENT_METHOD_MONEY) {
            //     return $this->addMoneySportsTransaction($transaction, $column, $bonusType, $description);
            // }
            if ($paymentMethod == self::PAYMENT_METHOD_MONEY) {
                return $this->addMoneyCasinoTransaction($transaction, $column, $bonusType, $description);
            }
            if ($paymentMethod == self::PAYMENT_METHOD_POINT) {
                return $this->addPointTransaction($transaction, $column, $bonusType, $description);
            }
        }

        return false;
    }

    public function calculateSignUpBonus(MoneyInfo $moneyInfo): float
    {
        if (empty($moneyInfo) || $moneyInfo->member->mIsFirstLogin) return 0;

        if ($this->memberConfigRepository->disableEventRestrictionByKey($moneyInfo->member->mID, BonusConfig::TYPE_SIGNUP_BONUS)) return 0;

        $money = $this->bonusSignup['new_membership_signup_money'] ?? 0;

        $this->addMoneyCasinoMoneyInfo($moneyInfo, $money, BonusConfig::TYPE_SIGNUP_BONUS);

        return $money;
    }

    public function calculateNewMemberBonus(MoneyInfo $moneyInfo): float
    {
        if (array_key_exists(BonusConfig::TYPE_NEW_MEMBER_BONUS, $moneyInfo->miBonuses)) {
            //New member Bonus
            $money = $moneyInfo->miBonuses['new_member_bonus'];

            if ($moneyInfo->member->memberRechargedCount() == 0) {
                $this->addMoneyCasinoMoneyInfo($moneyInfo, $money, BonusConfig::TYPE_NEW_MEMBER_BONUS);
            }

            return $money;
        }

        return 0;
    }

    public function calculateRechargeBonus(MoneyInfo $moneyInfo): void
    {
        $isRechargedToday = $moneyInfo->member->memberHasRechargedToday();
        $hasMemberWithdrawnToday = $moneyInfo->member->memberHasWithdrawnToday();

        $recharge_time = $isRechargedToday ? BonusConfig::CASINO_RECHARGE : BonusConfig::CASINO_FIRST_TIME_RECHARGE;

        if (!isset($moneyInfo->miBonuses[BonusConfig::TYPE_RECHARGE_BONUS][$recharge_time])) return;

        $rechargeBonus = $moneyInfo->miBonuses[BonusConfig::TYPE_RECHARGE_BONUS][$recharge_time];

        if ($hasMemberWithdrawnToday && !$rechargeBonus['is_payment_upon_withdraw']) return;

        $rate = $moneyInfo->miRegDate->isWeekend() ? BonusConfig::WEEKEND_RATE : BonusConfig::WEEKDAY_RATE;

        $bonusConfigType = $isRechargedToday ? BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE : BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE;

        $money = $moneyInfo->miBankMoney * $rechargeBonus[$rate] / 100;

        $money = $moneyInfo->miMaxBonusRecharge && $money > $moneyInfo->miMaxBonusRecharge ? $moneyInfo->miMaxBonusRecharge : $money;

        $this->addMoneyCasinoMoneyInfo($moneyInfo, $money, $bonusConfigType);
    }

    public function calculateParticipateBonus(MoneyInfo $moneyInfo): float
    {
        if (empty($moneyInfo) || empty($moneyInfo->miBankMoney) || $moneyInfo->miType != MoneyInfo::TYPE_UD) return 0;

        if ($this->memberConfigRepository->disableEventRestrictionByKey($moneyInfo->member->mID, BonusConfig::TYPE_PARTICIPATE_BONUS)) return 0;

        $amount = $moneyInfo->miBankMoney;

        $config = app(BonusConfig::TYPE_PARTICIPATE_BONUS);
        $rechargeMilestone = $this->bonusConfigRepository->getValue($config)['ipl_bonus_plus_percent'];

        $bonusOrderPercent = $this->bonusParticipate['ipl_bonus_other_percent'] ?? 0;

        $parsedAmount = $amount / 1000;

        if (array_key_exists((int)$parsedAmount, $rechargeMilestone)) {
            $money = (int)$rechargeMilestone[$parsedAmount] * 1000;
        } else {
            $money = $bonusOrderPercent * $amount / 100;
        }

        $this->addMoneyCasinoMoneyInfo($moneyInfo, $money, BonusConfig::TYPE_PARTICIPATE_BONUS);

        return $money;
    }

    public function calculateSuddenBonus(MoneyInfo $moneyInfo): void
    {
        if (empty($moneyInfo) || empty($moneyInfo->miBankMoney)) return;

        // $is_valid = $this->moneyInfoRepository->getApprovedRechargeByDateTimeRange($moneyInfo['miBonuses']['sudden_bonus']['sudden_date_time'])->count() <= $moneyInfo['miBonuses']['sudden_bonus']['participation_per_member_count'];
        // if (!$is_valid) return 0;

        $amount = $moneyInfo->miBankMoney;

        $maximum_sudden_amount = (float) $moneyInfo['miBonuses']['sudden_bonus']['maximum_sudden_amount'];
        $payment_amount = (int) $moneyInfo['miBonuses']['sudden_bonus']['payment_amount'];

        $money = $amount * $payment_amount / 100;
        $money = $money > $maximum_sudden_amount ? $maximum_sudden_amount : $money;

        $this->addMoneyCasinoMoneyInfo($moneyInfo, $money, BonusConfig::TYPE_SUDDEN_BONUS);
    }

    public function calculateAttendanceBonus(MoneyInfo $moneyInfo): void
    {
        if (empty($moneyInfo) || empty($moneyInfo->miBankMoney)) return;

        $money = $moneyInfo->miBankMoney;

        if ($roulette = $moneyInfo->miBonuses['attendance_bonus']['roulette']) {

            $roulette += $moneyInfo->member->mRoulette;
            $moneyInfo->member->update(['mRoulette' => $roulette]);
        }

        $this->addMoneyCasinoMoneyInfo($moneyInfo, $money, BonusConfig::TYPE_ATTENDANCE_BONUS);
    }

    public function rollbackBonus(MoneyInfo $moneyInfo): bool
    {
        $money = $moneyInfo->point_history->phMoney * -1 ?? 0;
        if ($moneyInfo->point_history->phTable != $moneyInfo->getTable() && $money) {
            return false;
        }

        return $this->addMoneyCasinoMoneyInfo($moneyInfo, $money, BonusConfig::TYPE_ROLLBACK, 'Rollback bonus');
    }

    private function addMoneySportsMoneyInfo(MoneyInfo $moneyInfo, float $mSportsMoney = 0, ?string $bonusType = null, ?string $description = null): bool
    {
        $member = $moneyInfo->member;

        $data = [
            'phID' => $moneyInfo->miNo,
            'phTable' => $moneyInfo->getTable(),
            'mID' => $member->mID,
            'phSportsMoney' => $mSportsMoney,
            'mSportsMoney' => (float) $member->mSportsMoney,
            'phDescription' => $description,
            'phBonusType' => $bonusType,
        ];

        return $this->tryCatchFuncDB(function () use ($data, $member, $mSportsMoney) {
            $this->pointHistoryRepository->create($data);
            $this->memberRepository->updateByPK($member, ['mSportsMoney' => (float) $member->mSportsMoney + $mSportsMoney]);
        });
    }

    private function addMoneyCasinoMoneyInfo(MoneyInfo $moneyInfo, float $mMoney = 0, ?string $bonusType = null, ?string $description = null): bool
    {
        $member = $moneyInfo->member;

        $data = [
            'phID' => $moneyInfo->miNo,
            'phTable' => $moneyInfo->getTable(),
            'mID' => $member->mID,
            'phMoney' => $mMoney,
            'mMoney' => (float) $member->mMoney,
            'phDescription' => $description,
            'phBonusType' => $bonusType,
        ];

        return $this->tryCatchFuncDB(function () use ($data, $member, $mMoney) {
            $this->pointHistoryRepository->create($data);
            $this->memberRepository->updateByPK($member, ['mMoney' => (float) $member->mMoney + $mMoney]);
        });
    }

    private function addPointMoneyInfo(MoneyInfo $moneyInfo, float $mPoint = 0, ?string $bonusType = null, ?string $description = null): bool
    {
        $member = $moneyInfo->member;

        $data = [
            'phID' => $moneyInfo->miNo,
            'phTable' => $moneyInfo->getTable(),
            'mID' => $member->mID,
            'phPoint' => $mPoint,
            'mPoint' => (float) $member->mPoint,
            'phDescription' => $description,
            'phBonusType' => $bonusType,
        ];

        return $this->tryCatchFuncDB(function () use ($data, $member, $mPoint) {
            $this->pointHistoryRepository->create($data);
            $this->memberRepository->updateByPK($member, ['mPoint' => (float) $member->mPoint + $mPoint]);
        });
    }

    private function addMoneySportsTransaction(Transaction $transaction, ?array $column = null, ?string $bonusType = null, ?string $description = null): bool
    {
        $member = $transaction->member;
        $money = $column ? $this->calcPaymentAmountTransaction($transaction, $column) : $transaction->tAmount;

        $mSportsMoney = $member->mSportsMoney + $money;

        $data = [
            'phID' => $transaction->uuid,
            'phTable' => $transaction->getTable(),
            'mID' => $member->mID,
            'phSportsMoney' => $money,
            'mSportsMoney' => $member->mSportsMoney,
            'phDescription' => $description,
            'phBonusType' => $bonusType,
        ];

        return $this->tryCatchFuncDB(function () use ($data, $member, $mSportsMoney) {
            $this->pointHistoryRepository->create($data);
            $this->memberRepository->updateByPK($member, ['mSportsMoney' => (float) $mSportsMoney]);
        });
    }

    private function addMoneyCasinoTransaction(Transaction $transaction, ?array $column = null, ?string $bonusType = null, ?string $description = null): bool
    {
        $member = $transaction->member;
        $money = $column ? $this->calcPaymentAmountTransaction($transaction, $column) : $transaction->tAmount;

        $mMoney = $member->mMoney + $money;

        $data = [
            'phID' => $transaction->uuid,
            'phTable' => $transaction->getTable(),
            'mID' => $member->mID,
            'phMoney' => $money,
            'mMoney' => $member->mMoney,
            'phDescription' => $description,
            'phBonusType' => $bonusType,
        ];

        return $this->tryCatchFuncDB(function () use ($data, $member, $mMoney) {
            $this->pointHistoryRepository->create($data);
            $this->memberRepository->updateByPK($member, ['mMoney' => (float) $mMoney]);
        });
    }

    private function addPointTransaction(Transaction $transaction, ?array $column = null, ?string $bonusType = null, ?string $description = null): bool
    {
        $member = $transaction->member;

        if ($this->memberConfigRepository->disableEventRestrictionByKey($member->mID, $bonusType)) return false;

        $point = $column ? $this->calcPaymentAmountTransaction($transaction, $column) : $transaction->tAmount;

        $mPoint = $member->mPoint + $point;

        $data = [
            'phID' => $transaction->uuid,
            'phTable' => $transaction->getTable(),
            'mID' => $member->mID,
            'phPoint' => $point,
            'mPoint' => $member->mPoint,
            'phDescription' => $description,
            'phBonusType' => $bonusType,
        ];
        return $this->tryCatchFuncDB(function () use ($data, $member, $mPoint) {
            $this->pointHistoryRepository->create($data);
            $this->memberRepository->updateByPK($member, ['mPoint' => (float) $mPoint]);
        });
    }

    private function calcPaymentAmountTransaction(Transaction $transaction, array $column): float
    {
        $mLevel = $transaction->member->mLevel;

        $percent = $column['table'][$mLevel]['percent'] ?? 0;
        $max_payment_amount = $column['table'][$mLevel]['max_payment_amount'] ?? null;

        $bet_amount = $transaction->getBetAmount();

        $payment_amount = $bet_amount * $percent / 100;
        $payment_amount = $max_payment_amount && $payment_amount > $max_payment_amount ? $max_payment_amount : $payment_amount;

        return $payment_amount;
    }

    private function validateParams(string $paymentMethod, ?string $bonusType = null): ?array
    {
        if (!in_array($paymentMethod, $this->paymentMethods)) {
            throw new \Exception('Invalid payment method');
        }

        $column = null;
        if ($bonusType == BonusConfig::TYPE_SIGNUP_BONUS) {
            $column = $this->bonusSignup;
        }
        if ($bonusType == BonusConfig::TYPE_PAYBACK_BONUS) {
            $column = $this->bonusPayback;
        }
        if ($bonusType == BonusConfig::TYPE_ROLLING_BONUS) {
            $column = $this->bonusRolling;
        }
        if ($bonusType == BonusConfig::TYPE_LOSING_BONUS) {
            $column = $this->bonusLosing;
        }
        if ($bonusType == BonusConfig::TYPE_PARTICIPATE_BONUS) {
            $column = $this->bonusParticipate;
        }

        return $column;
    }
    private function checkIsAdd(?array $column = null, ?string $bonusType = null): bool
    {
        if (is_null($column)) return true;
        if ($bonusType == BonusConfig::TYPE_SIGNUP_BONUS) return true;
        if ($bonusType == BonusConfig::TYPE_PAYBACK_BONUS && $column['is_available']) return true;
        if ($bonusType == BonusConfig::TYPE_ROLLING_BONUS && $column['is_available']) return true;
        if ($bonusType == BonusConfig::TYPE_LOSING_BONUS && $column['is_available']) return true;
        if ($bonusType == BonusConfig::TYPE_PARTICIPATE_BONUS && $column['is_use_ipl_bonus']) return true;
        if ($bonusType == BonusConfig::TYPE_SUDDEN_BONUS) return true;

        return false;
    }

    public function calculatePaybackBonus(Member $member): float
    {
        if ($this->memberConfigRepository->disableEventRestrictionByKey($member->mID, BonusConfig::TYPE_PAYBACK_BONUS)) return 0;

        $profit = $member->sum_deposit - $member->sum_withdraw;

        $weekly_recharge_amount = (float)data_get($this->bonusPayback, 'weekly_recharge_amount');

        if ($profit > 0 && $member->sum_deposit > $weekly_recharge_amount) {

            $percent = data_get($this->bonusPayback, 'table.' . $member->mLevel . '.percent');

            $max_payment_amount = data_get($this->bonusPayback, 'table.' . $member->mLevel . '.max_payment_amount');;

            $payment_amount = $member->sum_deposit - $weekly_recharge_amount * $percent / 100;

            return $max_payment_amount && $payment_amount > $max_payment_amount ? $max_payment_amount : $payment_amount;
        }

        return 0;
    }

    public function appendMoneyInfoBonus(Member $member, array $attributes): array
    {
        $hasMemberRechargedToday = $member->memberHasRechargedToday();

        // Append first login bonus
        if (!$member->mIsFirstLogin) {
            $value = (float) $this->bonusSignup['new_membership_signup_money'];
            $attributes = $this->appendBonus($attributes, BonusConfig::TYPE_SIGNUP_BONUS, $value);
        }

        if ($attributes['miType'] == MoneyInfo::TYPE_UD) {
            // Append new member recharge bonus
            if ($this->bonusNewMember['is_use_new_member_bonus'] && $member->memberRechargedCount() == 0) {
                foreach ($this->bonusNewMember['new_member_bonus_plus_percent'] as $key => $value) {
                    $value = (float) $value;
                    if ($attributes['miBankMoney'] == $key * 10000) {
                        $point = $value * 10000;
                        break;
                    }
                }
                $value = $point ?? (float) $this->bonusNewMember['new_member_bonus_other_percent'] * $attributes['miBankMoney'] / 100;
                $attributes = $this->appendBonus($attributes, BonusConfig::TYPE_NEW_MEMBER_BONUS, $value);
            }

            // Append recharge bonus
            $value = $this->bonusRecharge['table'][$member->mLevel];
            $attributes = $this->appendBonus($attributes, BonusConfig::TYPE_RECHARGE_BONUS, $value);

            // Append sudden bonus
            if (
                $this->bonusSudden['is_available']
                && checkCurrentDateTimeInRange($this->bonusSudden['sudden_date_time'])
                && $this->moneyInfoRepository->getApprovedRechargeByDateTimeRange($this->bonusSudden['sudden_date_time'])->count() <= $this->bonusSudden['participation_per_member_count']
            ) {
                $value = [
                    'maximum_sudden_amount' => $this->bonusSudden['maximum_sudden_amount'],
                    'participation_per_member_count' => $this->bonusSudden['participation_per_member_count'],
                    'sudden_date_time' => $this->bonusSudden['sudden_date_time'],
                    ...$this->bonusSudden['table'][$member->mLevel][$hasMemberRechargedToday ? 'casino_recharge' : 'casino_first_time_recharge'],
                ];
                $attributes = $this->appendBonus($attributes, BonusConfig::TYPE_SUDDEN_BONUS, $value);
            }

            if (!empty($this->initDataCouponBonus($member))) {
                $attributes['miBonuses'][BonusConfig::TYPE_COUPON_BONUS] = $this->initDataCouponBonus($member);
            }
        }

        return $attributes;
    }

    private function appendBonus(array $attributes, string $key, float|string|array $value): array
    {
        return [
            ...$attributes,
            'miBonuses' => [
                ...$attributes['miBonuses'] ?? [],
                $key => $value,
            ],
        ];
    }

    public function payMoneyInfoBonus(MoneyInfo $moneyInfo)
    {
        //Sign in Bonus
        $this->calculateSignUpBonus($moneyInfo);

        //New member Bonus
        $this->calculateNewMemberBonus($moneyInfo);

        //Payment bonus
        $this->calculateRechargeBonus($moneyInfo);

        //Participation bonus
        $this->calculateParticipateBonus($moneyInfo);

        //Coupon Bonus
        $this->handleCouponBonus($moneyInfo);

        //Sudden bonus
        // $point += $this->calculateSuddenBonus($moneyInfo);
    }

    public function handleCouponBonus(MoneyInfo $moneyInfo)
    {
        $bonus_data = $this->rouletteHistoryRepository->isFirstRound($moneyInfo->member->mID);

        if (!$bonus_data) {
            if ($data_roulette_config = data_get($moneyInfo->miBonuses, BonusConfig::TYPE_COUPON_BONUS)) {
                $data['mID'] = $moneyInfo->member->mID;
                $data['rhStartDate'] = now()->toDateTimeString();
                $data['rhEndDate'] = now()->addDay((int)data_get($data_roulette_config, 'expiration_period', 0))->toDateTimeString();
                $data['rhValue'] = $data_roulette_config;
                $data['rhStatus'] = 0;
                $this->rouletteHistoryRepository->create($data);
            }
        } else {
            $milestones = data_get($bonus_data, 'rhValue.milestones');
            $filter_milestone = array_filter($milestones, function ($item) {
                return $item['status'] === true;
            }, ARRAY_FILTER_USE_BOTH);

            if (!empty($filter_milestone)) {
                $arr_key = array_keys($filter_milestone);
                end($arr_key);
                $key = key($arr_key);

                if ($key !== false) {
                    $this->rewardCoupon($bonus_data, $moneyInfo->member, $key + 1, $milestones, (float)$moneyInfo->miBankMoney);
                }
            } else {
                $this->rewardCoupon($bonus_data, $moneyInfo->member, 0, $milestones, (float)$moneyInfo->miBankMoney);
            }
        }
    }

    private function rewardCoupon(RouletteHistory $bonus_data, Member $member, int $key, array $milestones, float $miBankMoneyCurrent): void
    {
        $minimum_recharge_count = (int)data_get($milestones[$key], 'minimum_recharge_count_' . $key + 1);
        $minimum_recharge_amount = (float)data_get($milestones[$key], 'minimum_recharge_amount_' . $key + 1);
        $reward_coupon = data_get($milestones[$key], 'roulette_coupon_count_' . $key + 1);

        $number_of_rechagre = $this->moneyInfoRepository->getAmountRechagreByProcessDate(
            limit: $minimum_recharge_count,
            start_date: $bonus_data->rhStartDate,
            end_date: $bonus_data->rhEndDate,
            count_record: true
        ) + 1;

        $amount = $this->moneyInfoRepository->getAmountRechagreByProcessDate(
            limit: $minimum_recharge_count,
            start_date: $bonus_data->rhStartDate,
            end_date: $bonus_data->rhEndDate
        ) + $miBankMoneyCurrent;

        if ($amount > $minimum_recharge_amount && $number_of_rechagre > $minimum_recharge_count) {
            $this->tryCatchFuncDB(function () use ($bonus_data, $member, $reward_coupon, $key) {

                $milestones = $bonus_data->rhValue;
                $milestones['milestones'][$key]['status'] = true;
                $data_update_roulette['rhValue'] = $milestones;

                if ($key == 4) {
                    $data_update_roulette['rhStatus'] = true;
                }

                $this->rouletteHistoryRepository->updateByPK($bonus_data, $data_update_roulette);
                $this->memberRepository->updateByPK($member, ['mRoulette' => (int)data_get($member, 'mRoulette', 0) + (int) $reward_coupon]);
            });
        }
    }

    public function initDataCouponBonus(Member $member): array
    {
        if (
            data_get($this->bonusCoupon, 'is_collet_paid')
            && !$this->memberConfigRepository->disableEventRestrictionByKey($member->mID, BonusConfig::TYPE_COUPON_BONUS)
            && !$this->rouletteHistoryRepository->isFirstRound($member->mID)
        ) {
            $milestones = [];
            for ($i = 1; $i < 6; $i++) {
                $milestones[] = [
                    'minimum_recharge_count_' . $i => data_get($this->bonusCoupon, 'minimum_recharge_count_' . $i),
                    'minimum_recharge_amount_' . $i => data_get($this->bonusCoupon, 'minimum_recharge_amount_' . $i),
                    'roulette_coupon_count_' . $i => data_get($this->bonusCoupon, 'roulette_coupon_count_' . $i),
                    'status' => false
                ];
            }
            return [
                'expiration_period' => data_get($this->bonusCoupon, 'expiration_period'),
                'milestones' => $milestones
            ];
        }

        return [];
    }

    /**
     * Calculate and distribute rolling bonus for a transaction.
     *
     * @param Transaction $trans The transaction object.
     * @return void
     */
    public function rollingBonus(Transaction $trans): void
    {
        $bet = $this->transactionRepository->getBetTypeByRoundID($trans->tRoundId);
        if ($bet->tAmount == $trans->tAmount) {
            return;
        }

        $member = $trans->member;
        $gCategory = $trans->gCategory;
        $amount = $bet->tAmount;

        $currentRate = $this->memberRepository->getRate($member, $gCategory);
        $currentPublicBetting = $this->memberRepository->getPublicBetting($member, $gCategory);
        $this->storeRollingBonus($member, $currentRate, $amount, $currentPublicBetting, $gCategory);

        $parent = $this->memberRepository->partner($member->mMemberID);

        while (!empty($parent)) {
            $partnerRate = $this->memberRepository->getRate($parent, $gCategory);
            $partnerPublicBetting = $this->memberRepository->getPublicBetting($parent, $gCategory);

            if ($partnerRate && $currentRate < $partnerRate) {
                $rate = $partnerRate - $currentRate;
                $this->storeRollingBonus($parent, $rate, $amount, $partnerPublicBetting, $gCategory);
            }

            $currentRate = $partnerRate;
            $parent = $this->memberRepository->partner($parent->mMemberID);
        }
    }

    private function storeRollingBonus($member, $rate, $amount, $publicBetting, $gCategory): void
    {
        $point = $amount * $rate / 100;
        if ($publicBetting) {
            $point = $point - $point * $publicBetting / 100;
        }

        if ($point <= 0) {
            return;
        }

        $this->tryCatchFuncDB(function () use ($member, $point, $rate, $publicBetting, $amount, $gCategory) {

            $moneyInfo = $member->money_infos()->create([
                'miBankMoney' => $point,
                'miStatus' => MoneyInfo::STATUS_NINE,
                'miWallet' => MoneyInfo::TYPE_WALLET_POINT,
                'miType' => MoneyInfo::TYPE_AD,
            ]);

            $data = [
                'phID' => $moneyInfo->miNo,
                'phTable' => $moneyInfo->getTable(),
                'mID' => $member->mID,
                'phPoint' => $point,
                'mPoint' => (float) $member->mPoint,
                'phDescription' => "롤링포인트 {$point} / 배팅({$amount}) * 요율({$rate}) * 공배팅({$publicBetting})",
                'phBonusType' => BonusConfig::TYPE_ROLLING_BONUS,
                'phGameType' => $gCategory
            ];

            $this->pointHistoryRepository->create($data);
            $this->memberRepository->updateByPK($member, ['mPoint' => (float) $member->mPoint + $point]);
        });
    }
}
