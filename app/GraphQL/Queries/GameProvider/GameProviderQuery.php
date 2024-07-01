<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\GameProvider;

use App\Models\GameProvider;
use App\Services\GameProviderService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class GameProviderQuery extends Query
{
    public function __construct(private GameProviderService $gameProviderService)
    {
    }

    protected $attributes = [
        'name' => 'GameProvider',
        'description' => 'Get provider and game list'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('GameType');
    }

    protected function rules(array $args = []): array
    {
        return [
            'category' => 'required|in:' . implode(',', array_keys(GameProvider::$categories))
        ];
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
                'alias' => 'category'
            ],
            'provider_code' => [
                'name' => 'provider_code',
                'type' => Type::string(),
                'alias' => 'gpCode'
            ],
            'search' => [
                'name' => 'search',
                'type' => Type::string(),
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->gameProviderService->getGameProvider($args);
    }
}
