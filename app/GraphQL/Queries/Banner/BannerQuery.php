<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Banner;

use App\Services\GraphQL\BannerService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class BannerQuery extends Query
{
    public function __construct(private BannerService $bannerService)
    {
    }

    protected $attributes = [
        'name' => 'BannerQuery',
        'description' => 'Banner query'
    ];

    public function type(): Type
    {
        return GraphQL::type('BannerType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->bannerService->getBanner();
    }
}
