<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Member;

use App\Models\Member;
use App\Services\MemberService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class UpdatePositionMutation extends Mutation
{
    public function __construct(private MemberService $memberService)
    {
    }

    protected $attributes = [
        'name' => 'UpdatePositionMutation',
        'description' => 'A mutation to update the position of a member'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [
            'position' => 'required',
        ];
    }

    public function args(): array
    {
        return [
            'position' => [
                'name' => 'position',
                'type' => Type::nonNull(Type::string()),
                'description' => 'The new position of the member',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->memberService->updatePosition($args);
    }
}
