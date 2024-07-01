<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ValidationDepositType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ValidationDepositType',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'required' => [
                'type' => Type::string(),
            ],
            'min' => [
                'type' => Type::string(),
            ],
        ];
    }
}
