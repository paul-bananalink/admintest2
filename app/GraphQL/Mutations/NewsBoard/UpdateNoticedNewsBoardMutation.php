<?php

namespace App\GraphQL\Mutations\NewsBoard;

use App\Services\GraphQL\NewsBoardService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateNoticedNewsBoardMutation extends Mutation
{
    public function __construct(private NewsBoardService $newsBoardService)
    {
    }

    protected $attributes = [
        'name' => 'updateNoticedNewsBoardMutation',
        'description' => 'Member click notice announcement',
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
        return $this->newsBoardService->updateNoticedisReadAll();
    }
}
