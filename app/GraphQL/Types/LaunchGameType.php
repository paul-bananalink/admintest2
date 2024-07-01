<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class LaunchGameType extends GraphQLType
{
    protected $attributes = [
        'name' => 'LaunchGameType',
        'description' => 'Launch game type'
    ];

    public function fields(): array
    {
        return [
            'url' => [
                'type' => Type::string(),
                'description' => 'Game url or provider url',
            ]
        ];
    }
}
