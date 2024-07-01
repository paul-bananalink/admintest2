<?php

namespace App\Http\Controllers\Partner\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Partner\DashboardService;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function index(Request $request)
    {
        $data = $this->dashboardService->getStatisticBoard($request->all());
        return view('Partner.Dashboard.index', $data);
    }
}
