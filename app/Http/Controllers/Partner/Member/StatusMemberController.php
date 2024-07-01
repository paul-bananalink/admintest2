<?php

namespace App\Http\Controllers\Partner\Member;

use App\Http\Controllers\Controller;
use App\Services\Partner\StatusMemberService;
use App\Services\MemberService;

class StatusMemberController extends Controller
{
    public function __construct(
        private StatusMemberService $stMemService,
        private MemberService $memberService,
    ) {
    }

    public function index()
    {
        $data = $this->stMemService->getStatusMemberAccess(request()->all());

        return view('Partner.Member.index', $data);
    }
}
