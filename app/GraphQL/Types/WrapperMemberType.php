<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class WrapperMemberType extends GraphQLType
{
    protected $attributes = [
        'name' => 'WrapperMemberType',
        'description' => 'A type',
    ];

    public function fields(): array
    {
        return [
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Response messages',
            ],
            'member' => [
                'type' => GraphQL::type('MemberType'),
                'description' => 'Member created',
            ],
            'status' => [
                'type' => Type::boolean(),
                'description' => 'Status is true or false',
            ],
        ];
    }
}
