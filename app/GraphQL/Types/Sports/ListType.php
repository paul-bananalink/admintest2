<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Sports;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ListType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ListType',
        'description' => 'A type for sports list'
    ];

    public function fields(): array
    {
        return [
            'list' => [
                'type' => Type::listOf(GraphQL::type('CartType')),
                'description' => 'The data of the list',
            ],
            'detailList' => [
                'type' => Type::listOf(GraphQL::type('DetailType')),
                'description' => 'The data of the detail list',
            ],
            'length' => [
                'type' => Type::int(),
                'description' => 'The length of the list',
            ],
            'total' => [
                'type' => Type::int(),
                'description' => 'The total of the list',
            ]
        ];
    }
}
