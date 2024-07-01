<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class RouletteRuleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'RouletteRuleType',
        'description' => 'Roulette rule type',
    ];

    public function fields(): array
    {
        return [
            'member_roulette' => [
                'type' => Type::int(),
                'description' => 'Member roulette'
            ],
        ];
    }
}
