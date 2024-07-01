<?php

namespace App\GraphQL\Mutations\Member;

use App\Rules\VerifyPasswordRule;
use App\Services\MemberService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdatePasswordMutation extends Mutation
{
    public function __construct(private MemberService $memberService)
    {
    }

    protected $attributes = [
        'name' => 'UpdatePasswordMutation',
        'description' => 'UpdatePassword mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('MemberType');
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        return [
            'password' => ['required', new VerifyPasswordRule],
            'new_password' => [
                'required',
                'same:re_new_password',
                'min:8',
                'max:12',
                'regex:/^(?=.[a-z])(?=.[A-Z])(?=.\d)(?=.[@$!%*#?&]).+$/',
            ],
            're_new_password' => 'required',
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
            'old_password.required' => __('validation.required'),
            'new_password.required' => __('validation.required'),
            're_new_password.required' => __('validation.required'),
        ];
    }

    public function args(): array
    {
        return [
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
            ],
            'new_password' => [
                'name' => 'new_password',
                'type' => Type::string(),
            ],
            're_new_password' => [
                'name' => 're_new_password',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $status = $this->memberService->updatePassword($args);
        if (! $status) {
            return null;
        }

        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();
        $member->accessToken = $this->memberService->getTokenAccessLogin($guard);

        return $member;
    }
}
