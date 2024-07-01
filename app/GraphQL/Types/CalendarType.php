<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class CalendarType extends GraphQLType
{
    protected $attributes = [
        'name' => 'CalendarType',
        'description' => 'Calendar type'
    ];

    public function fields(): array
    {
        return [
            'date' => [
                'type' => Type::string(),
                'description' => 'Date'
            ],
            'is_attended' => [
                'type' => Type::boolean(),
                'description' => 'Is attended'
            ],
            'is_bonus' => [
                'type' => Type::boolean(),
                'description' => 'Is bonus'
            ],
            'is_today_attendance' => [
                'type' => Type::boolean(),
                'description' => 'Is today attendance'
            ],
        ];
    }
}
