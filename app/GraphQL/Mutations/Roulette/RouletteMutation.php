<?php

namespace App\GraphQL\Mutations\Roulette;

use App\Services\GraphQL\RouletteService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\GraphQLException;

class RouletteMutation extends Mutation
{
    public function __construct(
        private RouletteService $rouletteService,
    ) {
    }

    protected $attributes = [
        'name' => 'rouletteMutation',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('resultType');
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        if (Auth::guard('sanctum')->user()->mRoulette == 0) {
            throw new GraphQLException('룰렛이 없습니다');
        }

        return [];
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->rouletteService->result();
    }
}
