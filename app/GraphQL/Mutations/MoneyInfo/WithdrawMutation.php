<?php

namespace App\GraphQL\Mutations\MoneyInfo;

use App\Models\MoneyInfo;
use App\Models\Member;
use App\Models\WithdrawConfig;
use App\Repositories\MoneyInfoRepository;
use App\Rules\VerifyExchangePWRule;
use App\Services\MoneyInfoService;
use App\Services\WithdrawConfigService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class WithdrawMutation extends Mutation
{
    public function __construct(
        private MoneyInfoService $moneyInfoService,
        private MoneyInfoRepository $moneyInfoRepository,
        private WithdrawConfigService $withdrawConfigService,
    ) {
    }

    protected $attributes = [
        'name' => 'WithdrawMutation',
        'description' => 'Member withdraw money',
    ];

    public function type(): Type
    {
        return GraphQL::type('MoneyInfoType');
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        $this->validateMoney($args['amount'], $args['wallet']);

        return [
            'amount' => [
                'required',
                'integer'
            ],
            'wallet' => ['required', 'string', 'max:255', 'in:' . Member::WALLET_CASINO_SLOT . ',' . Member::WALLET_SPORTS],
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
            'amount' => '입금하실 금액(원)',
            'wallet' => '지갑',
        ];
    }

    private function validateMoney($amount, $wallet)
    {
        /** @var Member $member */

        $member = auth()->user();

        if (!in_array($wallet, array_keys(Member::MEMBER_WALLETS))) {
            throw new \Exception("지갑이 유효하지 않습니다");
        }

        if (!$this->moneyInfoService->checkWithdrawEnable($wallet)) {
            throw new \Exception("롤링 완료 후 출금가능합니다");
        }

        $isWithdrawLimit = $member->memberConfig->mcIsWithdrawLimit ?? false;
        if ($isWithdrawLimit) {
            throw new \Exception('출금 제한되었습니다');
        }

        if ($amount == 0) {
            throw new \Exception('출금금액은 최소 0원 이상이어야 합니다');
        }

        /** @var WithdrawConfig */
        $withdrawConfig = $this->withdrawConfigService->getConfig();

        /* check config not allow withdraw*/
        if (!$withdrawConfig->wcEnableWithdraw) {
            throw new \Exception("$withdrawConfig->wcDisableWithdrawContent");
        }

        /* check config min money withdraw*/
        if ($amount < $withdrawConfig->wcMinWithdraw) {
            $wcMinWithdraw = formatNumber($withdrawConfig->wcMinWithdraw);
            throw new \Exception("환전금액은 최소 {$wcMinWithdraw}원 이상이어야 합니다");
        }

        if (!in_array($wallet, [Member::WALLET_CASINO_SLOT, Member::WALLET_SPORTS])) {
            throw new \Exception('돈 지갑이 유효하지 않습니다.');
        }

        $site_money = app('site_info')->siOptionMinWithraw ?? null;
        if ($site_money && $amount < $site_money) {
            throw new \Exception('최소 ' . formatNumber($site_money) . ' 이상 충전신청을 해야합니다.');
        }

        if ($wallet == Member::WALLET_CASINO_SLOT) {
            $mMoney = $member->mMoney;
            if ($mMoney < $amount) {
                throw new \Exception('출금 금액이 보유 금액보다 많습니다.');
            }
        } elseif ($wallet == Member::WALLET_SPORTS) {
            $mSportsMoney = $member->mSportsMoney;
            if ($mSportsMoney < $amount) {
                throw new \Exception('출금 금액이 보유 금액보다 많습니다.');
            }
        }

        /* check limit time withdraw for current member*/
        if ($withdrawConfig->wcEnableDelayTime) {
            $regDate = $this->moneyInfoService->getLatestRegDateByType($member, MoneyInfo::TYPE_UW);
            if ($regDate) {
                $diffSends = $regDate->diffInSeconds(now());
                if ($diffSends < $withdrawConfig->wcDelayTime) {
                    // $timeWaiting = (int) ($withdrawConfig->wcDelayTime - $diffSends);
                    throw new \Exception("잠시 후 신청해주세요.");
                }
            }
        }

        $mLevel = $member->mLevel;
        if ($mLevel) {
            /* max withdraw per day */
            $wcMaxWithdrawPerDay = $withdrawConfig->wcMaxRechargePerDay[(int)$mLevel];
            $sumMoneyWithdrawPerDay = $this->moneyInfoRepository->sumMoneyPerDay($member, MoneyInfo::TYPE_UW);

            if (abs($sumMoneyWithdrawPerDay) + $amount > $wcMaxWithdrawPerDay) {
                $formatted = formatNumber($wcMaxWithdrawPerDay);
                throw new \Exception("1일에 출금금액은{$formatted}원을 초과할 수 없습니다.");
            }

            /* max withdraw per time */
            $moneyWithdrawMax = $withdrawConfig->wcMaxRechargePerTime[$mLevel];

            if ($amount > $moneyWithdrawMax) {
                $moneyWithdrawMax = formatNumber($moneyWithdrawMax);
                throw new \Exception("환전금액은 최대 {$moneyWithdrawMax}원 이하이어야 합니다");
            }
        }

        /* check time not allow withdraw*/
        $timeEnd = $this->isTimeInRange($withdrawConfig->wcTimeOffWithdraw);
        if (!empty($withdrawConfig->wcTimeOffWithdraw) && $timeEnd) {
            $endTimeParts = explode(':', $timeEnd);
            $hours = $endTimeParts[0];
            $minutes = $endTimeParts[1];
            throw new \Exception("출금신청 금지시간 중입니다. {$hours}시 {$minutes}분 후에 출금신청이 가능합니다");
        }
    }

    public function isTimeInRange($timeRange): bool|string
    {
        // Split the time range into start and end times
        $times = explode(' - ', $timeRange);
        // Get the current time in the format HH:MM
        $currentTime = date('H:i');
        // Compare current time with start and end times
        if ($currentTime >= $times[0] && $currentTime <= $times[1]) {
            return $times[1];
        } else {
            return false;
        }
    }

    /**
     * Define custom Laravel Validator messages as per Laravel 'custom error messages'.
     *
     * @param  array  $args  submitted arguments
     */
    public function validationErrorMessages(array $args = []): array
    {
        return [
            'amount.required' => __('validation.required')
        ];
    }

    public function args(): array
    {
        return [
            'amount' => [
                'name' => 'amount',
                'type' => Type::int(),
                'alias' => 'miBankMoney',
            ],
            'wallet' => [
                'name' => 'wallet',
                'type' => Type::string(),
                'alias' => 'miWallet',
                'description' => 'types includes: ' . Member::WALLET_CASINO_SLOT . ', ' . Member::WALLET_SPORTS,
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $args['miType'] = MoneyInfo::TYPE_UW;

        return $this->moneyInfoService->create($args);
    }
}
