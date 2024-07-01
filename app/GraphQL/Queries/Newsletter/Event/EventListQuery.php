<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Newsletter\Event;

use App\Services\GraphQL\EventService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class EventListQuery extends Query
{
    public function __construct(
        private EventService $eventService
    ) {
    }

    protected $attributes = [
        'name' => 'event',
        'description' => 'Event Query',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('item');
    }

    public function args(): array
    {
        return [
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->eventService->paginate($args);
    }
}
