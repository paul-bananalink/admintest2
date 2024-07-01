<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Sports;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Services\Sports\BetService;

class BetMutation extends Mutation
{
    public function __construct(private BetService $betService)
    {
    }

    protected $attributes = [
        'name' => 'SportBetMutation',
        'description' => 'A mutation to place a bet on a sport event'
    ];

    public function type(): Type
    {
        return GraphQL::type('BetType');
    }

    public function args(): array
    {
        return [
            'bet_cash' => [
                'name' => 'bet_cash',
                'type' => Type::int(),
                'description' => 'The amount of cash to bet',
            ],
            'game_type' => [
                'name' => 'game_type',
                'type' => Type::int(),
                'description' => 'The type of game for the bet',
            ],
            'pick_list' => [
                'name' => 'pick_list',
                'type' => Type::listOf(GraphQL::type('PickInputType')),
                'description' => 'The list of picks for the bet',
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            $money = $this->betService->bet($args);
            return [
                'status' => true,
                'message' => '베팅되었습니다',
                'data' => [
                    'mSportsMoney' => $money
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => [
                    'mSportsMoney' => null
                ]
            ];
        }
    }
}
