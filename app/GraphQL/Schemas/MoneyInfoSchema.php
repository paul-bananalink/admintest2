<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class MoneyInfoSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\MoneyInfo\MoneyInfoList::class,
                \App\GraphQL\Queries\MoneyInfo\WithdrawCheckQuery::class,
            ],

            'mutation' => [
                \App\GraphQL\Mutations\MoneyInfo\WithdrawMutation::class,
                \App\GraphQL\Mutations\MoneyInfo\RechargeMutation::class,
                \App\GraphQL\Mutations\MoneyInfo\DeleteMoneyInfoMutation::class,
                \App\GraphQL\Mutations\MoneyInfo\DeleteByDays::class,
            ],

            'types' => [
                \App\GraphQL\Types\MemberType::class,
                \App\GraphQL\Types\MoneyInfoType::class,
                \App\GraphQL\Types\WithdrawCheckType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
