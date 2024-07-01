<?php

namespace App\Services;

use App\Repositories\GameProviderRepository;
use App\Repositories\TransactionRepository;
use DateTime;
use \App\Models\MoneyInfo;
use \App\Models\Game;

class TransactionService extends BaseService
{

    const TYPE_CASINO = 'casino';
    const TYPE_SLOT = 'slot';

    public $types = [
        self::TYPE_CASINO,
        self::TYPE_SLOT
    ];

    public function __construct(
        private TransactionRepository $transactionRepo,
        private GameProviderRepository $gameProviderRepo,
        private MoneyInfoService $moneyInfoService
    ) {
    }

    public function getNoTotal($total, $perpage, $current_page)
    {
        $start_no = $total - ($perpage * ($current_page - 1));
        return $start_no;
    }

    public function betHistories($attributes)
    {
        $page = $attributes['offset'];
        $limit = $attributes['limit'];

        $member = auth()->guard(config('constant_view.GUARD.SANCTUM'))->user();
        $where[] = ['mID', $member->mID];
        $where[] = ['tRoundId', '!=', NULL];
        $where[] = ['tType', 'Bet'];

        $whereDate = [];
        $whereIn = [];
        $form_date = [];

        if (app('site_info')->siMaxHoursHistories) {
            $date = now()->subHours(app('site_info')->siMaxHoursHistories);
            $form_date = ['tRegDate', '>=', $date];
        }

        if (!empty($attributes['start_date'])) {
            $start_str = $attributes['start_date'];
            $date = DateTime::createFromFormat('d/m/Y', $start_str);
            $start_date = $date->format('Y-m-d');
            $form_date = ['tRegDate', '>=', $start_date];
        }

        if (!empty($attributes['category'])) {
            if ($attributes['category'] == self::TYPE_SLOT) {
                $whereIn[] = ['gCategory', \App\Models\GameProvider::CATEGORY_SLOT];
            }
            if ($attributes['category'] == self::TYPE_CASINO) {
                $whereIn[] = ['gCategory', \App\Models\GameProvider::CATEGORY_CASINO];
            }
        }

        if ($form_date) $whereDate[] = $form_date;

        return $this->transactionRepo->paginateWithConditions($page, $limit, [['tRegDate', 'desc'], ['tType', 'desc']], ['where' => $where, 'whereDate' => $whereDate, 'whereIn' => $whereIn]);
    }

    public function getDataSlotAndCasino()
    {
        $params = [];

        $params['per_page'] = request('per_page', self::COUNT_PER_PAGE);
        $params['gCategory'] = \App\Models\GameProvider::CATEGORY_CASINO_AND_SLOT;

        $params['start_date'] = request('start_date');
        $params['end_date'] = request('end_date');
        $params['search_input'] = request('search_input');
        $params['provider'] = request('provider');

        return $this->transactionRepo->getDataSlotAndCasinoPagination($params);
    }

    public function maxWinCasinoMoney($transaction): float
    {
        $gameCategory = $transaction->gCategory;
        if (!in_array($gameCategory, Game::GAME_CATE)) {
            return 0;
        }

        $amount = $transaction->tAmount;
        $field = $gameCategory == Game::CASINO_CATEGORY ? 'mcMaxWinCasinoMoney' : 'mcMaxWinSlotMoney';

        $memberConfig = $transaction->member->memberConfig;
        $maxWinMoney = (float)data_get($memberConfig, $field);

        if (!$maxWinMoney || $amount < $maxWinMoney) {
            return 0;
        }

        $miBankMoney = $amount - $maxWinMoney;
        $member = $transaction->member;
        $member->mMoney -= $miBankMoney;
        $member->save();

        return $miBankMoney;
    }
}
