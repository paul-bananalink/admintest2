<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CasinoService;
use App\Services\TransactionService;
use App\Repositories\GameProviderRepository;

class BettingHistoryController extends Controller
{
    public function __construct(
        private CasinoService $casinoService,
        private TransactionService $transactionService,
        private GameProviderRepository $gameProviderRepository
    ) {
    }

    public function sports()
    {
        return view('Admin.BettingHistories.Sports.index');
    }

    public function realtime()
    {
        return view('Admin.BettingHistories.Realtime.index');
    }

    public function miniGame()
    {
        return view('Admin.BettingHistories.MiniGames.index');
    }

    public function virtualSports()
    {
        return view('Admin.BettingHistories.VirtualSports.index');
    }

    public function parsingCasino()
    {
        return view('Admin.BettingHistories.ParsingCasino.index');
    }

    public function casino()
    {
        $data['data'] = $this->transactionService->getDataSlotAndCasino();
        $data['providers'] = $this->gameProviderRepository->get();
        return view('Admin.BettingHistories.Casino.index', $data);
    }
}
