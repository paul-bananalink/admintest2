<?php

namespace App\Services;

use App\Repositories\RechargeConfigRepository;

class RechargeConfigService extends BaseService
{
    public function __construct(
        private RechargeConfigRepository $RechargeConfigRepository,
    ) {
    }

    public function getConfig()
    {
        return $this->RechargeConfigRepository->getByPK(1);
    }

    public function syncRechargeConfig(array $attributes)
    {
        if (request()->ajax()) {
            $data['rcBonusWarningMessage'] = $attributes['rcBonusWarningMessage'];
        } else {
            $data = $attributes;
        }

        $data['rcTimeOffRecharge'] = $this->parseMinutes($attributes['minutes'] ?? []);

        $this->RechargeConfigRepository->updateOrCreate(['rcNo' => 1], $data);
    }

    public function toggleField(string $field = ''): bool
    {
        try {
            if (empty($field)) {
                return false;
            }

            $site = $this->getConfig();
            if (empty($site)) {
                return false;
            }

            $site->{$field} = !$site->{$field};
            $site->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function parseMinutes($attributes)
    {
        if (empty($attributes['start']) && empty($attributes['end'])) return null;

        $start = $attributes['start'] ?? '00';
        $end = $attributes['end'] ?? '00';

        return "11:" . $start . " - " . "00:" . $end;
    }

    public function getBanks(): array
    {
        $rechargeConfig = $this->RechargeConfigRepository->getByPK(1);

        if (empty($rechargeConfig)) return [];

        $banks = explode("\r\n", $rechargeConfig->rcBanks);

        return $banks;
    }
}
