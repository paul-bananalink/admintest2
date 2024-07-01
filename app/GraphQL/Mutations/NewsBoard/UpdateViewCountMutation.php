<?php

namespace App\GraphQL\Mutations\NewsBoard;

use App\Services\GraphQL\NewsBoardService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateViewCountMutation extends Mutation
{
    public function __construct(
        private NewsBoardService $newsBoardService
    ) {
    }

    protected $attributes = [
        'name' => 'updateViewCountMutation',
        'description' => 'Member view newsboard',
    ];

    public function type(): Type
    {
        return GraphQL::type('statusType');
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required'],
        ];
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->newsBoardService->updateViewCount($args);
    }
}
