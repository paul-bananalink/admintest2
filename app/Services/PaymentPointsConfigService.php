<?php

namespace App\Services;

use App\Models\PaymentPointsConfig;
use App\Repositories\PaymentPointsConfigRepository;

class PaymentPointsConfigService extends BaseService
{
    public function __construct(
        private PaymentPointsConfigRepository $paymentPointsConfigRepo
    ) {
    }

    public function toggleField(string $field, string $ppcType = null): bool
    {
        if ($ppcType === \App\Models\PaymentPointsConfig::TYPE_BONUS) {

            $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_BONUS);

            if (empty($config)) {
                return false;
            }

            $data = [];
            $data[$field] = !data_get($config, $field, true);

            return $this->tryCatchFuncDB(function () use ($config, $data) {
                $this->paymentPointsConfigRepo->updateByPK($config, $data);
            });
        }
    }

    public function toggleFieldInJSON(string $field, string $ppcType = null): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig($ppcType);
        $data = $config->toArray();

        if (empty($config)) {
            return false;
        }

        $parts = preg_split("/\[|\]/", $field);
        $column = $parts[0];
        $key = $parts[1];

        $data[$column][$key] = !data_get($config->$column, $key, false);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonus(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_BONUS);

        $ppcAmountPaid = str_replace(',', '', data_get($request, "ppcAmountPaid", 0));
        $data['ppcAmountPaid'] = floatval($ppcAmountPaid);

        if (empty($config)) {
            return false;
        }

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusRecharge(array $data)
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_RECHARGE_BONUS);

        $attr['ppcWeekdayRate'] = $this->convertFloat($data['ppcWeekdayRate']);
        $attr['ppcWeekendRate'] = $this->convertFloat($data['ppcWeekendRate']);

        return $this->tryCatchFuncDB(function () use ($config, $attr) {
            $this->paymentPointsConfigRepo->updateByPK($config, $attr);
        });

        return $config;
    }

    public function updateBonusSignup(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_SIGNUP_BONUS);
        $column = 'ppcSignup';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusParticipate(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_PARTICIPATE_BONUS);
        $column = 'ppcParticipate';

        if (empty($config)) {
            return false;
        }

        $request[$column]['ipl_bonus_plus_percent'] = $request[$column]['ipl_bonus_plus_percent'] ?? [];
        $request[$column]['ipl_bonus_other_percent'] = $this->convertFloat($request[$column]['ipl_bonus_other_percent'] ?? '');
        $request[$column]['minimum_ipl_bet_odds'] = $this->convertFloat($request[$column]['minimum_ipl_bet_odds'] ?? '');
        $request[$column]['minimum_ipl_bet_players'] = $this->convertFloat($request[$column]['minimum_ipl_bet_players'] ?? '');
        $request[$column]['ipl_bonus_for_next_recharges_after_sign_up'] = $this->convertFloat($request[$column]['ipl_bonus_for_next_recharges_after_sign_up'] ?? '');
        $request[$column]['maximum_ipl_payment_amount'] = $this->convertFloat($request[$column]['maximum_ipl_payment_amount'] ?? '');

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusNewMember(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_NEW_MEMBER_BONUS);
        $column = 'ppcNewMember';

        if (empty($config)) {
            return false;
        }

        $request[$column]['new_member_bonus_3_plus_amount'] = $this->convertFloat($request[$column]['new_member_bonus_3_plus_amount'] ?? '');
        $request[$column]['new_member_bonus_5_plus_amount'] = $this->convertFloat($request[$column]['new_member_bonus_5_plus_amount'] ?? '');
        $request[$column]['new_member_bonus_10_plus_amount'] = $this->convertFloat($request[$column]['new_member_bonus_10_plus_amount'] ?? '');
        $request[$column]['new_member_bonus_20_plus_amount'] = $this->convertFloat($request[$column]['new_member_bonus_20_plus_amount'] ?? '');
        $request[$column]['new_member_bonus_30_plus_amount'] = $this->convertFloat($request[$column]['new_member_bonus_30_plus_amount'] ?? '');
        $request[$column]['new_member_bonus_50_plus_amount'] = $this->convertFloat($request[$column]['new_member_bonus_50_plus_amount'] ?? '');
        $request[$column]['new_member_bonus_100_plus_amount'] = $this->convertFloat($request[$column]['new_member_bonus_100_plus_amount'] ?? '');
        $request[$column]['new_member_bonus_other_percent'] = $this->convertFloat($request[$column]['new_member_bonus_other_percent'] ?? '');
        $request[$column]['minimum_new_member_bet_odds'] = $this->convertFloat($request[$column]['minimum_new_member_bet_odds'] ?? '');
        $request[$column]['minimum_new_member_bet_players'] = $this->convertFloat($request[$column]['minimum_new_member_bet_players'] ?? '');
        $request[$column]['new_member_bonus_for_next_recharges_after_sign_up'] = $this->convertFloat($request[$column]['new_member_bonus_for_next_recharges_after_sign_up'] ?? '');
        $request[$column]['maximum_new_member_payment_amount'] = $this->convertFloat($request[$column]['maximum_new_member_payment_amount'] ?? '');
        $request[$column]['maximum_ipl_payment_amount'] = $this->convertFloat($request[$column]['maximum_ipl_payment_amount'] ?? '');

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusAttendance(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_ATTENDANCE_BONUS);
        $column = 'ppcAttendance';

        if (empty($config)) {
            return false;
        }
        $request[$column]['milestone_receives_gift'] = $request[$column]['milestone_receives_gift'] ?? [];
        $request[$column]['maximum_payment_limit_amount'] = $this->convertFloat($request[$column]['maximum_payment_limit_amount'] ?? '');
        $request[$column]['7_day_attendance_payment_rate'] = $this->convertFloat($request[$column]['7_day_attendance_payment_rate'] ?? '');
        $request[$column]['attendance_payment_amount_10'] = $this->convertFloat($request[$column]['attendance_payment_amount_10'] ?? '');
        $request[$column]['attendance_every_day_payment_amount'] = $this->convertFloat($request[$column]['attendance_every_day_payment_amount'] ?? '');
        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusReferral(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_REFERRAL_BONUS);
        $column = 'ppcReferral';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusHallOfFame(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_HALL_OF_FAME_BONUS);
        $column = 'ppcHallOfFame';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusConsolationPrize(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_CONSOLATION_PRIZE_BONUS);
        $column = 'ppcConsolationPrize';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusPayback(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_PAYBACK_BONUS);
        $column = 'ppcPayback';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusLevelUp(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_LEVEL_UP_BONUS);
        $column = 'ppcLevelUp';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusRolling(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_ROLLING_BONUS);
        $column = 'ppcRolling';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusLosing(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_LOSING_BONUS);
        $column = 'ppcLosing';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusCoupon(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_COUPON_BONUS);
        $column = 'ppcCoupon';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_merge($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function updateBonusSudden(array $request): bool
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_SUDDEN_BONUS);
        $column = 'ppcSudden';

        if (empty($config)) {
            return false;
        }

        $data[$column] = array_replace_recursive($config->$column ?? [], $request[$column]);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }

    public function convertFloat(array|string $data): array|float
    {
        if (gettype($data) === 'string') {
            $value = str_replace(',', '', $data);
            return floatval($value);
        }

        return array_map(function ($subArray) {
            return array_map(function ($value) {
                $value = str_replace(',', '', $value);
                return floatval($value);
            }, $subArray);
        }, $data);
    }

    public function firstBonusRecharge(): ?PaymentPointsConfig
    {
        $data = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_RECHARGE_BONUS);

        return $data;
    }

    public function toggleFieldBonusDeposit(array $data)
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_RECHARGE_BONUS);

        if (empty($config)) return false;

        $level = $data['level'];
        $key = $data['key'];

        $item = $config->ppcIsPaymentUponWithdrawal;

        if (!$item) return false;

        if ($item[$level][$key] === null) {
            $item[$level][$key] = 1;
        } elseif ($item[$level][$key] === 0) {
            $item[$level][$key] = 1;
        } elseif ($item[$level][$key] === 1) {
            $item[$level][$key] = 0;
        }

        $attr['ppcIsPaymentUponWithdrawal'] = $item;

        return $this->tryCatchFuncDB(function () use ($config, $attr) {
            $this->paymentPointsConfigRepo->updateByPK($config, $attr);
        });
    }

    public function toggleFieldBonusSudden(array $fields)
    {
        $config = $this->paymentPointsConfigRepo->fetchPaymentPointsConfig(\App\Models\PaymentPointsConfig::TYPE_SUDDEN_BONUS);
        $data = $config->toArray();

        if (empty($config)) return false;

        $column = 'ppcSudden';
        $level = $fields['level'];
        $key = $fields['key'];
        $field = $fields['field'];

        $data[$column]['table'][$level][$key][$field] = !($config->$column['table'][$level][$key][$field] ?? false);

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->paymentPointsConfigRepo->updateByPK($config, $data);
        });
    }
}
