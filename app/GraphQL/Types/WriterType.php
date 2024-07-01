<?php

namespace App\GraphQL\Types;

use App\Models\Member;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class WriterType extends GraphQLType
{
    protected $attributes = [
        'name' => 'writer',
        'description' => 'A type',
        'model' => Member::class,
    ];

    public function fields(): array
    {
        return [
            'mNo' => [
                'type' => Type::int(),
                'description' => 'The id of the member',
            ],
            'mNick' => [
                'type' => Type::string(),
                'description' => 'The nick of member',
            ],
            'mRealName' => [
                'type' => Type::string(),
                'description' => 'Real name of member',
            ],
        ];
    }
}
