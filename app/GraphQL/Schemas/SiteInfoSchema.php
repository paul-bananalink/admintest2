<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class SiteInfoSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\SiteInfo\SiteInfoQuery::class,
            ],

            'mutation' => [
                // ExampleMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\SiteInfoType::class,
                \App\GraphQL\Types\GameConfigType::class,
                \App\GraphQL\Types\ValidationDepositType::class,
                \App\GraphQL\Types\ValidationWithrawType::class,
                \App\GraphQL\Types\RechargeConfigType::class,
                \App\GraphQL\Types\WithdrawConfigType::class,
                \App\GraphQL\Types\MiniGameConfigType::class,
                \App\GraphQL\Types\CasinoAndSlotConfigType::class,
                \App\GraphQL\Types\RouletteRuleType::class,
            ],
            'middleware' => ['auth:sanctum'],
        ];
    }
}
