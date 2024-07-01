<?php

// File: app/GraphQL/Types/EventType.php

namespace App\GraphQL\Types\Newsletter;

use App\Models\Newsletter;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class EventType extends GraphQLType
{
    protected $attributes = [
        'name' => 'item',
        'description' => 'Event',
        'model' => Newsletter::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the event',
            ],
            'banner' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The banner of the event',
                'resolve' => function ($root, $args) {
                    return $root->banner ? formatImageUrlApi($root->banner) : '';
                },
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the event',
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The content of the event',
            ],
            'created_date' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Create date event',
            ],
            'start_date' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Start date event',
                'resolve' => function ($root, $args) {
                    return formatDate($root->start_date);
                },
            ],
            'end_date' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'End date event',
                'resolve' => function ($root, $args) {
                    return formatDate($root->end_date);
                },
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
