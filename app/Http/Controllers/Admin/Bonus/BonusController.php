<?php

namespace App\Http\Controllers\Admin\Bonus;

use App\Http\Controllers\Controller;
use App\Services\BonusService;
use App\Services\MoneyInfoService;
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

        return view('Admin.Bonus.index', $data);
    }

    public function info($id)
    {
        $moneyInfo = $this->moneyInfoService->find($id);

        if ($moneyInfo->getType() == \App\Models\MoneyInfo::RECHARGE) {
            $view  = 'Admin.MoneyInfo.recharge_row';
        } else {
            $view  = 'Admin.MoneyInfo.withdraw_row';
        }

        $tr = view($view, compact('moneyInfo'))->with(['type' => 'recharge', 'showActions' => false])->render();

        return response()->json($tr);
    }

    public function paybackHistory(Request $request)
    {
        $data = $this->bonusService->getBonus($request->all());

        return view('Admin.Bonus.index', $data);
    }
}
