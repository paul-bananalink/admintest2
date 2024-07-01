<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class SportsSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Sports\BetQuery::class,
            ],

            'mutation' => [
                \App\GraphQL\Mutations\Sports\BetMutation::class,
                \App\GraphQL\Mutations\Sports\UpdatePickMutation::class,
                \App\GraphQL\Mutations\Sports\CancelBetMutation::class,
                \App\GraphQL\Mutations\Sports\DeleteBetMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\Sports\PickInputType::class,
                \App\GraphQL\Types\Sports\BetType::class,
                \App\GraphQL\Types\Sports\BetInfoType::class,
                \App\GraphQL\Types\Sports\PickType::class,
                \App\GraphQL\Types\Sports\UpdatePickType::class,
                \App\GraphQL\Types\Sports\CartType::class,
                \App\GraphQL\Types\Sports\DetailType::class,
                \App\GraphQL\Types\Sports\ListType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
