<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class NewsBoardSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Newsletter\NewsBoard\NewsBoardListQuery::class,
                \App\GraphQL\Queries\Newsletter\NewsBoard\CountNewsBoardNoticedQuery::class,
                \App\GraphQL\Queries\Newsletter\NewsBoard\CategoryListQuery::class,
            ],

            'mutation' => [
                \App\GraphQL\Mutations\NewsBoard\UpdateViewCountMutation::class,
                \App\GraphQL\Mutations\NewsBoard\UpdateNoticedNewsBoardMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\Newsletter\EventType::class,
                \App\GraphQL\Types\Newsletter\NewsBoardType::class,
                \App\GraphQL\Types\WriterType::class,
                \App\GraphQL\Types\Newsletter\StatusType::class,
                \App\GraphQL\Types\Newsletter\CountType::class,
                \App\GraphQL\Types\Newsletter\NoticedType::class,
                \App\GraphQL\Types\Newsletter\ItemCategoryNewsBoardType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
