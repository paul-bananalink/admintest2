<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Sports;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Services\Sports\BetService;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdatePickMutation extends Mutation
{
    public function __construct(private BetService $betService)
    {
    }

    protected $attributes = [
        'name' => 'UpdatePickMutation',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('UpdatePickType');
    }

    public function args(): array
    {
        return [
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
            $data = $this->betService->updatePick($args);
            return [
                'status' => true,
                'message' => '베팅이 삭제되었습니다',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }
}
