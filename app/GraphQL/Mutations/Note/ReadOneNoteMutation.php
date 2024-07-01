<?php

namespace App\GraphQL\Mutations\Note;

use App\Services\GraphQL\NoteService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class ReadOneNoteMutation extends Mutation
{
    public function __construct(private NoteService $noteService)
    {
    }

    protected $attributes = [
        'name' => 'readOneNoteMutation',
        'description' => 'Member read one note',
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
        return [
            'id' => ['required'],
        ];
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->noteService->updateRead($args);
    }
}
