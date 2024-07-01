<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Newsletter\NewsBoard;

use App\Services\GraphQL\NewsBoardService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NewsBoardListQuery extends Query
{
    public function __construct(
        private NewsBoardService $newsBoardService
    ) {
    }

    protected $attributes = [
        'name' => 'newsBoard',
        'description' => 'NewsBoard List Query',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('itemNewsBoard');
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
            'filter' => [
                'name' => 'filter',
                'type' => Type::string(),
                'description' => 'Filter by ex search by category id: {"name": "category", "value": ""}',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->newsBoardService->paginate($args);
    }
}
