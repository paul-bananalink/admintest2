<?php

namespace App\Services;

use App\Models\BonusConfig;
use App\Repositories\BonusConfigRepository;

class BonusConfigService extends BaseService
{
    public function __construct(
        private BonusConfigRepository $bonusConfigRepository,
    ) {
    }

    public function toggleField(string $field, string $bonusType = null): bool
    {
        if ($bonusType === BonusConfig::TYPE_BONUS) {

            $config = app(BonusConfig::TYPE_BONUS);

            if (empty($config)) {
                return false;
            }

            $data = [];
            $data[$field] = !data_get($config, $field, true);

            return $this->tryCatchFuncDB(function () use ($config, $data) {
                $this->bonusConfigRepository->updateByPK($config, $data);
            });
        }
    }

    public function toggleFieldInJSON(string $field, string $bonusType = null): bool
    {
        $config = app($bonusType);

        if (empty($config)) {
            return false;
        }

        $parts = preg_split("/\[|\]/", $field);
        $column = $parts[0];
        $key = $parts[1];

        $attributes[$bonusType][$key] = !data_get($config, "bcValue.$key", false);

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$bonusType]);
    }

    public function updateBonus(array $attributes): bool
    {
        $key = BonusConfig::TYPE_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        $attributes[$key]['paid_amount'] = $this->convertFloat($attributes[$key]['paid_amount'] ?? '');

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusRecharge(array $attributes): bool
    {
        $key = BonusConfig::TYPE_RECHARGE_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusSignup(array $attributes): bool
    {
        $key = BonusConfig::TYPE_SIGNUP_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusParticipate(array $attributes): bool
    {
        $key = BonusConfig::TYPE_PARTICIPATE_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        $attributes[$key]['ipl_bonus_other_percent'] = $this->convertFloat($attributes[$key]['ipl_bonus_other_percent']);

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusNewMember(array $attributes): bool
    {
        $key = BonusConfig::TYPE_NEW_MEMBER_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        // $attributes[$key]['new_member_bonus_other_percent'] = $this->convertFloat($attributes[$key]['new_member_bonus_other_percent'] ?? '');

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusAttendance(array $attributes): bool
    {
        $key = BonusConfig::TYPE_ATTENDANCE_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        $attributes[$key]['maximum_payment_limit_amount'] = $this->convertFloat($attributes[$key]['maximum_payment_limit_amount'] ?? '');
        $attributes[$key]['7_day_attendance_payment_rate'] = $this->convertFloat($attributes[$key]['7_day_attendance_payment_rate'] ?? '');
        $attributes[$key]['6_day_attendance_payment_rate'] = $this->convertFloat($attributes[$key]['6_day_attendance_payment_rate'] ?? '');
        $attributes[$key]['day_of_attendance_1'] = $this->convertFloat($attributes[$key]['day_of_attendance_1'] ?? '');
        $attributes[$key]['attendance_payment_amount_1'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_1'] ?? '');
        $attributes[$key]['day_of_attendance_2'] = $this->convertFloat($attributes[$key]['day_of_attendance_2'] ?? '');
        $attributes[$key]['attendance_payment_amount_2'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_2'] ?? '');
        $attributes[$key]['day_of_attendance_3'] = $this->convertFloat($attributes[$key]['day_of_attendance_3'] ?? '');
        $attributes[$key]['attendance_payment_amount_3'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_3'] ?? '');
        $attributes[$key]['day_of_attendance_4'] = $this->convertFloat($attributes[$key]['day_of_attendance_4'] ?? '');
        $attributes[$key]['attendance_payment_amount_4'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_4'] ?? '');
        $attributes[$key]['day_of_attendance_5'] = $this->convertFloat($attributes[$key]['day_of_attendance_5'] ?? '');
        $attributes[$key]['attendance_payment_amount_5'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_5'] ?? '');
        $attributes[$key]['day_of_attendance_6'] = $this->convertFloat($attributes[$key]['day_of_attendance_6'] ?? '');
        $attributes[$key]['attendance_payment_amount_6'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_6'] ?? '');
        $attributes[$key]['day_of_attendance_7'] = $this->convertFloat($attributes[$key]['day_of_attendance_7'] ?? '');
        $attributes[$key]['attendance_payment_amount_7'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_7'] ?? '');
        $attributes[$key]['day_of_attendance_8'] = $this->convertFloat($attributes[$key]['day_of_attendance_8'] ?? '');
        $attributes[$key]['attendance_payment_amount_8'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_8'] ?? '');
        $attributes[$key]['day_of_attendance_9'] = $this->convertFloat($attributes[$key]['day_of_attendance_9'] ?? '');
        $attributes[$key]['attendance_payment_amount_9'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_9'] ?? '');
        $attributes[$key]['day_of_attendance_10'] = $this->convertFloat($attributes[$key]['day_of_attendance_10'] ?? '');
        $attributes[$key]['attendance_payment_amount_10'] = $this->convertFloat($attributes[$key]['attendance_payment_amount_10'] ?? '');
        $attributes[$key]['attendance_every_day_payment_amount'] = $this->convertFloat($attributes[$key]['attendance_every_day_payment_amount'] ?? '');

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusReferral(array $attributes): bool
    {
        $key = BonusConfig::TYPE_REFERRAL_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusHallOfFame(array $attributes): bool
    {
        $key = BonusConfig::TYPE_HALL_OF_FAME_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusConsolationPrize(array $attributes): bool
    {
        $key = BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusPayback(array $attributes): bool
    {
        $key = BonusConfig::TYPE_PAYBACK_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusLevelUp(array $attributes): bool
    {
        $key = BonusConfig::TYPE_LEVEL_UP_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusRolling(array $attributes): bool
    {
        $key = BonusConfig::TYPE_ROLLING_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusLosing(array $attributes): bool
    {
        $key = BonusConfig::TYPE_LOSING_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusCoupon(array $attributes): bool
    {
        $key = BonusConfig::TYPE_COUPON_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function updateBonusSudden(array $attributes): bool
    {
        $key = BonusConfig::TYPE_SUDDEN_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
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

    public function toggleFieldBonusRecharge(array $fields)
    {
        $key = BonusConfig::TYPE_RECHARGE_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        $level = $fields['level'];
        $group = $fields['group'];
        $field = $fields['field'];

        $attributes[$key]['table'][$level][$group][$field] = !data_get($config, "bcValue.table.$level.$group.$field", false);

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }

    public function toggleFieldBonusSudden(array $fields)
    {
        $key = BonusConfig::TYPE_SUDDEN_BONUS;
        $config = app($key);

        if (empty($config)) {
            return false;
        }

        $level = $fields['level'];
        $group = $fields['group'];
        $field = $fields['field'];

        $attributes[$key]['table'][$level][$group][$field] = !data_get($config, "bcValue.table.$level.$group.$field", false);

        return $this->bonusConfigRepository->updateConfig($config, $attributes[$key]);
    }
}
