<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Sports;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class PickType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PickType',
        'description' => 'A type for a pick on a sport event'
    ];

    public function fields(): array
    {
        return [
            'bet_code' => [
                'type' => Type::string(),
                'description' => 'The code of the bet',
            ],
            'select_rate' => [
                'type' => Type::string(),
                'description' => 'The rate of the selection',
            ],
            'status' => [
                'type' => Type::int(),
                'description' => 'The status of the pick',
            ],
        ];
    }
}
