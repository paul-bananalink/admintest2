<?php

namespace App\Http\Controllers\Partner\Cash;

use App\Http\Controllers\Controller;
use App\Services\Partner\CashService;
use Illuminate\View\View;

class CashController extends Controller
{
    public function __construct(
        private readonly CashService $cashService,
    ) {
    }

    public function index(): View
    {
        $data['data'] = $this->cashService->getRepo()->getListCashRelation();

        return view('Partner.Cash.index', $data);
    }
}
