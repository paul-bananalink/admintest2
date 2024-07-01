<?php

// File: app/GraphQL/Types/EventType.php

namespace App\GraphQL\Types\Consultation;

use App\Models\Consultation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ItemType extends GraphQLType
{
    protected $attributes = [
        'name' => 'itemType',
        'description' => 'Item consultation',
        'model' => Consultation::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'content_reply' => [
                'type' => Type::string(),
            ],
            'author' => [
                'type' => Type::nonNull(Type::string()),
                'resolve' => function ($root) {
                    return $root->member->mID ?? '';
                },
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }
}
