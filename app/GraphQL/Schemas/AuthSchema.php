<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class AuthSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                'hasMember' => \App\GraphQL\Queries\Auth\HasMemberQuery::class,
                \App\GraphQL\Queries\Auth\PageSiteQuery::class,
            ],

            'mutation' => [
                'registerMember' => \App\GraphQL\Mutations\Auth\RegisterMutation::class,
                'loginMember' => \App\GraphQL\Mutations\Auth\LoginMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\AuthType::class,
                \App\GraphQL\Types\MemberType::class,
                \App\GraphQL\Types\PageSiteType::class,
            ],

        ];
    }
}
