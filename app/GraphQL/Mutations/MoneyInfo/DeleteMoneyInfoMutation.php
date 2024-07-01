<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\MoneyInfo;

use App\Services\MoneyInfoService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteMoneyInfoMutation extends Mutation
{
    public function __construct(private MoneyInfoService $moneyInfoService)
    {
    }

    protected $attributes = [
        'name' => 'DeleteMoneyInfoMutation',
        'description' => 'Delete money info mutation',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required', 'integer'],
        ];
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'alias' => 'miNo',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->moneyInfoService->delete($args['miNo']);
    }
}
