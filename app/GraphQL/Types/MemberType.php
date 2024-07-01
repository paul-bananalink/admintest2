<?php

namespace App\GraphQL\Types;

use App\Models\Member;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MemberType extends GraphQLType
{
    protected $attributes = [
        'name' => 'MemberType',
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
            'mID' => [
                'type' => Type::string(),
                'description' => 'Username',
            ],
            'mNick' => [
                'type' => Type::string(),
                'description' => 'The nick of member',
            ],
            'mRealName' => [
                'type' => Type::string(),
                'description' => 'Real name of member',
            ],
            'mLevel' => [
                'type' => Type::string(),
                'description' => 'Level of member',
            ],
            'mPhone' => [
                'type' => Type::string(),
                'description' => 'Phone number',
            ],
            'mStatus' => [
                'type' => Type::int(),
                'description' => 'Status in 1, 2, 3, 7, 8, 9',
            ],
            'mPoint' => [
                'type' => Type::float(),
                'description' => 'Point',
                'resolve' => function ($root) {
                    return $root->mPoint ?? 0;
                }
            ],
            'mMoney' => [
                'type' => Type::float(),
                'description' => 'Money of casino, slot',
            ],
            'mSportsMoney' => [
                'type' => Type::float(),
                'description' => 'Money of sports',
            ],
            'mBankName' => [
                'type' => Type::string(),
                'description' => 'Bank name',
            ],
            'mBankNumber' => [
                'type' => Type::string(),
                'description' => 'Bank number',
            ],
            'mBankOwner' => [
                'type' => Type::string(),
                'description' => 'Bank owner',
            ],
            'mMemberID' => [
                'type' => Type::string(),
                'description' => 'Member ID',
            ],
            'accessToken' => [
                'type' => Type::string(),
                'description' => 'Access token',
            ],
        ];
    }
}
