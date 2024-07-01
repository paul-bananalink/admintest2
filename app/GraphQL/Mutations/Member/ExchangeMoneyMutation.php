<?php

namespace App\GraphQL\Mutations\Member;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Models\Member;
use App\Services\MemberService;
use App\Services\MoneyInfoService;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ExchangeMoneyMutation extends Mutation
{
    public function __construct(
        private MemberService $memberService,
        private MoneyInfoService $moneyInfoService,
    ) {
    }

    protected $attributes = [
        'name' => 'ExchangeMoneyMutation',
        'description' => 'Exchange money between wallets'
    ];

    public function type(): Type
    {
        return GraphQL::type('MemberType');
    }

    public function args(): array
    {
        return [
            'from' => ['type' => Type::string(), 'description' => 'from wallet, wallet is one of casino_slot, sports, point'],
            'to' => ['type' => Type::string(), 'description' => 'to from wallet, wallet is one of casino_slot, sports'],
            'amount' => ['type' => Type::float(), 'description' => 'amount'],
        ];
    }

    public function rules(array $args = []): array
    {
        if (!app('site_info')->siIsTransferMoney && !$this->moneyInfoService->checkWithdrawEnable($args['from'])) {
            throw new \App\Exceptions\GraphQLException("롤링 완료 후 머니이동가능합니다");
        }

        if ($args['from'] == $args['to']) {
            throw new \App\Exceptions\GraphQLException(__('from_diff_to'));
        }

        if (empty(Member::MEMBER_WALLETS[$args['from']])) {
            throw new \App\Exceptions\GraphQLException(__('in_casino_sports'));
        }

        if (empty(Member::MEMBER_WALLETS[$args['to']])) {
            throw new \App\Exceptions\GraphQLException(__('in_casino_sports'));
        }

        if ($args['amount'] == 0) {
            throw new \App\Exceptions\GraphQLException("이동금액은 최소 0원 이상이어야 합니다");
        }

        $member = auth()->user();
        $field = Member::MEMBER_WALLETS[$args['from']];
        $money = $member->{$field} ?? 0;

        if ($money < $args['amount']) {
            throw new \App\Exceptions\GraphQLException(__('validation.wallet_not_enough'));
        }

        return [
            'from' => ['required', 'string', 'in:' . implode(',', array_keys(Member::MEMBER_WALLETS))],
            'to' => ['required', 'string', 'in:' . implode(',', [Member::WALLET_SPORTS, Member::WALLET_CASINO_SLOT])],
            'amount' => [
                'required',
                'max:2000000000'
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $member = $this->memberService->exchangeMoney($args['from'], $args['to'], $args['amount']);

        return $member;
    }
}
