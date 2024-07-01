<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MemberIpInfectService;

class MemberIpInfectController extends Controller
{
    public function __construct(private MemberIpInfectService $memIpInfectService)
    {

    }

    public function index()
    {
        $data = $this->memIpInfectService->getMemberIpInfect(request()->all());

        return view('Admin.MemberIpInfect.index', $data);
    }
}
