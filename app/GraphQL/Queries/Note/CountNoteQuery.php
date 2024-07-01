<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Note;

use App\Services\GraphQL\NoteService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class CountNoteQuery extends Query
{
    public function __construct(
        private NoteService $noteService
    ) {
    }

    protected $attributes = [
        'name' => 'countNoteNoRead',
        'description' => 'Count note no read show notification',
    ];

    public function type(): Type
    {
        return GraphQL::type('countType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->noteService->countNote();
    }
}
