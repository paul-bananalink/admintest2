<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class RouletteSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Roulette\RouletteQuery::class,
            ],

            'mutation' => [
                \App\GraphQL\Mutations\Roulette\RouletteMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\Roulette\ItemType::class,
                \App\GraphQL\Types\Roulette\ResultType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
