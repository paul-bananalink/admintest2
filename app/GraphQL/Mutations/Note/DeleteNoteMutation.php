<?php

namespace App\GraphQL\Mutations\Note;

use App\Services\GraphQL\NoteService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class DeleteNoteMutation extends Mutation
{
    public function __construct(private NoteService $noteService)
    {
    }

    protected $attributes = [
        'name' => 'deleteNoteMutation',
        'description' => 'Member delete note',
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
        return $this->noteService->delete($args);
    }
}
