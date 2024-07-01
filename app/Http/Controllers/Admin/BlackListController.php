<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BlackListService;

class BlackListController extends Controller
{
    public function __construct(private BlackListService $blackListService)
    {
    }

    public function index()
    {
        $data = $this->blackListService->paginateBlackList(request()->all());

        return view('Admin.Blacklist.index', $data);
    }
}
