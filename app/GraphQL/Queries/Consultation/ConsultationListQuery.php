<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Consultation;

use App\Services\GraphQL\ConsultationService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ConsultationListQuery extends Query
{
    public function __construct(
        private ConsultationService $consultationService
    ) {
    }

    protected $attributes = [
        'name' => 'consultation',
        'description' => 'Consultation list query',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('itemType');
    }

    public function args(): array
    {
        return [
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->consultationService->getList($args);
    }
}
