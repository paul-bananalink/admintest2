<?php

namespace App\GraphQL\Mutations\Auth;

use App\Exceptions\GraphQLException;
use App\Models\BonusConfig;
use App\Models\MoneyInfo;
use App\Services\MemberService;
use App\Services\MoneyInfoService;
use App\Services\SiteInfoService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\Repositories\BonusConfigRepository;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LoginMutation',
        'description' => 'Login mutation',
    ];

    public function __construct(
        private MemberService $memberService,
        private SiteInfoService $siteInfoService,
        private MoneyInfoService $moneyInfoService,
        private BonusConfigRepository $bonusConfigRepository,
    ) {
    }

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('AuthType'));
    }

    public function args(): array
    {
        return [
            'member_id' => [
                'name' => 'member_id',
                'type' => Type::string(),
                'alias' => 'mID',
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'alias' => 'mPW',
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

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $result = [
            'message' => '',
            'access_token' => null,
            'member' => null,
            'status' => false,
        ];

        $guard = config('constant_view.GUARD.GUEST');

        $is_login = $this->memberService->login($args, $guard);
        if (!$is_login) {
            throw new GraphQLException(__('validation.user_not_found'));
        }

        $result['access_token'] = $this->memberService->getTokenAccessLogin($guard);
        $result['status'] = true;
        $result['message'] = 'Login Success!';
        $result['member'] = auth($guard)->user();
        $result['first_time_login_modal'] = auth($guard)->user()->mIsFirstLogin ? '' : data_get(app('site_info'), 'siMemberFirstTimeLoginContents');
        $result['membership_fee_regulation'] = '';

        if (!auth($guard)->user()->mIsFirstLogin) {
            $config = app(BonusConfig::TYPE_SIGNUP_BONUS);
            $bonusSignup = $this->bonusConfigRepository->getValue($config);
            $result['membership_fee_regulation'] = $bonusSignup['membership_fee_regulation'];
            $attributes = [
                'mID' => auth($guard)->user()->mID,
                'miBankMoney' => (int) $bonusSignup['new_membership_signup_money'],
                'miStatus' => MoneyInfo::STATUS_NINE,
                'miWallet' => MoneyInfo::TYPE_WALLET_POINT,
                'miType' => MoneyInfo::TYPE_AD,
            ];

            /** @var MoneyInfo */
            $this->moneyInfoService->create($attributes);
            $this->memberService->updateFirstLogin(auth($guard)->user());
        }

        return $result;
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */

    protected function rules(array $args = []): array
    {
        $rules = [
            'member_id' => ['required', 'min:6', 'max:255'],
            'password' => ['required', 'min:8', 'max:255'],
        ];

        if (app('site_info')->siEnableCaptcha) {
            $rules['key'] = ['required'];
            $rules['captcha'] = ['required', 'captcha_api:' . data_get($args, 'key')];
        }

        return $rules;
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
            'password.required' => __('validation.required'),
            'key.required' => __('validation.captcha_api'),
            'captcha.captcha_api' => __('validation.captcha_api'),
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
            'password' => '비밀번호를',
            'key' => '키 보안 문자',
            'captcha' => '보안 문자',
        ];
    }
}
