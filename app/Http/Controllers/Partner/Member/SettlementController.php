<?php

namespace App\Http\Controllers\Partner\Member;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Services\Partner\SettlementService;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    /**
     * Dependency injection constructor
     * https://laravel.com/docs/11.x/container#introduction
     */
    public function __construct(
        private SettlementService $settlementServicePartner
    ) {
    }

    public function index(Request $request): View
    {
        $data['data'] = [];
        return view('Partner.Settlement.index', $data);
    }
}
