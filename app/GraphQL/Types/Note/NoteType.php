<?php

// File: app/GraphQL/Types/EventType.php

namespace App\GraphQL\Types\Note;

use App\Models\Note;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NoteType extends GraphQLType
{
    protected $attributes = [
        'name' => 'noteType',
        'description' => 'Item note',
        'model' => Note::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the note',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the note',
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The content of the note',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Create date note',
            ],
            'is_read' => [
                'type' => Type::nonNull(Type::boolean()),
                'resolve' => function ($root) {
                    if ($root->type == \App\Models\Note::TYPE_ONLY_USER) {
                        return $root->is_read ? true : false;
                    } else {
                        $memberId = auth()->user()->mNo;
                        $mNo_receive_list = json_decode($root->mNo_receive_list, true);

                        return $mNo_receive_list[$memberId] ? true : false;
                    }
                },
            ],

        ];
    }
}
