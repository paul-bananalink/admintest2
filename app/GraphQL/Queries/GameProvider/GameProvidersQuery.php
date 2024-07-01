<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\GameProvider;

use App\Services\GameProviderService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class GameProvidersQuery extends Query
{
    public function __construct(private GameProviderService $gameProviderService)
    {
    }

    protected $attributes = [
        'name' => 'GameProviders',
        'description' => 'Get game provider list'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('GameProviderType');
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
            'categories' => [
                'name' => 'categories',
                'type' => Type::string(),
                'description' => 'Game categories is "slot is Slot, Slot + Live Casino" - "casino is Live Casino, Slot + Live Casino" '
            ],
            'game_providers' => [
                'name' => 'game_providers',
                'type' => Type::string(),
                'description' => 'Game providers is string separated by commas'
            ],
            'search' => [
                'name' => 'search',
                'type' => Type::string(),
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->gameProviderService->getGameProviders($args);
    }
}
