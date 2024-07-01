<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Game;

use App\Services\GameService;
use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class GameQuery extends Query
{
    public function __construct(private GameService $gameService)
    {
    }

    protected $attributes = [
        'name' => 'GameQuery',
        'description' => 'Get detail of game, return a url to launch game'
    ];

    public function type(): Type
    {
        return GraphQL::type('LaunchGameType');
    }

    public function attributes(): array
    {
        return [
            'provider_code' => '회원 ID',
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'provider_code' => ['required', 'exists:game_provider,gpCode'],
            'game_code' => ['nullable', 'exists:game,gCode'],
        ];
    }

    public function args(): array
    {
        return [
            'provider_code' => [
                'name' => 'provider_code',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Unique identifier of the game provider. Required',
                'alias' => 'providerCode'
            ],
            'game_code' => [
                'name' => 'game_code',
                'type' => Type::string(),
                'description' => 'Unique identifier of the game within the game provider. If not specified or null, a link to the provider lobby will be returned. Required',
                'alias' => 'gameCode'
            ],
            'country_code' => [
                'name' => 'country_code',
                'type' => Type::string(),
                'description' => 'Country of the player in ISO 3166-1 alpha-2 standard. E.g: GB, ES, IT, KR, JP',
                'alias' => 'countryCode'
            ],
            'locale_code' => [
                'name' => 'locale_code',
                'type' => Type::string(),
                'description' => 'Language of the player in ISO 639-1 standard. E.g: en, fr, it, ko, ja',
                'alias' => 'localeCode'
            ],
            'is_mobile' => [
                'name' => 'is_mobile',
                'type' => Type::boolean(),
                'description' => 'True if agent wants to launch the game on a mobile device. Default value is false.',
                'alias' => 'isMobile'
            ],
            'is_iframe' => [
                'name' => 'is_iframe',
                'type' => Type::boolean(),
                'description' => 'True if agent wants to embed the game window inside an iframe. Default value is false.',
                'alias' => 'isIframe'
            ],
            'lobby_url' => [
                'name' => 'lobby_url',
                'type' => Type::string(),
                'description' => 'URL for returning to agent’s own lobby page. This link is used for Back to Lobby (Home) button in mobile version of games.',
                'alias' => 'lobbyUrl'
            ],
            'cashier_url' => [
                'name' => 'cashier_url',
                'type' => Type::string(),
                'description' => 'URL for opening the agent’s own cashier page when a player has no funds.',
                'alias' => 'cashierUrl'
            ],
            'close_url' => [
                'name' => 'close_url',
                'type' => Type::string(),
                'description' => 'URL to which the player will be redirected if they choose to close the game.E.g https://usertest.spobulls.net/',
                'alias' => 'closeUrl'
            ],
            'bet_limit_min' => [
                'name' => 'bet_limit_min',
                'type' => Type::float(),
                'description' => 'Minimum amount of bet allowed.',
                'alias' => 'betLimitMin'
            ],
            'bet_limit_max' => [
                'name' => 'bet_limit_max',
                'type' => Type::float(),
                'description' => 'Maximum amount of bet allowed.',
                'alias' => 'betLimitMax'
            ],
            'win_limit_max' => [
                'name' => 'winLimitMax',
                'type' => Type::float(),
                'description' => 'Maximum amount of win allowed.',
                'alias' => 'winLimitMax'
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $url = $this->gameService->getGameUrl($args);

        return ['url' => $url ?? null];
    }
}
