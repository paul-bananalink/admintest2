<?php

namespace App\Http\Controllers\Admin\Cash;

use App\Http\Controllers\Controller;
use App\Services\CashService;
use Illuminate\Contracts\View\View;

class CashController extends Controller
{
    public function __construct(
        private CashService $cashService,
    ) {
    }

    public function index(): View
    {
        $data['data'] = $this->cashService->getRepo()->getListCashRelation();

        return view('Admin.Cash.index', $data);
    }
}
