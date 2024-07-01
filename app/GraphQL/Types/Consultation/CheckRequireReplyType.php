<?php

namespace App\GraphQL\Types\Consultation;

use App\Models\Consultation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CheckRequireReplyType extends GraphQLType
{
    protected $attributes = [
        'name' => 'checkRequireReplyType',
        'description' => 'Check require reply consultation',
        'model' => Consultation::class,
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
