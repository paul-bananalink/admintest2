<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\GameProvider;

class GameProviderType extends GraphQLType
{
    protected $attributes = [
        'name' => 'GameProviderType',
        'description' => 'Game provider type',
        'model' => GameProvider::class
    ];

    public function fields(): array
    {
        return [
            'gpNo' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Game provider number',
            ],
            'gpCode' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Provider code',
            ],
            'gpName' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Provider name',
            ],
            'gpNameEn' => [
                'type' => Type::string(),
                'description' => 'Provider name english',
            ],
            'gpCategory' => [
                'type' => Type::string(),
                'description' => 'Provider category',
            ],
            'gpImage' => [
                'type' => Type::string(),
                'description' => 'Provider Avatar',
                'resolve' => function ($root) {
                    return $root->jsonImagesByType('avatar');
                },
            ],
            'gpLogo' => [
                'type' => Type::string(),
                'description' => 'Provider Logo',
                'resolve' => function ($root) {
                    return $root->jsonImagesByType('logo');
                },
            ],
            'gpImgBackground' => [
                'type' => Type::string(),
                'description' => 'Provider Background',
                'resolve' => function ($root) {
                    return $root->jsonImagesByType('background');
                },
            ],
            'gpMaintenanceNotice' => [
                'type' => Type::string(),
                'description' => 'Provider Maintenance',
                'resolve' => function ($root) {
                    return '점검중입니다.';
                },
            ],
            'gpMaintenance' => [
                'type' => Type::string(),
                'description' => 'Provider Maintenance object',
                'resolve' => function ($root) {
                    return $root->checkIsMaintenance();
                },
            ]
        ];
    }
}
