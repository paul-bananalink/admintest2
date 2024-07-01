<?php

declare(strict_types=1);

namespace App\GraphQL\Types;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BannerType extends GraphQLType
{
    protected $attributes = [
        'name' => 'BannerType',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            \App\Models\Banner::TYPE_CENTER_BELOW => [
                'type'=> Type::listOf(GraphQL::type('ItemType')),
                'description' => ''
            ],
            \App\Models\Banner::TYPE_CENTER => [
                'type'=> Type::listOf(GraphQL::type('ItemType')),
                'description' => ''
            ],
            \App\Models\Banner::TYPE_LEFT => [
                'type'=> Type::listOf(GraphQL::type('ItemType')),
                'description' => ''
            ],
            \App\Models\Banner::TYPE_RIGHT => [
                'type'=> Type::listOf(GraphQL::type('ItemType')),
                'description' => ''
            ],
        ];
    }
}
