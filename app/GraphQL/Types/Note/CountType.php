<?php

namespace App\GraphQL\Types\Note;

use App\Models\Note;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

use function PHPSTORM_META\type;

class CountType extends GraphQLType
{
    protected $attributes = [
        'name' => 'countType',
        'description' => 'Count note no read',
        'model' => Note::class,
    ];

    public function fields(): array
    {
        return [
            'count' => [
                'type' => Type::int(),
                'resolve' => function ($root) {
                    return data_get($root, 'count');
                },
            ],
            'count_no_read' => [
                'type' => Type::int(),
                'resolve' => function ($root) {
                    return data_get($root, 'count_no_read');
                }
            ]
        ];
    }
}
