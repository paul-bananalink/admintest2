<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Note;

use App\Services\GraphQL\NoteService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NoteListQuery extends Query
{
    public function __construct(
        private NoteService $noteService
    ) {
    }

    protected $attributes = [
        'name' => 'note',
        'description' => 'Note Query',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('noteType');
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
        return $this->noteService->paginate($args);
    }
}
