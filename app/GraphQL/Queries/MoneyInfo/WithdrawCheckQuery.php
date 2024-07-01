<?php

namespace App\GraphQL\Queries\MoneyInfo;

use App\Services\MoneyInfoService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class WithdrawCheckQuery extends Query
{
    public function __construct(
        private MoneyInfoService $moneyInfoService,
    ) {
    }

    protected $attributes = [
        'name' => 'WithdrawCheckQuery',
        'description' => 'WithdrawCheck Query',
    ];

    public function type(): Type
    {
        return GraphQL::type('WithdrawCheckType');
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->moneyInfoService->getWithdrawCheck();
    }
}
