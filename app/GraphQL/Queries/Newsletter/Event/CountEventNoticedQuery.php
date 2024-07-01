<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Newsletter\Event;

use App\Services\GraphQL\EventService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class CountEventNoticedQuery extends Query
{
    public function __construct(
        private EventService $eventService
    ) {
    }

    protected $attributes = [
        'name' => 'countEventNoticed',
        'description' => 'Count event no read show notification',
    ];

    public function type(): Type
    {
        return GraphQL::type('countType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->eventService->countEventNoticed();
    }
}
