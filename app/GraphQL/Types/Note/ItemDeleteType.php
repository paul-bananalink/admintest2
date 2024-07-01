<?php

namespace App\GraphQL\Types\Note;

use App\Models\Note;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ItemDeleteType extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemDeleteType',
        'description' => 'Item note',
        'model' => Note::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'is_deleted' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
        ];
    }
}
