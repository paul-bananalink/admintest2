<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Popup;

use App\Services\PopupService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PopupListQuery extends Query
{
    public function __construct(
        private PopupService $popupService
    ) {
    }

    protected $attributes = [
        'name' => 'popupList',
        'description' => 'A query of popup list',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('itemType'));
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->popupService->getDataApi($args);
    }
}
