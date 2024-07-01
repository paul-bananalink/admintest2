<?php

namespace App\GraphQL\Types\Newsletter;

use App\Models\Newsletter;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NewsBoardType extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemNewsBoard',
        'description' => 'NewsBoard',
        'model' => Newsletter::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the notice board',
            ],
            'category_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Category id of the notice board',
                'resolve' => function ($root, $args) {
                    return $root->category;
                },
            ],
            'category_name' => [
                'type' => Type::string(),
                'description' => 'Category name of the notice board',
                'resolve' => function ($root, $args) {
                    return \App\Models\Newsletter::$categories_newboard[$root->category] ?? null;
                },
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the notice board',
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The content of the notice board',
            ],
            'created_date' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Create date notice board',
            ],
            'mNo_writer' => [
                'type' => GraphQL::type('writer'),
                'description' => 'Writer of event',
                'resolve' => function ($root, $args) {
                    return $root->member;
                },
            ],
        ];
    }
}
