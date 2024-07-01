<?php

namespace App\GraphQL\Queries\MoneyInfo;

use App\Models\MoneyInfo;
use App\Services\MoneyInfoService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class MoneyInfoList extends Query
{
    public function __construct(private MoneyInfoService $moneyInfoService)
    {
    }

    protected $attributes = [
        'name' => 'MoneyInfoListQuery',
        'description' => 'Money info list',
    ];

    public function args(): array
    {
        return [
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'type' => [
                'name' => 'type',
                'type' => Type::string(),
                'description' => 'types includes: recharge, withdraw, exchange'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'type' => 'required|in:' . implode(',', array_keys(MoneyInfo::MI_TYPE_FILTER))
        ];
    }

    public function type(): Type
    {
        return GraphQL::paginate('MoneyInfoType');
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->moneyInfoService->paginate($args);
    }
}
