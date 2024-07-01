<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class MemberSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Member\MemberQuery::class,
                \App\GraphQL\Queries\Member\CalendarAttendanceQuery::class
            ],

            'mutation' => [
                \App\GraphQL\Mutations\Member\UpdatePasswordMutation::class,
                \App\GraphQL\Mutations\Member\LogoutMutation::class,
                \App\GraphQL\Mutations\Member\ExchangeMoneyMutation::class,
                \App\GraphQL\Mutations\Member\UpdatePositionMutation::class,
                \App\GraphQL\Mutations\Member\AttendanceMutation::class
            ],

            'types' => [
                \App\GraphQL\Types\MemberType::class,
                \App\GraphQL\Types\WrapperMemberType::class,
                \App\GraphQL\Types\CalendarType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
