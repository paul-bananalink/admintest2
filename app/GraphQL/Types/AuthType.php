<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AuthType extends GraphQLType
{
    protected $attributes = [
        'name' => 'AuthType',
        'description' => 'Auth member type',
    ];

    public function fields(): array
    {
        return [
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Response messages',
            ],
            'access_token' => [
                'type' => Type::string(),
                'description' => 'Access token',
            ],
            'member' => [
                'type' => GraphQL::type('MemberType'),
                'description' => 'Member created',
            ],
            'status' => [
                'type' => Type::boolean(),
                'description' => 'Status is true or false',
            ],
            'first_time_login_modal' => [
                'type' => Type::string(),
                'description' => 'First login modal',
            ],
            'membership_fee_regulation' => [
                'type' => Type::string(),
                'description' => 'Membership fee regulation',
            ]
        ];
    }
}
