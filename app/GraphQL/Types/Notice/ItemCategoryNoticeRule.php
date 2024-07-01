<?php

namespace App\GraphQL\Types\Notice;

use App\Models\Notice;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ItemCategoryNoticeRule extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemCategoryNotice',
        'description' => 'Fields for Category NoticeRule List Query',
        'model' => Notice::class,
    ];

    public function fields(): array
    {
        return [
            'category_id' => [
                'type' => Type::nonNull(Type::string()),
                'resolve' => function ($root) {
                    return data_get($root, 'category_id');
                },
            ],
            'category_name' => [
            'type' => Type::nonNull(Type::string()),
            'resolve' => function ($root) {
                return data_get($root, 'category_name');
                },
            ],
        ];
    }
}
