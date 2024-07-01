<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class PopupSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Popup\PopupListQuery::class
            ],

            'types' => [
                \App\GraphQL\Types\Popup\ItemType::class
            ],
        ];
    }
}
