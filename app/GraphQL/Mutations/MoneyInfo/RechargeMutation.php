<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\MoneyInfo;

use App\Models\MoneyInfo;
use App\Models\Member;
use App\Models\RechargeConfig;
use App\Services\MoneyInfoService;
use App\Services\RechargeConfigService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class RechargeMutation extends Mutation
{
    public function __construct(
        private MoneyInfoService $moneyInfoService,
        private RechargeConfigService $rechargeConfigService,
    ) {
    }

    protected $attributes = [
        'name' => 'RechargeMutation',
        'description' => 'Recharge mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('MoneyInfoType');
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
            'bonus' => [
                'name' => 'bonus',
                'type' => Type::string(),
                'alias' => 'miBonus',
                'description' => 'has bonus or not, bonus is one of: no_bonus, bonus',
            ],
        ];
    }

    /**
     * @param  array<string,mixed>  $args
     * @return array<string,mixed>
     */
    protected function rules(array $args = []): array
    {
        $this->validateMoney($args['amount'], $args['wallet'], auth()->user());

        $isLimitRecharge = auth()->user()->memberConfig->mcIsRechargeLimit ?? false;
        if ($isLimitRecharge) {
            throw new \Exception('입금 제한되었습니다');
        }

        if ($args['amount'] == 0) {
            throw new \Exception('입금금액은 최소 0원 이상이어야 합니다');
        }

        return [
            'amount' => [
                'required',
                'integer',
                'min:' . (int) app('site_info')->siOptionMinDeposit ?? 0,
                'max:2000000000' // max inter 2b
            ],
            'wallet' => ['required', 'string', 'in:' . Member::WALLET_CASINO_SLOT . ',' . Member::WALLET_SPORTS],
            'bonus' => ['nullable', 'string', 'in:' . implode(',', MoneyInfo::MI_BONUS_TYPE)],
        ];
    }

    private function validateMoney(int $amount, string $wallet, Member $member): void
    {
        $mLevel = (int) $member->mLevel;
        /** @var RechargeConfig */
        $rechargeConfig = $this->rechargeConfigService->getConfig();

        /* check config not allow recharge*/
        if (!$rechargeConfig->rcEnableRecharge) {
            throw new \Exception("$rechargeConfig->rcDisableRechargeContent");
        }

        if (!$this->enableRecharge($rechargeConfig->rcTimeOffRecharge, $rechargeConfig->rcEnableTimeOffRecharge)) {
            throw new \Exception("입금시간이 아닙니다");
        }

        /* check max money member level */
        if ($mLevel) {
            $moneyRechargeMax = $rechargeConfig->rcMaxRecharge[$mLevel];

            if ($amount > $moneyRechargeMax) {
                throw new \Exception("충전금액은 최대 {$moneyRechargeMax}원 이하이어야 합니다");
            }
        }

        /* check config min money recharge */
        if ($amount < $rechargeConfig->rcMinRecharge) {
            $wcMinRecharge = formatNumber($rechargeConfig->rcMinRecharge);
            throw new \Exception("충전금액은 최소 {$wcMinRecharge}원 이상이어야 합니다");
        }
        /* check limit time recharge for current member*/
        $regDate = $this->moneyInfoService->getLatestRegDateByType($member, MoneyInfo::TYPE_UD);

        if ($regDate) {
            $diffSeconds = $regDate->diffInSeconds(now());
            if ($diffSeconds < $rechargeConfig->rcDelayTime) {
                // $timeWaiting = (int) ($rechargeConfig->rcDelayTime - $diffSeconds);
                throw new \Exception("잠시 후 신청해주세요");
            }
        }
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
            'amount.required' => __('validation.required'),
            'amount.min' => '최소 :min 이상 충전신청을 해야합니다.',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $args['miType'] = MoneyInfo::TYPE_UD;

        return $this->moneyInfoService->create($args);
    }

    private function enableRecharge(?string $timeString, $enableTimeOffRecharge)
    {
        if (!$enableTimeOffRecharge && !$timeString) return true;
        return $this->isTimeInRange($timeString);
    }

    private function isTimeInRange(string $timeString)
    {
        $time = explode('-', $timeString);

        if (count($time) !== 2) {
            return false;
        }

        $currentTime = strtotime(date("H:i"));

        $startTime = strtotime($time[0]);
        $endTime = strtotime($time[1]);

        $res = $currentTime >= $startTime && $currentTime <= $endTime;
        return !$res;
    }
}
