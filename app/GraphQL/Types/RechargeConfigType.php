<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class RechargeConfigType extends GraphQLType
{
    protected $attributes = [
        'name' => 'RechargeConfigType',
        'description' => 'A type',
    ];

    public function fields(): array
    {
        return [
            'rc_rules' => [
                'type' => Type::string(),
            ],
            'rc_max_bonus_first_time_sports_recharge' => [
                'type' => Type::float(),
            ],
            'rc_max_bonus_sports_recharge' => [
                'type' => Type::float(),
            ],
            'rc_max_bonus_first_time_casino_recharge' => [
                'type' => Type::float(),
            ],
            'rc_max_bonus_casino_recharge' => [
                'type' => Type::float(),
            ],
            'rc_enable_bonus' => [
                'type' => Type::boolean(),
            ],
            'rc_max_bonus_first_time_poker_recharge' => [
                'type' => Type::float(),
            ],
            'rc_max_bonus_poker_recharge' => [
                'type' => Type::float(),
            ],
            'rc_amount_no_bonus' => [
                'type' => Type::float(),
            ],
            'rc_auto_bonus' => [
                'type' => Type::boolean(),
            ],
            'rc_manual_recharge' => [
                'type' => Type::boolean(),
            ],
            'rc_enable_recharge' => [
                'type' => Type::boolean(),
            ],
            'rc_enable_config_bonus' => [
                'type' => Type::boolean(),
            ],
            'rc_enable_thousand_money' => [
                'type' => Type::boolean(),
            ],
        ];
    }
}
