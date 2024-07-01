<?php

namespace App\GraphQL\Types;

use App\Models\MoneyInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MoneyInfoType extends GraphQLType
{
    protected $attributes = [
        'name' => 'MoneyInfoType',
        'description' => 'Money info type',
        'model' => MoneyInfo::class,
    ];

    public function fields(): array
    {
        return [
            'miNo' => [
                'type' => Type::int(),
                'description' => 'The id of the money info',
            ],
            'member' => [
                'type' => GraphQL::type('MemberType'),
                'description' => 'Member request withdraw',
            ],
            'miType' => [
                'type' => Type::string(),
                'description' => 'The type of action',
            ],
            'miStatus' => [
                'type' => Type::string(),
                'description' => 'The status of action',
            ],
            'miBankMoney' => [
                'type' => Type::float(),
                'description' => 'Amount of transaction',
            ],
            'miRegDate' => [
                'type' => Type::string(),
                'description' => 'Created at',
            ],
            'mProcessDate' => [
                'type' => Type::string(),
                'description' => 'Updated at',
            ],
            'process_member' => [
                'type' => GraphQL::type('MemberType'),
                'description' => 'The id of the member',
            ],
            'from' => [
                'type' => Type::string(),
                'description' => 'From wallet',
            ],
            'to' => [
                'type' => Type::string(),
                'description' => 'To wallet',
            ]
        ];
    }
}
