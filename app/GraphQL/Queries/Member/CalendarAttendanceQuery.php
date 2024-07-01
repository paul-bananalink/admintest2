<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Member;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use App\Services\MemberAttendanceService;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CalendarAttendanceQuery extends Query
{
    public function __construct(private MemberAttendanceService $memberAttendanceService)
    {
    }

    protected $attributes = [
        'name' => 'CalendarAttendanceQuery',
        'description' => 'A query to get the calendar attendance of the member.'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('CalendarType'));
    }

    public function args(): array
    {
        return [
            'month' => [
                'type' => Type::string(),
                'description' => 'start date to get the calendar, format is Y-m, ex: 2024-06',
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->memberAttendanceService->getCalendar($args);
    }
}
