<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Banner;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ItemType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ItemType',
        'description' => 'Banner item'
    ];

    public function fields(): array
    {
        return [
            'bImage' => [
                'type' => Type::string(),
                'description' => 'The image url of the banner',
            ],
            'bLink' => [
                'type' => Type::string(),
                'description' => 'The url of the banner',
            ],
            'bTarget' => [
                'type' => Type::string(),
                'description' => 'The target of the banner',
            ],
        ];
    }
}
