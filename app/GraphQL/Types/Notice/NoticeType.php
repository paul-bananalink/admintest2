<?php

namespace App\GraphQL\Types\Notice;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NoticeType extends GraphQLType
{
    protected $attributes = [
        'name' => 'NoticeType',
        'description' => 'A type for Notice'
    ];

    public function fields(): array
    {
        return [
            'ntNo' => [
                'type' => Type::int(),
                'description' => 'Notice number',
            ],
            'ntTitle' => [
                'type' => Type::string(),
                'description' => 'Notice title',
            ],
            'ntContent' => [
                'type' => Type::string(),
                'description' => 'Notice content',
            ],
            'ntStatus' => [
                'type' => Type::int(),
                'description' => 'Notice status',
            ],
            'ntLogo' => [
                'type' => Type::string(),
                'description' => 'Notice logo',
                'resolve' => function($root) {
                    return $root->ntLogo ? formatImageUrlAdmin($root->ntLogo) : null;
                },
            ],
            'ntImage' => [
                'type' => Type::string(),
                'description' => 'Notice image',
                'resolve' => function($root) {
                    return $root->ntImage ? formatImageUrlAdmin($root->ntImage) : null;
                },
            ],
            'ntType' => [
                'type' => Type::string(),
                'description' => 'Notice type',
            ],
            'ntCategory' => [
                'type' => Type::string(),
                'description' => 'Notice category',
            ],
            'ntPartnerType' => [
                'type' => Type::string(),
                'description' => 'Notice partner type',
            ],
            'ntRegDate' => [
                'type' => Type::string(),
                'description' => 'Notice registration date',
            ],
            'ntUpdateDate' => [
                'type' => Type::string(),
                'description' => 'Notice update date',
            ],
        ];
    }
}
