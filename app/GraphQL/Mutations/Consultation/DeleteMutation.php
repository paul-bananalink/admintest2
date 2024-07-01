<?php

namespace App\GraphQL\Mutations\Consultation;

use App\Services\GraphQL\ConsultationService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class DeleteMutation extends Mutation
{
    public function __construct(private ConsultationService $consultationService)
    {
    }

    protected $attributes = [
        'name' => 'deleteItemsMutation',
        'description' => 'Delete list item by id consultation Example: ids=1,2,3,4',
    ];

    public function type(): Type
    {
        return GraphQL::type('deleteType');
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [
            'ids' => ['required'],
        ];
    }

    public function args(): array
    {
        return [
            'ids' => [
                'name' => 'ids',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->consultationService->deleteByListId($args);
    }
}
