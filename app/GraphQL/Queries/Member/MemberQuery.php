<?php

namespace App\GraphQL\Queries\Member;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class MemberQuery extends Query
{
    protected $attributes = [
        'name' => 'MemberQuery',
        'description' => 'Member info',
    ];

    public function type(): Type
    {
        return GraphQL::type('MemberType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $member = auth()->guard(config('constant_view.GUARD.SANCTUM'))->user();

        return $member;
    }
}
