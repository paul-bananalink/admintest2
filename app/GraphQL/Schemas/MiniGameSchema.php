<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class MiniGameSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\MiniGame\MiniGameQuery::class,
            ],

            'types' => [
                \App\GraphQL\Types\MiniGameType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
