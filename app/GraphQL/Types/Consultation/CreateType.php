<?php

namespace App\GraphQL\Types\Consultation;

use App\Models\Consultation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CreateType extends GraphQLType
{
    protected $attributes = [
        'name' => 'createType',
        'description' => 'Return type for create consultation',
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
