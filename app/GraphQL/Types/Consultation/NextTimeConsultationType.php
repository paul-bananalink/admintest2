<?php

namespace App\GraphQL\Types\Consultation;

use App\Models\Consultation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NextTimeConsultationType extends GraphQLType
{
    protected $attributes = [
        'name' => 'nextTimeConsultationType',
        'description' => 'Next time consultation',
        'model' => Consultation::class,
    ];

    public function fields(): array
    {
        return [
            'next_time_at' => [
                'type' => Type::string(),
                'resolve' => function ($root) {
                    return $root;
                },
            ],
        ];
    }
}
