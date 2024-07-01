<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Services\SettlementService;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    /**
     * Dependency injection constructor
     * https://laravel.com/docs/11.x/container#introduction
     */
    public function __construct(
        private SettlementService $settlementService,
    ) {
    }

    public function index(Request $request): View
    {
        $partners = $this->settlementService->index();

        return view('Admin.Settlement.form_settlement', compact('partners'));
    }

    public function detail(string $group, int $id, int $level)
    {
        $data = $this->settlementService->detail($id);
        $partner = $data['partner'];
        $children = $data['children'];
        $data = view('Admin.Settlement.settlement_table_row', compact('group', 'id', 'level', 'partner', 'children'))->render();

        return response()->json(['data' => $data]);
    }

    public function web(Request $request): View
    {
        $data['data'] = $this->settlementService->web($request->all());
        return view('Admin.Settlement.form_settlement.web', $data);
    }

    public function webDetail(Request $request)
    {
        $data = view('Admin.Settlement.settlement_web_detail')->with(['row_date' => $request->row_date])->render();
        
        return response()->json(['data' => $data]);
    }

    public function user(Request $request): View
    {
        $data['data'] = $this->settlementService->user($request->all());
        return view('Admin.Settlement.form_settlement_user', $data);
    }
}
