<?php

namespace App\GraphQL\Mutations\Event;

use App\Services\GraphQL\EventService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateNoticedEventMutation extends Mutation
{
    public function __construct(private EventService $eventService)
    {
    }

    protected $attributes = [
        'name' => 'updateNoticedEventMutation',
        'description' => 'Member click notice event',
    ];

    public function type(): Type
    {
        return GraphQL::type('noticedType');
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [];
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->eventService->updateNoticedisReadAll();
    }
}
