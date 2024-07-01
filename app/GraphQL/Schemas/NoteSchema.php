<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class NoteSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Note\NoteListQuery::class,
                \App\GraphQL\Queries\Note\CountNoteQuery::class,
            ],

            'mutation' => [
                \App\GraphQL\Mutations\Note\ReadAllNoteMutation::class,
                \App\GraphQL\Mutations\Note\DeleteNoteMutation::class,
                \App\GraphQL\Mutations\Note\UpdateNoticedNoteMutation::class,
                \App\GraphQL\Mutations\Note\ReadOneNoteMutation::class,
            ],

            'types' => [
                \App\GraphQL\Types\Note\NoteType::class,
                \App\GraphQL\Types\Note\ReadType::class,
                \App\GraphQL\Types\Note\ItemReadType::class,
                \App\GraphQL\Types\Note\ItemDeleteType::class,
                \App\GraphQL\Types\Note\DeleteType::class,
                \App\GraphQL\Types\Note\CountType::class,
                \App\GraphQL\Types\Note\NoticedType::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
