<?php

namespace App\GraphQL\Types\Notice;

use App\Models\Notice;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ItemCategoryNoticeEvent extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemCategoryNoticeEvent',
        'description' => 'Fields for Category Notice Event List Query',
        'model' => Notice::class,
    ];

    public function fields(): array
    {
        return [
            'category_notice_event' => [
                'type' => Type::nonNull(Type::string()),
                'resolve' => function ($root) {
                    return $root;
                },
            ],
        ];
    }
}
