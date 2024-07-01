<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Member;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use App\Services\MemberAttendanceService;

class AttendanceMutation extends Mutation
{
    public function __construct(private MemberAttendanceService $memberAttendanceService)
    {
    }

    protected $attributes = [
        'name' => 'AttendanceMutation',
        'description' => 'Mutation for member attendance.'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->memberAttendanceService->attendance();
    }
}
