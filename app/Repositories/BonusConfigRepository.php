<?php

namespace App\Repositories;

use App\Models\BonusConfig;

class BonusConfigRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return BonusConfig::class;
    }

    public function getValue(BonusConfig $config): array
    {
        return data_get($config, 'bcValue', []);
    }

    public function updateConfig(BonusConfig $config, array $attributes): bool
    {
        $value = $this->getValue($config);
        $data = array_replace_recursive($value, $attributes);

        return $config->update(['bcValue' => $data]);
    }
}
