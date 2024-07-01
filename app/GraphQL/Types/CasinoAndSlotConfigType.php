<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CasinoAndSlotConfigType extends GraphQLType
{
    protected $attributes = [
        'name' => 'CasinoAndSlotConfigType',
        'description' => 'Casino and configs',
    ];

    public function fields(): array
    {
        return [
            'enable' => [
                'type' => Type::boolean(),
                'description' => 'Enable casino',
            ],
        ];
    }
}
