<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Sports;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BetType extends GraphQLType
{
    protected $attributes = [
        'name' => 'BetType',
        'description' => 'A type for a bet on a sport event'
    ];

    public function fields(): array
    {
        return [
            'status' => [
                'type' => Type::boolean(),
                'description' => 'The status of the bet',
            ],
            'message' => [
                'type' => Type::string(),
                'description' => 'The message of the bet',
            ],
            'data' => [
                'type' => GraphQL::type('BetInfoType'),
                'description' => 'The data of the bet',
            ]
        ];
    }
}
