<?php

namespace App\Http\Controllers\Partner\Bonus;

use App\Http\Controllers\Controller;
use App\Services\Partner\BonusService;
use App\Services\Partner\MoneyInfoService;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function __construct(
        private BonusService $bonusService,
        private MoneyInfoService $moneyInfoService,
    ) {
    }

    public function index(Request $request)
    {
        $data = $this->bonusService->getBonus($request->all());

        return view('Partner.Bonus.index', $data);
    }

    public function info($id)
    {
        $moneyInfo = $this->moneyInfoService->find($id);
        $tr = view('Admin.MoneyInfo.recharge_row', compact('moneyInfo'))->with(['type' => 'recharge', 'showActions' => false])->render();

        return response()->json($tr);
    }
}
