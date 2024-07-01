<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Member;

use App\Exceptions\GraphQLException;
use App\Services\MemberService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class LogoutMutation extends Mutation
{
    public function __construct(private MemberService $memberService)
    {
    }

    protected $attributes = [
        'name' => 'LogoutMutation',
        'description' => 'Logout mutation',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            $this->memberService->logoutApi();

            return true;
        } catch (GraphQLException $exception) {
            return false;
        }
    }
}
