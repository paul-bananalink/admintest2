<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Roulette;

use App\Services\GraphQL\RouletteService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class RouletteQuery extends Query
{
    public function __construct(
        private RouletteService $rouletteService,
    ) {
    }

    protected $attributes = [
        'name' => 'roulette',
        'description' => 'A query of roulette',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('itemType'));
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->rouletteService->init();
    }
}
