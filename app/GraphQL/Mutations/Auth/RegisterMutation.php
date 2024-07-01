<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\Member;
use App\Models\MemberEnvironment;
use App\Repositories\MemberEnvironmentRepository;
use App\Services\GraphQL\MemberService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class RegisterMutation extends Mutation
{
    protected $attributes = [
        'name' => 'RegisterMutation',
        'description' => 'Register mutation',
    ];

    public function __construct(
        private MemberService $memberService,
        private MemberEnvironmentRepository $memberEnvironmentRepository,
    ) {
    }

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('AuthType'));
    }

    protected function rules(array $args = []): array
    {
        $rules = [
            'member_id' => [
                'required',
                'unique:member,mID',
                'min:6',
                'regex:/^[^\W_]+$/', //Only a-z, 0-9
            ],
            'nick' => [
                'required',
                'unique:member,mNick',
                new \App\Rules\CheckMemberValid,
            ],
            'password' => [
                'required',
                'same:re_password',
                'between:8,16',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&)(]).+$/', //required lowercase, uppercase, number, symbol
            ],
            're_password' => ['required'],
            'bank_owner' => ['required'],
            'bank_name' => ['required'],
            'bank_number' => ['required'],
            'phone' => ['required', new \App\Rules\ValidatePhoneRule],
            'member_invite' => ['required', 'exists:member,mPartnerCode'],
        ];

        if (app('site_info')->siEnableCaptcha) {
            $rules['key'] = ['required'];
            $rules['captcha'] = ['required', 'captcha_api:' . data_get($args, 'key')];
        }

        return $rules;
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
            'nick' => '닉네임을',
            'key' => '키 보안 문자',
            'captcha' => '보안 문자',
            'password' => '비밀번호를',
            're_password' => '비밀번호확인',
            'bank_owner' => '은행 주인',
            'bank_name' => '은행 이름',
            'bank_number' => '은행번호',
            'phone' => '핸드폰',
            'member_invite' => '초대된 회원',
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
            'member_id.required' => __('validation.required'),
            'member_id.unique' => __('validation.unique'),
            'member_id.min' => __('validation.min'),
            'member_id.regex' => __('validation.regex', ['attribute' => 'a~z, 0~9만',]),
            'nick.required' => __('validation.required'),
            'nick.unique' => __('validation.nick_unique'),
            'nick.min' => __('validation.min'),
            'nick.regex' => __('validation.regex', ['attribute' => 'a~z, 0~9만',]),
            'password.required' => __('validation.required', ['attribute' => '비밀번호확인을',]),
            'password.same' => __('validation.same', ['attribute' => '비밀번호가', 'other' => '비밀번호확인과']),
            'password.between' => __('validation.between', ['attribute' => '비밀번호는']),
            'password.regex' => __('validation.password_regex', ['attribute' => 'a~z, 0~9만',]),
            're_password.required' => __('validation.required', ['attribute' => '비밀번호확인을',]),
            'key.required' => __('validation.captcha_api'),
            'captcha.required' => __('validation.captcha_api'),
            'captcha.captcha_api' => __('validation.captcha_api'),
            'bank_owner.required' => __('validation.required', ['attribute' => '계좌주를',]),
            'bank_name.required' => __('validation.required', ['attribute' => '은행 이름을',]),
            'bank_number.required' => __('validation.required', ['attribute' => '계좌 번호를',]),
            'phone.required' => __('validation.required', ['attribute' => '전화 번호를',]),
            'member_invite.required' => __('validation.required', ['attribute' => '추천인 코드를',]),
            'member_invite.exists' => __('validation.exists', ['attribute' => '추천인 코드',]),
        ];
    }

    public function args(): array
    {
        return [
            'member_id' => [
                'name' => 'member_id',
                'type' => Type::string(),
                'alias' => 'mID',
            ],
            'nick' => [
                'name' => 'nick',
                'type' => Type::string(),
                'alias' => 'mNick',
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
            ],
            're_password' => [
                'name' => 're_password',
                'type' => Type::string(),
            ],
            'bank_owner' => [
                'name' => 'bank_owner',
                'type' => Type::string(),
                'alias' => 'mBankOwner',
            ],
            'bank_name' => [
                'name' => 'bank_name',
                'type' => Type::string(),
                'alias' => 'mBankName',
            ],
            'bank_number' => [
                'name' => 'bank_number',
                'type' => Type::string(),
                'alias' => 'mBankNumber',
            ],
            'phone' => [
                'name' => 'phone',
                'type' => Type::string(),
                'alias' => 'mPhone',
            ],
            'member_invite' => [
                'name' => 'member_invite',
                'type' => Type::string(),
                'alias' => 'mMemberID',
            ],
            'key' => [
                'name' => 'key',
                'type' => Type::string(),
            ],
            'captcha' => [
                'name' => 'captcha',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (!app('site_info')->siOpenUserJoin) {
            return [
                'message' => __('validation.user_join_closed'),
                'access_token' => null,
                'member' => null,
                'status' => false,
            ];
        }

        try {
            $member = $this->memberService->register($args);

            $partner = $this->getPartnerByCode($args['mMemberID']);

            $member->mMemberID = $partner->mID;
            $member->save();

            $this->memberEnvironmentRepository->create([
                'mID' => $member->mID,
                'meType' => MemberEnvironment::ME_TYPE_REGISTER,
                'meIP' => request()->ip(),
                'meDeviceID' => request()->header('user-agent', ''),
                'meOS' => '',
            ]);

            $expired_at = now()->addMinutes(app('site_info')->siTimeOUt ?? 120);
            $accessToken = $member ? $member->createToken(uniqid(), expiresAt: $expired_at)->plainTextToken : null;
            $status = true;
            $message = '등록되었습니다';
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $status = false;
        }

        return [
            'message' => $message,
            'access_token' => $accessToken ?? null,
            'member' => $member ?? null,
            'status' => $status,
        ];
    }

    private function getPartnerByCode(string $mPartnerCode): ?Member
    {
        $partner = Member::where('mPartnerCode', $mPartnerCode)->first();

        return $partner;
    }
}
