<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class BannerSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Banner\BannerQuery::class
            ],

            'types' => [
                \App\GraphQL\Types\Banner\ItemType::class,
                \App\GraphQL\Types\BannerType::class,
            ],
        ];
    }
}
