<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MemberBlockService;
use Illuminate\Http\Request;

class MemberBlockController extends Controller
{
    public function __construct(private MemberBlockService $memberBlockService)
    {
    }

    public function index(Request $request)
    {
        $searchInput = $request->input('search_input');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = $this->memberBlockService->searchMemberLoginFailed($searchInput, $startDate, $endDate);

        return view('Admin.MemberBlock.index', compact('data', 'searchInput', 'startDate', 'endDate'));
    }
}
