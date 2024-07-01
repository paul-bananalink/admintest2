<?php

namespace App\GraphQL\Mutations\Note;

use App\Services\GraphQL\NoteService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class ReadAllNoteMutation extends Mutation
{
    public function __construct(private NoteService $noteService)
    {
    }

    protected $attributes = [
        'name' => 'readAllNoteMutation',
        'description' => 'Member read all note',
    ];

    public function type(): Type
    {
        return GraphQL::type('readType');
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [];
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->noteService->updateReadAll();
    }
}
