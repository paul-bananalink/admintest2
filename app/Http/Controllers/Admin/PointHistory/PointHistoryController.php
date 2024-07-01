<?php

namespace App\Http\Controllers\Admin\PointHistory;

use App\Http\Controllers\Controller;
use App\Services\PointHistoryService;
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

        return view('Admin.PointHistory.index', $data);
    }
}
