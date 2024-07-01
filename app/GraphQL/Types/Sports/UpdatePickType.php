<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Sports;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdatePickType extends GraphQLType
{
    protected $attributes = [
        'name' => 'UpdatePickType',
        'description' => 'A type for update pick mutation'
    ];

    public function fields(): array
    {
        return [
            'status' => [
                'type' => Type::boolean(),
                'description' => 'The status of the update pick',
            ],
            'message' => [
                'type' => Type::string(),
                'description' => 'The message of the update pick',
            ],
            'data' => [
                'type' => Type::listOf(GraphQL::type('PickType')),
                'description' => 'The data of the update pick',
            ]
        ];
    }
}
