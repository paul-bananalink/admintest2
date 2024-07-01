<?php

namespace App\GraphQL\Queries\SiteInfo;

use App\Models\BonusConfig;
use App\Models\Member;
use App\Models\RechargeConfig;
use App\Models\WithdrawConfig;
use App\Repositories\BonusConfigRepository;
use App\Services\GraphQL\MemberService;
use App\Services\CasinoConfigService;
use App\Services\RechargeConfigService;
use App\Services\SportsConfigService;
use App\Services\WithdrawConfigService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class SiteInfoQuery extends Query
{
    public function __construct(
        private MemberService $memberService,
        private RechargeConfigService $rechargeConfigService,
        private WithdrawConfigService $withdrawConfigService,
        private SportsConfigService $sportsConfigService,
        private CasinoConfigService $casinoConfigService,
        private BonusConfigRepository $bonusConfigRepository,
    ) {
    }

    protected $attributes = [
        'name' => 'SiteInfoQuery',
        'description' => 'SiteInfo Query',
    ];

    public function type(): Type
    {
        return GraphQL::type('SiteInfoType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $site = app('site_info');
        /** @var RechargeConfig */
        $recharge_config = $this->rechargeConfigService->getConfig();
        /** @var WithdrawConfig */
        $withdraw_config = $this->withdrawConfigService->getConfig();

        $casino_config = $this->casinoConfigService->getConfig(\App\Models\CasinoConfig::TYPE_CASINO);
        $slot_config = $this->casinoConfigService->getConfig(\App\Models\CasinoConfig::TYPE_SLOT);

        /** @var Member */
        $member = auth()->user();
        $recharge_bonus = $this->bonusConfigRepository->getValue(app(BonusConfig::TYPE_RECHARGE_BONUS));
        $hasMemberRechargedToday = $member->memberHasRechargedToday();
        $hasMemberWithdrawnToday = $member->memberHasWithdrawnToday();
        $key = $hasMemberRechargedToday ? 'casino_recharge' : 'casino_first_time_recharge';
        $is_payment_upon_withdraw = $recharge_bonus['table'][$member->mLevel][$key]['is_payment_upon_withdraw'];
        $is_enable_bonus = $recharge_config->rcAutoBonus && ($is_payment_upon_withdraw || !$hasMemberWithdrawnToday);

        return [
            'min_deposit' => data_get($site, 'siOptionMinDeposit'),
            'deposit_text' => data_get($site, 'siOptionDepositText'),
            'validation_deposit' => $this->validation_deposit(data_get($site, 'siOptionMinDeposit', 0)),
            'min_withraw' => data_get($site, 'siOptionMinWithraw'),
            'withraw_text' => data_get($site, 'siOptionWithrawText'),
            'validation_withraw' => $this->validation_withraw(data_get($site, 'siOptionMinWithraw', 0)),
            'recharge_config' => [
                'rc_rules' => $recharge_config->rcWarningRechargeContent,
                'rc_max_bonus_first_time_sports_recharge' => $recharge_config->rcMaxBonusFirstTimeSportsRecharge,
                'rc_max_bonus_sports_recharge' => $recharge_config->rcMaxBonusSportsRecharge,
                'rc_max_bonus_first_time_casino_recharge' => $recharge_config->rcMaxBonusFirstTimeCasinoRecharge,
                'rc_max_bonus_casino_recharge' => $recharge_config->rcMaxBonusCasinoRecharge,
                'rc_enable_bonus' => $is_enable_bonus,
                'rc_max_bonus_first_time_poker_recharge' => $recharge_config->rcMaxBonusFirstTimePokerRecharge,
                'rc_max_bonus_poker_recharge' => $recharge_config->rcMaxBonusPokerRecharge,
                'rc_amount_no_bonus' => $recharge_config->rcAmountNoBonus,
                'rc_auto_bonus' => $recharge_config->rcAutoBonus,
                'rc_manual_recharge' => !$recharge_config->rcManualRecharge,
                'rc_enable_recharge' => $this->enableRecharge($recharge_config->rcTimeOffRecharge, $recharge_config->rcEnableTimeOffRecharge),
                'rc_enable_config_bonus' => $recharge_config->rcEnableConfigBonus,
                'rc_enable_thousand_money' => $recharge_config->rcEnableThousandMoney,
            ],
            'withdraw_config' => [
                'wc_rules' => $withdraw_config->wcRuleWithdrawContent,
                'wc_manual_withdraw' => !$withdraw_config->wcManualWithdraw,
                'wc_exchange_rules' => $withdraw_config->wcExchangeMoneyContent
            ],
            'sports_config_text' => $this->sportsConfigService->getConfigText(),
            'casino_config_text' => $this->casinoConfigService->getConfigText(),
            'game_config' => [
                'siEnableGamesConfig' => !$site->siEnableGamesConfig, // blue: false - red: true
                'siEnableGamesConfigNotice' => '점검중입니다.', // if siEnableGamesConfig is true
                'casino' => [
                    'enable' => data_get($casino_config, 'enable', true) // blue: false - red: true
                ],
                'slot' => [
                    'enable' => data_get($slot_config, 'enable', true), // blue: false - red: true
                ]
            ],
            'roulette_rules' => [
                'member_roulette' => $member->mRoulette
            ]
        ];
    }

    private function validation_deposit(string $min = '')
    {
        return [
            'required' => __('validation.required', ['attribute' => '입금하실 금액(원)']),
            'min' => '최소 ' . formatNumber($min) . ' 이상 충전신청을 해야합니다.',
        ];
    }

    private function validation_withraw(string $min = '')
    {
        return [
            'required' => __('validation.required', ['attribute' => '환전하실 금액(원)']),
            'min' => '최소 ' . formatNumber($min) . ' 이상 환전신청을 해야합니다.',
            'bank_pw_required' => __('validation.required', ['attribute' => '환전비밀번호']),
        ];
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
