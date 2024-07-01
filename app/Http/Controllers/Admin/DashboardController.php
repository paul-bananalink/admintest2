<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function index(Request $request)
    {
        $data = $this->dashboardService->getStatisticBoard($request->all());

        return view('Admin.Dashboard.index', $data);
    }
}
