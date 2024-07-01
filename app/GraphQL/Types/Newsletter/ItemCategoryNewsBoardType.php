<?php

namespace App\GraphQL\Types\Newsletter;

use App\Models\Newsletter;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ItemCategoryNewsBoardType extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemCategoryNewsBoard',
        'description' => 'Fields for Category NewsBoard List Query',
        'model' => Newsletter::class,
    ];

    public function fields(): array
    {
        return [
            'category_id' => [
                'type' => Type::nonNull(Type::int()),
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
