<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class EventListSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Newsletter\Event\EventListQuery::class
            ],

            'types' => [
                \App\GraphQL\Types\Newsletter\EventType::class,
                \App\GraphQL\Types\WriterType::class
            ],
        ];
    }
}
