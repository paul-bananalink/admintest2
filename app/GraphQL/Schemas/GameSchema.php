<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class GameSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Game\GameQuery::class,
            ],

            'mutation' => [
                // ExampleMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\LaunchGameType::class,
            ],
            'middleware' => ['auth:sanctum']
        ];
    }
}
