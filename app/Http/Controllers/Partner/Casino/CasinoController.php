<?php

namespace App\Http\Controllers\Partner\Casino;

use App\Http\Controllers\Controller;
use App\Services\CasinoService;
use App\Services\Partner\TransactionService;
use Illuminate\Http\Request;

class CasinoController extends Controller
{
    public function __construct(
        private CasinoService $casinoService,
        private TransactionService $transactionService,
    ) {
    }

    public function index($type, Request $request)
    {

        if (!in_array($type, $this->transactionService->types)) abort(404);

        $params = $request->all();
        $params['type'] = $type;

        $data['providers'] = $this->casinoService->getGameProviders($type);
        $data['data'] = $this->transactionService->getData($params);
        $data['paramSearch'] = $this->transactionService->paramSearch($params);
        $data['type'] = $type;
        $data['title_page'] = $type === $this->transactionService::TYPE_CASINO ? '카지노배팅내역' : '슬롯 배팅내역';

        $data['start_no'] = $this->transactionService->getNoTotal(
            $data['data']->total(),
            $data['data']->perPage(),
            $data['data']->currentPage()
        );

        return view('Partner.Casino.index', $data);
    }
}
