<?php

namespace App\GraphQL\Types\Note;

use App\Models\Note;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DeleteType extends GraphQLType
{
    protected $attributes = [
        'name' => 'deleteType',
        'description' => 'Delete items note',
        'model' => Note::class,
    ];

    public function fields(): array
    {
        return [
            'list' => [
                'type' => Type::listOf(GraphQL::type('itemDeleteType')),
                'resolve' => function ($root) {
                    return $root;
                },
            ],
        ];
    }
}
