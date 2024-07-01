<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;

class BetHistoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'BetHistoryType',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'uuid' => [
                'type' => Type::string(),
                'description' => 'uuid',
            ],
            'mID' => [
                'type' => Type::string(),
                'description' => 'Member id',
            ],
            'pCode' => [
                'type' => Type::string(),
                'description' => 'Provider code',
            ],
            'gCode' => [
                'type' => Type::string(),
                'description' => 'Game code',
            ],
            'gName' => [
                'type' => Type::string(),
                'description' => 'Game name',
            ],
            'gNameEn' => [
                'type' => Type::string(),
                'description' => 'Game name en',
            ],
            'gCategory' => [
                'type' => Type::string(),
                'description' => 'Game category',
            ],
            'tRoundId' => [
                'type' => Type::string(),
                'description' => 'Round id',
            ],
            'tType' => [
                'type' => Type::string(),
                'description' => 'Transaction type',
                'resolve' => function ($root) {
                    return $root->tType;
                },
            ],
            'tAmount' => [
                'type' => Type::string(),
                'description' => 'Amount',
                'resolve' => function ($root) {
                    return formatNumber((string)$root->tAmount);
                },
            ],
            'tAmountReturn' => [
                'type' => Type::string(),
                'description' => 'Amount Return',
                'resolve' => function ($root) {
                    return formatNumber((string)$root->calcAmountCasinoAndSlotWin());
                },
            ],
            'tReferenceUuid' => [
                'type' => Type::string(),
                'description' => 'Reference uuid',
            ],
            'tRoundStarted' => [
                'type' => Type::string(),
                'description' => 'Round started',
            ],
            'tRoundFinished' => [
                'type' => Type::string(),
                'description' => 'Round finished',
            ],
            'tDetails' => [
                'type' => Type::string(),
                'description' => 'Transaction details',
            ],
            'tRegDate' => [
                'type' => Type::string(),
                'description' => 'Created date',
            ],
            'tUpdateDate' => [
                'type' => Type::string(),
                'description' => 'Updated date',
            ]
        ];
    }
}
