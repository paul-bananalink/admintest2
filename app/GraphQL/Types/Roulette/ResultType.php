<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Roulette;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ResultType extends GraphQLType
{
    protected $attributes = [
        'name' => 'resultType',
        'description' => 'A roulette result type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
            ],
            'amount' => [
                'type' => Type::float(),
            ],
            'seconds' => [
                'type' => Type::float(),
            ],
        ];
    }
}
