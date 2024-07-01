<?php

namespace App\GraphQL\Types\Newsletter;

use App\Models\Newsletter;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CountType extends GraphQLType
{
    protected $attributes = [
        'name' => 'countType',
        'model' => Newsletter::class,
    ];

    public function fields(): array
    {
        return [
            'count' => [
                'type' => Type::int(),
                'resolve' => function ($root) {
                    return $root;
                },
            ],
        ];
    }
}
