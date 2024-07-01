<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Auth;

use App\Services\MemberService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class HasMemberQuery extends Query
{
    public function __construct(private MemberService $memberService)
    {
    }

    protected $attributes = [
        'name' => 'HasMemberQuery',
        'description' => 'Has member query',
    ];

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [
            'member_id' => [
                'nullable',
                'min:6',
                'regex:/^[^\W_]+$/', // only a-z,A-Z,0-9
            ],
            'member_nick' => [
                'nullable',
                new \App\Rules\CheckMemberValid,
            ],
            'member_invite' => [
                'nullable',
                'exists:member,mPartnerCode',
            ],
        ];
    }

    /**
     * Define custom Laravel Validator messages as per Laravel 'custom error messages'.
     *
     * @param  array  $args  submitted arguments
     */
    public function validationErrorMessages(array $args = []): array
    {
        return [
            'member_id.min' => __('validation.min'),
            'member_id.regex' => __('validation.regex', ['attribute' => 'a~z, 0~9만',]),


            'member_nick.min' => __('validation.min'),
            'member_nick.regex' => __('validation.regex', ['attribute' => 'a~z, 0~9만',]),

            'member_invite.exists' => __('validation.member_invite_exists'),
        ];
    }

    /**
     * Define custom Laravel Validator attributes as per Laravel 'custom attributes'.
     *
     * @param  array<string,mixed>  $args  submitted arguments
     * @return array<string,string>
     */
    public function validationAttributes(array $args = []): array
    {
        return [
            'member_id' => '아이디를',
            'member_nick' => '닉네임을',
            'member_invite' => '추천인',
        ];
    }

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'member_id' => [
                'name' => 'member_id',
                'type' => Type::string(),
                'alias' => 'mID',
            ],
            'member_nick' => [
                'name' => 'member_nick',
                'type' => Type::string(),
                'alias' => 'mNick',
            ],
            'member_invite' => [
                'name' => 'member_invite',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->memberService->hasMember($args);
    }
}
