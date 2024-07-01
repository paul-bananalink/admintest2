<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Sports;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class BetInfoType extends GraphQLType
{
    protected $attributes = [
        'name' => 'BetInfoType',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'mSportsMoney' => [
                'type' => Type::int(),
                'description' => 'The amount of sports money the user has',
            ],
        ];
    }
}
