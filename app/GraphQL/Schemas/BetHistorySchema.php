<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class BetHistorySchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\BetHistory\BetHistoriesQuery::class
            ],

            'mutation' => [
                // ExampleMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\BetHistoryType::class
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
