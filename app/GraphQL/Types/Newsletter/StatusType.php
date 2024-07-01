<?php

namespace App\GraphQL\Types\Newsletter;

use App\Models\Newsletter;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class StatusType extends GraphQLType
{
    protected $attributes = [
        'name' => 'statusType',
        'description' => 'Return type for CRUD',
        'model' => Newsletter::class,
    ];

    public function fields(): array
    {
        return [
            'status' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
        ];
    }
}
