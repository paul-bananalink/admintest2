<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class ConsultationSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Consultation\ConsultationListQuery::class,
                \App\GraphQL\Queries\Consultation\CheckRequireReplyQuery::class,
                \App\GraphQL\Queries\Consultation\NextTimeConsultationQuery::class,
            ],

            'mutation' => [
                \App\GraphQL\Mutations\Consultation\MemberCreateMutation::class,
                \App\GraphQL\Mutations\Consultation\MemberAutoCreateMutation::class,
                \App\GraphQL\Mutations\Consultation\DeleteMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\Consultation\CreateType::class,
                \App\GraphQL\Types\Consultation\ItemType::class,
                \App\GraphQL\Types\Consultation\CheckRequireReplyType::class,
                \App\GraphQL\Types\Consultation\DeleteType::class,
                \App\GraphQL\Types\Consultation\NextTimeConsultationType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
