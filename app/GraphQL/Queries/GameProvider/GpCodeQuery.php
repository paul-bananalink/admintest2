<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\GameProvider;

use App\Services\GameProviderService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class GpCodeQuery extends Query
{
    public function __construct(private GameProviderService $gameProviderService)
    {
    }

    protected $attributes = [
        'name' => 'GpCodeQuery',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('GpCodeType'));
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->gameProviderService->getGpCodesCasino();
    }
}
