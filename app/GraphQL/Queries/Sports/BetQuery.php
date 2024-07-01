<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Sports;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use App\Services\Sports\BetService;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BetQuery extends Query
{
    public function __construct(private BetService $betService)
    {
    }

    protected $attributes = [
        'name' => 'BetQuery',
        'description' => 'A query to get all the bets in the cart'
    ];

    public function type(): Type
    {
        // return Type::string();
        return GraphQL::type('ListType');
    }

    public function args(): array
    {
        return [
            'game_type' => [
                'name' => 'game_type',
                'type' => Type::string(),
                'description' => 'The type of game to get the bets for',
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'The number of bets to get',
            ],
            'offset' => [
                'name' => 'offset',
                'type' => Type::int(),
                'description' => 'The number of bets to skip',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->betService->getBets($args);
    }
}
