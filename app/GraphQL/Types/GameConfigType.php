<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class GameConfigType extends GraphQLType
{
    protected $attributes = [
        'name' => 'GameConfigType',
        'description' => 'Game configs',
    ];

    public function fields(): array
    {
        return [
            'siEnableGamesConfig' => [
                'type' => Type::boolean(),
                'description' => 'Enable all games',
            ],
            'siEnableGamesConfigNotice' => [
                'type' => Type::string(),
                'description' => 'Notice for disable all games',
            ],
            'casino' => [
                'type' => GraphQL::type('CasinoAndSlotConfigType')
            ],
            'slot' => [
                'type' => GraphQL::type('CasinoAndSlotConfigType')
            ]
        ];
    }
}
