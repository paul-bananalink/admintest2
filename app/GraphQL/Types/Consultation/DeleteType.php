<?php

namespace App\GraphQL\Types\Consultation;

use App\Models\Consultation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DeleteType extends GraphQLType
{
    protected $attributes = [
        'name' => 'deleteType',
        'description' => 'Deleted status',
        'model' => Consultation::class,
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
