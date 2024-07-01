<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Notice;

use App\Services\GraphQL\NoticeService;
use Closure;
use Error;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NoticeQuery extends Query
{
    public function __construct(
        private NoticeService $noticeService
    ) {
    }
    protected $attributes = [
        'name' => 'noticeType',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('NoticeType');
    }

    public function args(): array
    {
        return [
            'ntType' => [
                'name' => 'ntType',
                'type' => Type::string(),
                'description' => 'check ntType.(rule, event, partner, vote)',
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'filter' => [
                'name' => 'filter',
                'type' => Type::string(),
                'description' => 'Filter by ex search by category id: {"name": "category"}
                                  Rules => notice, betting_rules, user_guide, faq.
                                  Events => new, rank, special, mini_game, casino, season_event, on_going.'
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (!isset($args['ntType']) || empty($args['ntType'])) {
            throw new Error('The ntType argument is required.');
        }

        return $this->noticeService->paginate($args);
    }
}
