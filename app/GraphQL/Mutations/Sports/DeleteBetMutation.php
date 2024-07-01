<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Sports;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use App\Services\Sports\BetService;

class DeleteBetMutation extends Mutation
{
    public function __construct(private BetService $betService)
    {
    }

    protected $attributes = [
        'name' => 'DeleteBetMutation',
        'description' => 'A mutation to delete a bet from the cart'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'bet_id' => [
                'name' => 'bet_id',
                'type' => Type::int(),
                'description' => 'The ID of the bet to delete',
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {

        return $this->betService->deleteBet($args['bet_id']);
    }
}
