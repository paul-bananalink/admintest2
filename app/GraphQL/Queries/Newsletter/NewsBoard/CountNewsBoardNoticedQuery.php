<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Newsletter\NewsBoard;

use App\Services\GraphQL\NewsBoardService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class CountNewsBoardNoticedQuery extends Query
{
    public function __construct(
        private NewsBoardService $newsBoardService
    ) {
    }

    protected $attributes = [
        'name' => 'countNewsBoardNoticed',
        'description' => 'Count announcement no read show notification',
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
        return $this->newsBoardService->countNoticed();
    }
}
