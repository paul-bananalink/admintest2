<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\MoneyInfo;

use App\Models\MoneyInfo;
use App\Services\MoneyInfoService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteByDays extends Mutation
{
    public function __construct(private MoneyInfoService $moneyInfoService)
    {
    }
    
    protected $attributes = [
        'name' => 'DeleteByDays',
        'description' => 'Delete money info mutation by number day latest'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'type' => [
                'name' => 'type',
                'type' => Type::string(),
                'description' => 'types includes: recharge, withdraw'
            ],
            'days' => [
                'name' => 'days',
                'type' => Type::int(),
                'description' => 'number day delete latest'
            ],
        ];
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [
            'type' => 'required|in:' . implode(',', array_keys(MoneyInfo::MI_TYPE_FILTER))
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->moneyInfoService->getRepo()->deleteByDays($args);
    }
}
