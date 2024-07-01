<?php

namespace App\Services;

use App\Repositories\WithdrawConfigRepository;

class WithdrawConfigService extends BaseService
{
    public function __construct(
        private WithdrawConfigRepository $withdrawConfigRepository,
    ) {
    }

    public function getConfig()
    {
        return $this->withdrawConfigRepository->getByPK(1) ?? null;
    }

    public function syncWithdrawConfig(array $attributes)
    {
        $attributes['wcTimeOffWithdraw'] = $this->parseMinutes($attributes['minutes'] ?? []);

        $this->withdrawConfigRepository->updateOrCreate(['wcNo' => 1], $attributes);
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
}
