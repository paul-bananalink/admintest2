<?php

namespace App\Http\Controllers\Partner\PointHistory;

use App\Http\Controllers\Controller;
use App\Services\Partner\PointHistoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PointHistoryController extends Controller
{
    public function __construct(
        private PointHistoryService $pointHistoryService,
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->pointHistoryService->getList($request->all());

        return view('Partner.PointHistory.index', $data);
    }
}
