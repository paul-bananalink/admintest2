<?php

namespace App\GraphQL\Types;

use App\Models\Minigame;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MiniGameType extends GraphQLType
{
    protected $attributes = [
        'name' => 'MiniGameType',
        'description' => 'A type',
        'model' => Minigame::class,
    ];

    public function fields(): array
    {
        return [
            'round' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Round game',
            ],
            'mode' => [
                'type' => Type::string(),
                'description' => 'Mini game mode',
            ],
            'date' => [
                'type' => Type::string(),
            ],
            'ball_1' => [
                'type' => Type::int(),
            ],
            'ball_2' => [
                'type' => Type::int(),
            ],
            'ball_3' => [
                'type' => Type::int(),
            ],
            'ball_4' => [
                'type' => Type::int(),
            ],
            'ball_5' => [
                'type' => Type::int(),
            ],
            'powerball' => [
                'type' => Type::int(),
            ],
        ];
    }
}
