<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class WithdrawConfigType extends GraphQLType
{
    protected $attributes = [
        'name' => 'WithdrawConfigType',
        'description' => 'A type',
    ];

    public function fields(): array
    {
        return [
            'wc_rules' => [
                'type' => Type::string(),
            ],
            'wc_manual_withdraw' => [
                'type' => Type::boolean(),
            ],
            'wc_exchange_rules' => [
                'type' => Type::string(),
            ],
        ];
    }
}
