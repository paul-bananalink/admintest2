<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class WithdrawCheckType extends GraphQLType
{
    protected $attributes = [
        'name' => 'WithdrawCheckType',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'sports_current_money' => [
                'type'=> Type::float(),
            ],
            'sports_withdraw_money' => [
                'type'=> Type::float(),
            ],
            'is_enable_sports_withdraw' => [
                'type'=> Type::boolean(),
            ],
            'casino_current_money' => [
                'type'=> Type::float(),
            ],
            'casino_withdraw_money' => [
                'type'=> Type::float(),
            ],
            'is_enable_casino_withdraw' => [
                'type'=> Type::boolean(),
            ],
        ];
    }
}
