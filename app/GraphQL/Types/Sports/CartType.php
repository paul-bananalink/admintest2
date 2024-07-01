<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Sports;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class CartType extends GraphQLType
{
    protected $attributes = [
        'name' => 'CartType',
        'description' => 'Cart Type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'Cart ID',
            ],
            'betDate' => [
                'type' => Type::string(),
                'description' => 'Bet date',
            ],
            'status' => [
                'type' => Type::int(),
                'description' => 'Cart status',
            ],
            'cashBet' => [
                'type' => Type::int(),
                'description' => 'Cash bet',
            ],
            'rateBet' => [
                'type' => Type::string(),
                'description' => 'Rate bet',
            ],
            'rateBonus' => [
                'type' => Type::int(),
                'description' => 'Rate bonus',
            ],
        ];
    }
}
