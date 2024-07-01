<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Sports;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Services\Sports\BetService;

class CancelBetMutation extends Mutation
{
    public function __construct(private BetService $betService)
    {
    }

    protected $attributes = [
        'name' => 'CancelBetMutation',
        'description' => 'Cancel a bet'
    ];

    public function type(): Type
    {
        return GraphQL::type('BetType');
    }

    public function args(): array
    {
        return [
            'bet_id' => [
                'name' => 'bet_id',
                'type' => Type::int(),
                'description' => 'The ID of the bet to cancel',
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            $money = $this->betService->cancelBet($args);
            return [
                'status' => true,
                'message' => '베팅이 업데이트되었습니다',
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
