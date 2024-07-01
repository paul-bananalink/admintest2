<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Models\Game;

class GameType extends GraphQLType
{
    protected $attributes = [
        'name' => 'GameType',
        'description' => 'Game type',
        'model' => Game::class
    ];

    public function fields(): array
    {
        return [
            'gCode' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Game code',
            ],
            'gpCode' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Game Provider code',
            ],
            'gName' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Game name',
            ],
            'gNameEn' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Game name english',
            ],
            'gCategory' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Game category',
            ],
            'gIconUrl' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Game icon url',
            ]
        ];
    }
}
