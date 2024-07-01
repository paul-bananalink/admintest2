<?php

namespace App\GraphQL\Types\Newsletter;

use App\Models\Newsletter;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NoticedType extends GraphQLType
{
    protected $attributes = [
        'name' => 'noticedType',
        'description' => 'Status update noticed',
        'model' => Newsletter::class,
    ];

    public function fields(): array
    {
        return [
            'status' => [
                'type' => Type::boolean(),
                'resolve' => function ($root) {
                    return $root;
                },
            ],
        ];
    }
}
