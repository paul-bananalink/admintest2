<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Popup;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Models\Popup;

class ItemType extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemType',
        'description' => 'Item of popup',
        'model' => Popup::class
    ];

    public function fields(): array
    {
        return [
            'poNo' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Popup ID',
            ],
            'poLink' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Popup link',
                'resolve' => function ($root) {
                    return $root->poLink ?? '';
                }
            ],
            'poContent' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Popup content',
                'resolve' => function ($root) {
                    return $root->poContent ?? '';
                }
            ],
            'poLoggined' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Popup loggined',
                'resolve' => function ($root) {
                    return !$root->poLoggined;
                }
            ],
            'poOpenNewWindow' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Popup open new window',
            ]
        ];
    }
}
