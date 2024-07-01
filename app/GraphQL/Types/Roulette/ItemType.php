<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Roulette;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ItemType extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemType',
        'description' => 'A roulette item type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
            ],
            'bgcolor' => [
                'type' => Type::string(),
            ],
            'amount' => [
                'type' => Type::float(),
            ],
        ];
    }
}
