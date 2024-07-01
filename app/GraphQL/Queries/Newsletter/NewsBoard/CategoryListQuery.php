<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Newsletter\NewsBoard;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use App\Services\GraphQL\NewsBoardService;

class CategoryListQuery extends Query
{
    public function __construct(
        private NewsBoardService $newsBoardService
    ) {
    }

    protected $attributes = [
        'name' => 'categoryNewsBoard',
        'description' => 'Category NewsBoard List Query',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('itemCategoryNewsBoard'));
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->newsBoardService->categoryList();
    }
}
