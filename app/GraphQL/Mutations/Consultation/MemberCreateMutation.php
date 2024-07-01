<?php

namespace App\GraphQL\Mutations\Consultation;

use App\Services\GraphQL\ConsultationService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class MemberCreateMutation extends Mutation
{
    public function __construct(
        private ConsultationService $consultationService
    ) {
    }

    protected $attributes = [
        'name' => 'memberCreateMutation',
        'description' => 'Member Create Consultation',
    ];

    public function type(): Type
    {
        return GraphQL::type('createType');
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        $time = $this->consultationService->getNextTimeConsultation();
        if ($time && now()->lt($time)) {
            throw new \App\Exceptions\GraphQLException("잠시 후 문의해주세요");
        }

        return [
            'title' => ['required', 'max:190'],
            'content' => ['required'],
        ];
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
            ],
            'content' => [
                'name' => 'content',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->consultationService->create($args);
    }
}
