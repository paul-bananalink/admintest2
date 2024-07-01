<?php

namespace App\Services\API;

use App\Repositories\MemberRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Str;
use App\Events\Client\GetBalanceEvent;
use App\Events\Client\WarningMaxBetEvent;
use App\Models\BonusConfig;
use App\Models\MoneyInfo;
use App\Models\Transaction;
use App\Repositories\CashRepository;
use App\Repositories\GameProviderRepository;
use App\Services\BonusHandlerService;
use App\Services\CashService;
use App\Services\TransactionService;

class CallbackService extends BaseAPIService
{
    const ALREADY_PROCESSED_STATUS = 'AlreadyProcessed';

    const REFERENCE_NOT_FOUND_STATUS = 'ReferenceNotFound';

    const INSUFFICIENT_PLAYER_BALANCE_STATUS = 'InsufficientPlayerBalance';

    const PLAYER_NOT_FOUND_STATUS = 'PlayerNotFound';

    const OK_STATUS = 'OK';

    public $config;

    public function __construct(
        private MemberRepository $memberRepository,
        private TransactionRepository $transactionRepository,
        private GameProviderRepository $gameProviderRepository,
        private CashService $cashService,
        private CashRepository $cashRepository,
        private BonusHandlerService $bonusHandlerService,
        private TransactionService $transactionService
    ) {
        $this->config = config('hera_game.api_urls.wallet_callback');
        parent::__construct($this->getUtcNowTimestamp(), uniqid());
    }

    public function balance(array $attributes)
    {
        $member = $this->memberRepository->getMemberByMID(data_get($attributes, 'playerCode') ?? null);

        if (!$member) {
            return response()->json(['status' => self::PLAYER_NOT_FOUND_STATUS], 404);
        }

        $balance = $member->mMoney ? floatval($member->mMoney) : 0;

        return response()->json(['status' => self::OK_STATUS, 'result' => ['balance' => $balance]], 200);
    }

    public function transaction(array $attributes)
    {
        try {
            discordSendMessage(json_encode($attributes));

            $type = Str::camel($attributes['type']);

            $member = $this->memberRepository->getFirstWithConditions([['mID', $attributes['playerCode']]]);
            if (!$member) {
                return ['status' => self::PLAYER_NOT_FOUND_STATUS];
            }

            $mMoney = floatval($member->mMoney ?? 0);
            $attributes['amount'] = $attributes['amount'] ? floatval($attributes['amount']) : null;

            if ($this->transactionRepository->exists(['where' => [['uuid', $attributes['uuid']]]])) {
                return ['status' => self::ALREADY_PROCESSED_STATUS, 'result' => ['balance' => $mMoney]];
            }

            $data = $this->{$type}($mMoney, $attributes);

            if ($data['update_mMoney']) {
                $this->memberRepository->updateByPK($member, ['mMoney' => $data['balance']]);

                /** @var Transaction */
                $transaction = $this->transactionRepository->create($this->transactionFields($attributes));

                $cash = $this->cashService->init($transaction, $transaction->getTable());
                $this->cashRepository->create($cash);

                //Losing Bonus
                if ($transaction->tType == Transaction::tTYPE_WIN && $transaction->tAmount == 0) {
                    $this->bonusHandlerService->addBonusTransaction($transaction, BonusConfig::TYPE_LOSING_BONUS, BonusHandlerService::PAYMENT_METHOD_MONEY);
                }

                //Rolling Bonus
                if ($transaction->tType == Transaction::tTYPE_BET) {
                    $this->bonusHandlerService->addBonusTransaction($transaction, BonusConfig::TYPE_ROLLING_BONUS, BonusHandlerService::PAYMENT_METHOD_MONEY);
                }

                if ($transaction->tType == Transaction::tTYPE_WIN) {
                    $this->bonusHandlerService->rollingBonus($transaction);
                    $deductAmount = $this->transactionService->maxWinCasinoMoney($transaction);
                    if ($deductAmount > 0) {
                        $attributes['amount'] = $deductAmount;
                        $attributes['type'] = Transaction::TYPE_DEDUCT;
                        $attributes['uuid'] = Str::uuid()->toString();
                        $transaction = $this->transactionRepository->create($this->transactionFields($attributes));
                        $cash = $this->cashService->init($transaction, $transaction->getTable());
                        $this->cashRepository->create($cash);
                    }
                }

                $balance = ['mMoney' => $member->mMoney, 'mSportsMoney' => $member->mSportsMoney, 'mPoint' => $member->mPoint];

                event(new GetBalanceEvent($balance, $member->mID));
            }

            return [
                'status' => $data['status'],
                'result' => [
                    'balance' => round($data['balance'], 2),
                ],
            ];
        } catch (\Exception $e) {
            discordSendMessage($e->getMessage() . ', line ' . $e->getLine() . ', file ' . $e->getFile());
        }
    }

    private function bet($mMoney, $attributes)
    {
        $update_mMoney = false;
        if ($attributes['amount'] > $mMoney) {
            $status = self::INSUFFICIENT_PLAYER_BALANCE_STATUS;
            $balance = $mMoney;
        } else {
            $status = self::OK_STATUS;
            $balance = $mMoney - $attributes['amount'];
            $update_mMoney = true;
        }

        if (app('site_info')->siWarningMaxBet) {
            $pType = $this->getGameType($attributes['providerCode']);
            $maxAmount = app('site_info')->siWarningMaxBetValues[$pType] ?? 0;
            if ($maxAmount > 0 && $attributes['amount'] > $maxAmount) {
                event(new WarningMaxBetEvent($attributes['playerCode']));
            }
        }

        return ['status' => $status, 'balance' => $balance, 'update_mMoney' => $update_mMoney];
    }

    private function win($mMoney, $attributes)
    {
        $balance = $mMoney + $attributes['amount'];

        return ['status' => self::OK_STATUS, 'balance' => $balance, 'update_mMoney' => true];
    }

    private function cancelBet($mMoney, $attributes)
    {
        $update_mMoney = false;
        if ($reference = $this->transactionRepository->getFirstWithConditions([['uuid', $attributes['referenceUuid']]])) {
            $status = self::OK_STATUS;
            $amount = $attributes['amount'] ?? $reference->tAmount;
            $balance = $mMoney + $amount;
            $update_mMoney = true;
        } else {
            $status = self::REFERENCE_NOT_FOUND_STATUS;
            $balance = $mMoney;
        }

        return ['status' => $status, 'balance' => $balance, 'update_mMoney' => $update_mMoney];
    }

    private function cancelWin($mMoney, $attributes)
    {
        $update_mMoney = false;
        if ($reference = $this->transactionRepository->getFirstWithConditions([['uuid', $attributes['referenceUuid']]])) {
            $amount = $attributes['amount'] ?? $reference->tAmount;
            $status = self::OK_STATUS;
            $balance = $mMoney - $amount;
            $update_mMoney = true;
        } else {
            $status = self::REFERENCE_NOT_FOUND_STATUS;
            $balance = $mMoney;
        }

        return ['status' => $status, 'balance' => $balance, 'update_mMoney' => $update_mMoney];
    }

    private function other($mMoney, $attributes)
    {
        $update_mMoney = false;
        if ($attributes['amount'] < 0 && ($mMoney + $attributes['amount']) < 0) {
            $status = self::INSUFFICIENT_PLAYER_BALANCE_STATUS;
            $balance = $mMoney;
        } else {
            $status = self::OK_STATUS;
            $balance = $mMoney + $attributes['amount'];
            $update_mMoney = true;
        }

        return ['status' => $status, 'balance' => $balance, 'update_mMoney' => $update_mMoney];
    }

    private function transactionFields($attributes)
    {
        return [
            'uuid' => $attributes['uuid'],
            'mID' => $attributes['playerCode'],
            'pCode' => $attributes['providerCode'],
            'gCode' => $attributes['gameCode'],
            'gName' => $attributes['gameName'],
            'gNameEn' => $attributes['gameName_en'],
            'gCategory' => $attributes['gameCategory'],
            'tRoundId' => $attributes['roundId'],
            'tType' => $attributes['type'],
            'tAmount' => $attributes['amount'],
            'tReferenceUuid' => $attributes['referenceUuid'],
            'tRoundStarted' => $attributes['roundStarted'],
            'tRoundFinished' => $attributes['roundFinished'],
            'tDetails' => $attributes['details'],
        ];
    }

    private function getGameType($provider)
    {
        $provider = $this->gameProviderRepository->getFirstWithConditions([['gpCode', $provider]]);
        if (!$provider) {
            return null;
        }

        return $provider->type;
    }
}
