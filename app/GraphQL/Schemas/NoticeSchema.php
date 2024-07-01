<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class NoticeSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Notice\NoticeQuery::class,
                \App\GraphQL\Queries\Notice\CategoryNoticeQuery::class
            ],

            'types' => [
              \App\GraphQL\Types\Notice\NoticeType::class,
              \App\GraphQL\Types\Notice\ItemCategoryNoticeRule::class,
            ],
        ];
    }
}
