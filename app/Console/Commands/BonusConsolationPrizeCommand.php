<?php

namespace App\Console\Commands;

use App\Events\Client\GetBalanceEvent;
use App\Models\BonusConfig;
use App\Models\MoneyInfo;
use App\Models\Note;
use App\Repositories\MemberConfigRepository;
use App\Repositories\MemberRepository;
use App\Repositories\MoneyInfoRepository;
use App\Services\BonusHandlerService;
use App\Services\NoteService;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class BonusConsolationPrizeCommand extends Command
{
    private BonusConfig $bonusConsolationPrize;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:consolation-prize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected MemberRepository $memberRepository,
        protected MoneyInfoRepository $moneyInfoRepository,
        protected BonusHandlerService $bonusHandlerService,
        protected NoteService $noteService,
        protected MemberConfigRepository $memberConfigRepository,
    ) {
        parent::__construct();
        $this->bonusConsolationPrize = app(BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->bonusConsolationPrize['is_available']) {
            $members = $this->memberRepository->getListMemberConsolationPrize($this->bonusConsolationPrize['minimum_days_no_withdraw_to_paid']);
            $members = $members->filter(function ($item) {
                return $item->sum_withdraw === 0;
            });
            $members = $this->filterMemberWithConsecutiveCondition($members);

            $this->handleBonus($members);
        }
    }

    private function handleBonus($members): void
    {
        $consolation = $this->bonusConsolationPrize['consolation'];
        $consolation = collect($consolation)->whereNotNull('recharge_amount')->sortByDesc('recharge_amount');

        foreach ($members as $member) {
            if (!$this->memberConfigRepository->disableEventRestrictionByKey($member->mID, BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS)) {

                $payment_amount = $consolation->firstWhere('recharge_amount', '<=', $member->sum_deposit)['payment_amount'];
                $attributes = [
                    'mID' => $member->mID,
                    'miBankMoney' => $payment_amount,
                    'miStatus' => MoneyInfo::STATUS_NINE,
                    'miWallet' => MoneyInfo::TYPE_WALLET_POINT,
                    'miType' => MoneyInfo::TYPE_AD,
                ];

                /** @var MoneyInfo */
                $moneyInfo = $this->moneyInfoRepository->create($attributes);
                $this->bonusHandlerService->addBonusMoneyInfo($moneyInfo, BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS, BonusHandlerService::PAYMENT_METHOD_MONEY);

                $balance = ['mMoney' => $member->mMoney, 'mSportsMoney' => $member->mSportsMoney, 'mPoint' => $member->mPoint];
                event(new GetBalanceEvent($balance, $member->mID));
            }
        }

        $this->noteService->addNote([
            'type' => Note::TYPE_SEND_LIST_USER,
            'member_list' => implode("\r\n", $members->pluck('mID')->toArray()),
            'title' => $this->bonusConsolationPrize['note_title'],
            'content' => $this->bonusConsolationPrize['note_detail'],
        ]);
    }

    private function filterMemberWithConsecutiveCondition(Collection $members): Collection
    {
        $days = $this->bonusConsolationPrize['minimum_days_no_withdraw_to_paid'];
        $from = now()->subDays($days);
        $dates = CarbonPeriod::create($from, now())->toArray();

        foreach ($members as $key => $member) {
            $consecutive_recharge_days = 0;
            foreach ($dates as $date) {
                if ($this->moneyInfoRepository->countMemberRechargeByDay($member->mID, $date) > 0) {
                    $consecutive_recharge_days++;
                }
            }
            if ($consecutive_recharge_days < $days) {
                $members->forget($key);
            }
        }

        return $members;
    }
}
