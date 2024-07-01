<?php

namespace App\GraphQL\Types\Note;

use App\Models\Note;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NoticedType extends GraphQLType
{
    protected $attributes = [
        'name' => 'noticedType',
        'description' => 'Status update noticed note',
        'model' => Note::class,
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
