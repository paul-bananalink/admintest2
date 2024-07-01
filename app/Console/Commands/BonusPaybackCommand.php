<?php

namespace App\Console\Commands;

use App\Events\Client\GetBalanceEvent;
use App\Models\BonusConfig;
use App\Models\Member;
use App\Models\MoneyInfo;
use App\Models\Note;
use App\Repositories\MemberRepository;
use App\Repositories\MoneyInfoRepository;
use App\Services\BonusHandlerService;
use App\Services\NoteService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class BonusPaybackCommand extends Command
{
    private BonusConfig $bonusPayback;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:payback';

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

    ) {
        parent::__construct();
        $this->bonusPayback = app(BonusConfig::TYPE_PAYBACK_BONUS);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $lastWeek = $now->subWeek();
        $startLastWeek = $lastWeek->startOfWeek()->toDateTimeString();
        $endLastWeek = $lastWeek->endOfWeek()->toDateTimeString();

        $is_available = data_get($this->bonusPayback->bcValue, 'is_available');

        if ($is_available) {
            $members = $this->memberRepository->getListMemberPayBackBonus($startLastWeek, $endLastWeek);
            foreach ($members as $member) {
                $payment_amount = $this->bonusHandlerService->calculatePaybackBonus($member);

                if ($payment_amount > 0) {
                    $this->handleBonus($member, $payment_amount);
                    $members_send_note[] = $member->mID;
                }
            }
        }

        if (!empty($members_send_note)) {
            $this->noteService->addNote([
                'type' => Note::TYPE_SEND_LIST_USER,
                'member_list' => implode("\r\n", $members_send_note),
                'title' => data_get($this->bonusPayback->bcValue, 'note_title'),
                'content' => data_get($this->bonusPayback->bcValue, 'note_detail'),
            ]);
        }
    }

    private function handleBonus(Member $member, float $payment_amount): void
    {
        $attributes = [
            'mID' => $member->mID,
            'miBankMoney' => $payment_amount,
            'miStatus' => MoneyInfo::STATUS_NINE,
            'miWallet' => MoneyInfo::TYPE_WALLET_POINT,
            'miType' => MoneyInfo::TYPE_AD,
        ];

        /** @var MoneyInfo */
        $moneyInfo = $this->moneyInfoRepository->create($attributes);
        $this->bonusHandlerService->addBonusMoneyInfo($moneyInfo, BonusConfig::TYPE_PAYBACK_BONUS, BonusHandlerService::PAYMENT_METHOD_MONEY);

        $balance = ['mMoney' => $member->mMoney, 'mSportsMoney' => $member->mSportsMoney, 'mPoint' => $member->mPoint];
        event(new GetBalanceEvent($balance, $member->mID));
    }
}
