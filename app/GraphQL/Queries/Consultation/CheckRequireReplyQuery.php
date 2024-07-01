<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Consultation;

use App\Services\GraphQL\ConsultationService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class CheckRequireReplyQuery extends Query
{
    public function __construct(
        private ConsultationService $consultationService
    ) {
    }

    protected $attributes = [
        'name' => 'checkRequireReplyQuery',
        'description' => 'Check require reply consultation',
    ];

    public function type(): Type
    {
        return GraphQL::type('checkRequireReplyType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $site = app('site_info');

        if (data_get($site, 'siRequiredReply', false)) {
            return $this->consultationService->checkRequireReply();
        }
        return false;
    }
}
