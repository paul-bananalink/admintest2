<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Services\CasinoService;
use App\Services\Partner\TransactionService;
use App\Repositories\GameProviderRepository;

class BettingHistoryController extends Controller
{
    public function __construct(
        private CasinoService $casinoService,
        private TransactionService $transactionService,
        private GameProviderRepository $gameProviderRepository
    ) {
    }

    public function miniGame()
    {
        return view('Partner.BettingHistories.MiniGames.index');
    }

    public function parsingCasino()
    {
        return view('Partner.BettingHistories.ParsingCasino.index');
    }

    public function casino()
    {
        $data['data'] = $this->transactionService->getDataSlotAndCasino();
        $data['providers'] = $this->gameProviderRepository->get();
        return view('Partner.BettingHistories.Casino.index', $data);
    }
}
