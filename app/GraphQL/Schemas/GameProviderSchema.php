<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class GameProviderSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\GameProvider\GameProvidersQuery::class,
                \App\GraphQL\Queries\GameProvider\GameProviderQuery::class,
                \App\GraphQL\Queries\GameProvider\GpCodeQuery::class
            ],

            'mutation' => [],

            'types' => [
                \App\GraphQL\Types\GameProviderType::class,
                \App\GraphQL\Types\GameType::class,
                \App\GraphQL\Types\GpCodeType::class
            ]
        ];
    }
}
