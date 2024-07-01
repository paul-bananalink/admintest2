<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class GpCodeType extends GraphQLType
{
    protected $attributes = [
        'name' => 'GpCodeType',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'gpName' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'provider name',
            ],
            'gpCode' => [
                'type' => Type::string(),
                'description' => 'provider code',
            ]
        ];
    }
}
