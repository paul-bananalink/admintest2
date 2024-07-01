<?php

namespace App\GraphQL\Types\Note;

use App\Models\Note;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ReadType extends GraphQLType
{
    protected $attributes = [
        'name' => 'readType',
        'description' => 'Item note',
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
