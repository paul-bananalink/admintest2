<?php

namespace App\Http\Controllers\Partner\MoneyInfo;

use App\Http\Controllers\Controller;
use App\Services\Partner\MoneyInfoService;
use Illuminate\Http\Request;

class MoneyInfoController extends Controller
{
    public function __construct(
        private MoneyInfoService $moneyInfoService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $type)
    {
        $attributes = $request->all();
        $attributes['type'] = $data['type'] = $type;

        $data['data'] = $this->moneyInfoService->getAll($attributes);

        $data['over_view'] = $this->moneyInfoService->getOverview($attributes);
        $data['config'] = data_get($data, 'over_view.config', []);

        $data['title'] = $type == 'withdraw' ? '출금' : '입금';

        return view('Partner.MoneyInfo.index', $data);
    }
}
