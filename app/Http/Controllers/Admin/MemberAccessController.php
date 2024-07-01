<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MemberAccessService;
use App\Services\MemberService;

class MemberAccessController extends Controller
{
    public function __construct(
        private MemberAccessService $memberAccessService,
        private MemberService $memService,
    ) {
    }

    public function index()
    {
        $data = $this->memberAccessService->getInfoMemberAccess(request()->all());

        return view('Admin.MemberAccess.index', $data);
    }

    public function memberLogout()
    {
        $this->memberAccessService->memberLogout(request('mNo'), config('constant_view.EVENTS.TURN_ON_EVENT'));

        return redirect()->route('admin.info-member-access.index');
    }
}
