<?php

namespace App\Services;

use App\Models\BonusConfig;
use App\Models\Cash;
use App\Models\Member;
use App\Models\MemberConfig;
use App\Models\MoneyInfo;
use App\Models\MoneyInfoHistory;
use App\Repositories\CashRepository;
use App\Repositories\MoneyInfoHistoryRepository;
use App\Repositories\MoneyInfoRepository;
use App\Repositories\MemberRepository;
use Illuminate\Support\Facades\Auth;

class MoneyHandlerService extends BaseService
{
    public function __construct(
        private RechargeConfigService $rechargeConfigService,
        private WithdrawConfigService $withdrawConfigService,
        private CasinoConfigService $casinoConfigService,
        private SportsConfigService $sportsConfigService,
        private MoneyInfoRepository $moneyInfoRepository,
        private MoneyInfoHistoryRepository $moneyInfoHistoryRepository,
        private BonusHandlerService $bonusHandlerService,
        private CashService $cashService,
        private CashRepository $cashRepository,
        private MemberRepository $memberRepository,
    ) {
    }

    public function handleCreation(Member $member, array $attributes): MoneyInfo|bool
    {
        @[
            'miBankMoney' => $miBankMoney,
            'miWallet' => $miWallet,
            'miType' => $miType,
        ] = $attributes;

        if (is_null($member) || is_null($miBankMoney) || is_null($miWallet) || is_null($miType)) return false;

        $attributes = [
            ...$attributes,
            'miBankMoney' => (float) data_get($attributes, 'miBankMoney'),
        ];

        if ($miType == MoneyInfo::TYPE_AD) return $this->createAdminRecharge($member, $attributes);
        elseif ($miType == MoneyInfo::TYPE_AW) return $this->createAdminWithdraw($member, $attributes);
        elseif ($miType == MoneyInfo::TYPE_UD) return $this->createMemberRecharge($member, $attributes);
        elseif ($miType == MoneyInfo::TYPE_UW) return $this->createMemberWithdraw($member, $attributes);
        else throw new \Exception('Invalid miType');
    }

    public function handleApproval(MoneyInfo $moneyInfo): MoneyInfo|bool
    {
        if (!in_array($moneyInfo->getRawOriginal('miStatus'), [MoneyInfo::STATUS_ONE])) return false;

        $attributes = [
            'miStatus' => MoneyInfo::STATUS_NINE,
            'miProcess_miID' => Auth::user()->mID,
            'mProcessDate' => now(),
        ];

        $member = $moneyInfo->member;
        $member->memberConfig->resetRollingWhenRecharge($moneyInfo->miType);

        if ($moneyInfo->miType == MoneyInfo::TYPE_UD) {
            $updateField = MemberConfig::MONEY_WITHDRAW_UPDATE_FIELD[$moneyInfo->miWallet];
            $member->memberConfig()->update([$updateField => $moneyInfo->miBankMoney * $moneyInfo->miBetPercent / 100]);
            $this->bonusHandlerService->payMoneyInfoBonus($moneyInfo);
        }

        // Handle recharge point
        if ($moneyInfo->miWallet == Member::WALLET_POINT) {
            if (in_array($moneyInfo->miWallet, [MoneyInfo::TYPE_AD])) {
                $this->bonusHandlerService->addBonusMoneyInfo($moneyInfo, BonusConfig::TYPE_ADMIN_RECHARGE, BonusHandlerService::PAYMENT_METHOD_MONEY);
            }
        }

        /** @var MoneyInfo */
        $moneyInfo->update($attributes);
        $moneyInfoHistory = $this->createMoneyInfoHistory($moneyInfo);

        if (in_array($moneyInfo->miWallet, [Member::WALLET_SPORTS, Member::WALLET_CASINO_SLOT])) {
            $this->handleMemberMoney($moneyInfo);
            $this->handleCash($moneyInfoHistory);
        }

        return $moneyInfo;
    }

    public function handleRollback(MoneyInfo $moneyInfo): MoneyInfo|bool
    {
        if (!in_array($moneyInfo->getRawOriginal('miStatus'), [MoneyInfo::STATUS_NINE])) return false;

        $attributes = [
            'miStatus' => MoneyInfo::STATUS_TWO,
            'miProcess_miID' => Auth::user()->mID,
            'mProcessDate' => now(),
        ];
        $moneyInfo->update($attributes);
        $moneyInfoHistory = $this->createMoneyInfoHistory($moneyInfo);
        $this->handleCash($moneyInfoHistory);
        $this->handleMemberMoney($moneyInfo);
        // Handle point
        $this->bonusHandlerService->rollbackBonus($moneyInfo);
        return $moneyInfo;
    }

    public function handleCancellation(MoneyInfo $moneyInfo): MoneyInfo|bool
    {
        if (!in_array($moneyInfo->getRawOriginal('miStatus'), [MoneyInfo::STATUS_ONE])) return false;

        $attributes = [
            'miStatus' => MoneyInfo::STATUS_THREE,
            'miProcess_miID' => Auth::user()->mID,
            'mProcessDate' => now(),
        ];

        /** @var MoneyInfo */
        $moneyInfo = $this->moneyInfoRepository->updateByPK($moneyInfo, $attributes);
        $this->createMoneyInfoHistory($moneyInfo);

        return $moneyInfo;
    }

    private function createAdminRecharge(Member $member, array $attributes): MoneyInfo|bool
    {
        $attributes = [
            ...$attributes,
            'miStatus' => MoneyInfo::STATUS_NINE,
            'mProcessDate' => now(),
        ];

        $attributes = $this->appendBonusToAttribute($member, $attributes);

        /** @var MoneyInfo */
        $moneyInfo = $this->moneyInfoRepository->create($attributes);
        $moneyInfoHistory = $this->createMoneyInfoHistory($moneyInfo);

        $this->handleCash($moneyInfoHistory);
        $this->handleMemberMoney($moneyInfo);

        return $moneyInfo;
    }

    private function createAdminWithdraw(Member $member, array $attributes): MoneyInfo|bool
    {
        $attributes = [
            ...$attributes,
            'miStatus' => MoneyInfo::STATUS_NINE,
            'mProcessDate' => now(),
        ];

        $attributes = $this->appendBonusToAttribute($member, $attributes);

        return $this->createMoneyInfo($member, $attributes);
    }

    private function createMemberRecharge(Member $member, array $attributes): MoneyInfo|bool
    {
        $attributes = [
            ...$attributes,
            'miStatus' => MoneyInfo::STATUS_ONE,
            'mProcessDate' => null,
        ];

        $attributes = $this->appendBonusToAttribute($member, $attributes);
        $moneyInfo = $this->createMoneyInfo($member, $attributes);
        return $moneyInfo;
    }

    private function createMemberWithdraw(Member $member, array $attributes): MoneyInfo|bool
    {
        $attributes = [
            ...$attributes,
            'miStatus' => MoneyInfo::STATUS_ONE,
            'mProcessDate' => null,
        ];

        $attributes = $this->appendBonusToAttribute($member, $attributes);

        return $this->createMoneyInfo($member, $attributes);
    }

    private function createMoneyInfo(Member $member, array $attributes): MoneyInfo|bool
    {
        [
            'miType' => $miType,
            'miBankMoney' => $miBankMoney,
        ] = $attributes;

        if (in_array($miType, MoneyInfo::MI_TYPE_FILTER[MoneyInfo::WITHDRAW])) {
            $miBankMoney = abs($miBankMoney) * -1;
        }

        $attributes = [
            ...$attributes,
            'miBankMoney' => $miBankMoney,
            'mID' => $member->mID,
            'miBankName' => $member->mBankName,
            'miBankNumber' => $member->mBankNumber,
            'miBankOwner' => $member->mBankOwner,
        ];

        /** @var MoneyInfo */
        $moneyInfo = $this->moneyInfoRepository->create($attributes);
        $this->createMoneyInfoHistory($moneyInfo);

        return $moneyInfo;
    }

    private function createMoneyInfoHistory(MoneyInfo $moneyInfo): MoneyInfoHistory|bool
    {
        $miBankMoney = $moneyInfo->getRawOriginal('miStatus') == MoneyInfo::STATUS_TWO ? abs($moneyInfo->miBankMoney) * -1 : $moneyInfo->miBankMoney;
        $attributes = [
            ...$moneyInfo->toArray(),
            'mihStatus' => $moneyInfo->getRawOriginal('miStatus'),
            'miNo' => $moneyInfo->miNo,
            'miBankMoney' => $miBankMoney,
        ];

        return $this->moneyInfoHistoryRepository->create($attributes);
    }

    private function appendBonusToAttribute(Member $member, array $attributes): array
    {
        @[
            'miWallet' => $miWallet,
            'miType' => $miType,
            'miBonus' => $miBonus,
        ] = $attributes;

        $rechargeConfig = $this->rechargeConfigService->getConfig();
        $withdrawConfig = $this->withdrawConfigService->getConfig();
        $withdrawWallet = $miWallet == Member::WALLET_CASINO_SLOT ? 'casino' : $miWallet;

        $rechargeBonus = $miWallet == Member::WALLET_SPORTS
            ? $this->sportsConfigService->getMemberRechargeBonus($member)
            : $this->casinoConfigService->getMemberRechargeBonus($member);

        if ($miType == MoneyInfo::TYPE_UD) {
            if ($rechargeConfig['rcAutoBonus'] && $miBonus == MoneyInfo::TYPE_BONUS) {
                // When user recharge with bonus button selected
                $attributes = [
                    ...$attributes,
                    'miBonusPercent' => $rechargeBonus ? $rechargeBonus['percent'] : null,
                    'miBetPercent' => $withdrawConfig->wcBonus[$withdrawWallet],
                    'miMaxBonusRecharge' => $rechargeBonus ? $rechargeBonus['money'] : null
                ];
            } else {
                // When user recharge with no bonus button selected (when these buttons not display, this type is default)
                $attributes = [
                    ...$attributes,
                    'miBonusPercent' => null,
                    'miBetPercent' => $withdrawConfig->wcNoBonus[$withdrawWallet],
                    'miMaxBonusRecharge' => null,
                ];
            }
        }

        $attributes = $this->bonusHandlerService->appendMoneyInfoBonus($member, $attributes);

        return $attributes;
    }

    private function handleCash(MoneyInfoHistory $moneyInfoHistory): Cash|bool
    {
        $attributes = $this->cashService->init($moneyInfoHistory, Cash::MONEY_INFO_TABLE_HISTORY);

        return $this->cashRepository->create($attributes);
    }

    private function handleMemberMoney(MoneyInfo $moneyInfo): bool
    {
        $money = $moneyInfo->miBankMoney;
        if ($moneyInfo->getRawOriginal('miStatus') == MoneyInfo::STATUS_TWO) {
            $money *= -1;
        }

        return $this->tryCatchFuncDB(function () use ($moneyInfo, $money) {
            $member = $moneyInfo->member;
            $member->{Member::MEMBER_WALLETS[$moneyInfo->miWallet]} += $money;
            $member->save();

            return $member;
        });
    }
}
