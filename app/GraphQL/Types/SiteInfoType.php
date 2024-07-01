<?php

namespace App\GraphQL\Types;

use App\Models\SiteInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SiteInfoType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SiteInfoType',
        'description' => 'Member Site info',
        'model' => SiteInfo::class,
    ];

    public function fields(): array
    {
        return [
            'min_deposit' => [
                'type' => Type::int(),
            ],
            'deposit_text' => [
                'type' => Type::string(),
            ],
            'validation_deposit' => [
                'type' => GraphQL::type('ValidationDepositType'),
            ],
            'min_withraw' => [
                'type' => Type::int(),
            ],
            'withraw_text' => [
                'type' => Type::string(),
            ],
            'validation_withraw' => [
                'type' => GraphQL::type('ValidationWithrawType'),
            ],
            'captcha' => [
                'type' => Type::boolean(),
            ],
            'enable_consultation' => [
                'type' => Type::boolean(),
            ],
            'recharge_config' => [
                'type' => GraphQL::type('RechargeConfigType')
            ],
            'withdraw_config' => [
                'type' => GraphQL::type('WithdrawConfigType')
            ],
            'sports_config_text' => [
                'type' => Type::string(),
            ],
            'casino_config_text' => [
                'type' => Type::string(),
            ],
            'game_config' => [
                'type' => GraphQL::type('GameConfigType')
            ],
            'roulette_rules' => [
                'type' => GraphQL::type('RouletteRuleType'),
            ]
        ];
    }
}
