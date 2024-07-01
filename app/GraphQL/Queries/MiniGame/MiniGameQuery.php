<?php

namespace App\GraphQL\Queries\MiniGame;

use App\Services\MinigameResultService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class MiniGameQuery extends Query
{
    public function __construct(
        private MinigameResultService $minigameResultService,
    ) {
    }

    protected $attributes = [
        'name' => 'MiniGame',
        'description' => 'Minigame info',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('MiniGameType'));
    }

    protected function rules(array $args = []): array
    {
        $game = $args['game'] ?? null;
        $modes = config('minigame.mode.' . $game, []);

        return [
            'game' => 'required|exists:minigame,mgName',
            'mode' => [
                'nullable',
                $game && !empty($modes) ? 'required_if:game,' . $game : 'nullable',
                $game && !empty($modes) ? 'in:' . implode(',', $modes) : 'nullable',
            ],
        ];
    }

    public function args(): array
    {
        return [
            'game' => [
                'name' => 'game',
                'type' => Type::nonNull(Type::string()),
                'alias' => 'mgName'
            ],
            'mode' => [
                'name' => 'mode',
                'type' => Type::string(),
                'alias' => 'mgrMode',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->minigameResultService->getGameResults($args);
    }
}
