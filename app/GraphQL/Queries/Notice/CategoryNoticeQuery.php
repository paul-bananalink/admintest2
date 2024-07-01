<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Notice;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use App\Services\GraphQL\NoticeService;
use Error;

class CategoryNoticeQuery extends Query
{
    public function __construct(
        private NoticeService $noticeService
    ) {
    }

    protected $attributes = [
        'name' => 'categoryNotice',
        'description' => 'Category NewsBoard List Query',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('itemCategoryNotice'));
    }

    public function args(): array
    {
        return [
            'ntType' => [
                'name' => 'ntType',
                'type' => Type::string(),
                'description' => 'check ntType.(rule, event, partner, vote)',
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (!isset($args['ntType']) || empty($args['ntType'])) {
            throw new Error('The ntType argument is required.');
        }

        return $this->noticeService->categoryList($args);
    }
}
