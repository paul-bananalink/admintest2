<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Sports;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class PickInputType extends InputType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'PickInputType',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            "fixture_id" => [
                'type' => Type::int(),
                'description' => 'The ID of the fixture',
            ],
            "bet_code" => [
                'type' => Type::string(),
                'description' => 'The code of the bet',
            ],
            "select_rate" => [
                'type' => Type::float(),
                'description' => 'The rate of the selection',
            ],
            "select_pick_desc" => [
                'type' => Type::string(),
                'description' => 'The description of the selection pick',
            ],
            "pick_detail" => [
                'type' => Type::string(),
                'description' => 'The detail of the pick',
            ],
            "market_name" => [
                'type' => Type::string(),
                'description' => 'The name of the market',
            ],
            "pick_title" => [
                'type' => Type::string(),
                'description' => 'The title of the pick',
            ],
            "key" => [
                'type' => Type::string(),
                'description' => 'The key of the pick',
            ],
            "status" => [
                'type' => Type::int(),
                'description' => 'The status of the pick',
            ],
            "marketId" => [
                'type' => Type::int(),
                'description' => 'The ID of the market',
            ],
            "select_idx" => [
                'type' => Type::int(),
                'description' => 'The index of the selection',
            ],
            "sports_code" => [
                'type' => Type::string(),
                'description' => 'The code of the sports',
            ],
            "sports_name" => [
                'type' => Type::string(),
                'description' => 'The name of the sports',
            ],
            "old_rate" => [
                'type' => Type::string(),
                'description' => 'The old rate of the pick',
            ],
        ];
    }
}
