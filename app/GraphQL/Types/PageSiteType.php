<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PageSiteType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PageSiteType',
        'description' => 'Page site type',
    ];

    public function fields(): array
    {
        return [
            'title' => [
                'type' => Type::string(),
            ],
            'solution_name' => [
                'type' => Type::string(),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'keywords' => [
                'type' => Type::string(),
            ],
            'author' => [
                'type' => Type::string(),
            ],
            'is_user_join' => [
                'type' => Type::boolean(),
            ],
            'is_open_type' => [
                'type' => Type::boolean(),
            ],
            'captcha' => [
                'type' => Type::boolean(),
            ],
            'enable_consultation' => [
                'type' => Type::boolean(),
            ],
            'require_read_note' => [
                'type' => Type::boolean(),
            ],
            'is_required_reply' => [
                'type' => Type::boolean(),
            ],
            'banks' => [
                'type' => Type::listOf(Type::string()),
            ],
            'siLogo1' => [
                'type' => Type::string(),
            ],
            'siLogo2' => [
                'type' => Type::string(),
            ],
            'siLogo3' => [
                'type' => Type::string(),
            ],
            'siLogoFavicon' => [
                'type' => Type::string(),
            ],
        ];
    }
}
