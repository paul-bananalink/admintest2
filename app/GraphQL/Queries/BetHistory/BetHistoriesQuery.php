<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\BetHistory;

use App\Services\TransactionService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BetHistoriesQuery extends Query
{
    public function __construct(private TransactionService $transactionService)
    {
    }

    protected $attributes = [
        'name' => 'BetHistoriesQuery',
        'description' => 'Bet histories query'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('BetHistoryType');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'offset' => [
                'name' => 'offset',
                'type' => Type::int(),
            ],

            'category' => [
                'name' => 'category',
                'type' => Type::string(),
                'description' => 'Category'
            ],
            'start_date' => [
                'name' => 'start_date',
                'type' => Type::string(),
                'description' => 'Start date format d/m/Y'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->transactionService->betHistories($args);
    }
}
