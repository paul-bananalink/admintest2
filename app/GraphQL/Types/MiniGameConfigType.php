<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class MiniGameConfigType extends GraphQLType
{
    protected $attributes = [
        'name' => 'MiniGameConfigType',
        'description' => 'Mini Game configs',
    ];

    public function fields(): array
    {
        return [
            'enable' => [
                'type' => Type::boolean(),
                'description' => 'Enable mini game',
            ],
        ];
    }
}
