<?php

namespace App\GraphQL\Types\Note;

use App\Models\Note;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ItemReadType extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemReadType',
        'description' => 'Update Read items note',
        'model' => Note::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'is_read' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
        ];
    }
}
