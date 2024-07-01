<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Consultation;

use App\Services\GraphQL\ConsultationService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NextTimeConsultationQuery extends Query
{
    public function __construct(
        private ConsultationService $consultationService
    ) {
    }

    protected $attributes = [
        'name' => 'nextConsultationTimeQuery',
        'description' => 'Next consultation time',
    ];

    public function type(): Type
    {
        return GraphQL::type('nextTimeConsultationType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->consultationService->getNextTimeConsultation();
    }
}
