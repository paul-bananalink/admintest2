<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class EventSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Newsletter\Event\EventListQuery::class,
                \App\GraphQL\Queries\Newsletter\Event\CountEventNoticedQuery::class,
            ],

            'mutation' => [
                \App\GraphQL\Mutations\Event\UpdateViewCountMutation::class,
                \App\GraphQL\Mutations\Event\UpdateNoticedEventMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\Newsletter\EventType::class,
                \App\GraphQL\Types\WriterType::class,
                \App\GraphQL\Types\Newsletter\StatusType::class,
                \App\GraphQL\Types\Newsletter\CountType::class,
                \App\GraphQL\Types\Newsletter\NoticedType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
