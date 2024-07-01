<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Sports;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class DetailType extends GraphQLType
{
    protected $attributes = [
        'name' => 'DetailType',
        'description' => 'A type for sports detail'
    ];

    public function fields(): array
    {
        return [
            "betId" => [
                'type' => Type::int(),
                'description' => 'The ID of the bet',
            ],
            "status" => [
                'type' => Type::int(),
                'description' => 'The status of the bet',
            ],
            "fixtureId" => [
                'type' => Type::int(),
                'description' => 'The ID of the fixture',
            ],
            "selectRate" => [
                'type' => Type::float(),
                'description' => 'The rate of the selection',
            ],
            "baseLine" => [
                'type' => Type::string(),
                'description' => 'The baseline of the selection',
            ],
            "startDate" => [
                'type' => Type::string(),
                'description' => 'The start date of the fixture',
            ],
            "selectIdx" => [
                'type' => Type::string(),
                'description' => 'The index of the selection',
            ],
            "selPickName" => [
                'type' => Type::string(),
                'description' => 'The name of the selection pick',
            ],
            "homeTeamName" => [
                'type' => Type::string(),
                'description' => 'The name of the home team',
            ],
            "awayTeamName" => [
                'type' => Type::string(),
                'description' => 'The name of the away team',
            ],
            "marketName" => [
                'type' => Type::string(),
                'description' => 'The name of the market',
            ],
            "gameType" => [
                'type' => Type::string(),
                'description' => 'The type of the game',
            ],
        ];
    }
}
