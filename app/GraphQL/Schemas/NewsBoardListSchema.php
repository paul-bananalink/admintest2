<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class NewsBoardListSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Newsletter\NewsBoard\NewsBoardListQuery::class,
                \App\GraphQL\Queries\Newsletter\NewsBoard\CategoryListQuery::class,
            ],

            'types' => [
                \App\GraphQL\Types\Newsletter\NewsBoardType::class,
                \App\GraphQL\Types\WriterType::class,
                \App\GraphQL\Types\Newsletter\ItemCategoryNewsBoardType::class,
            ],

        ];
    }
}
