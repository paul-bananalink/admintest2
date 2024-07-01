<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Services\MemberConfigService;

class MemberConfigController extends Controller
{
    public function __construct(
        private MemberConfigService $memberConfigService,
    ) {
    }

    public function update(string $field, $mID)
    {
        $isSuccess = $this->memberConfigService->updateByMember($field, $mID);

        return response()->json(['success' => $isSuccess]);
    }

    public function updateGameProviderByMemberID(string $mID, string $gpType, string $gpCode)
    {
        return response()->json(['success' => $this->memberConfigService->toggleGameProviderConfig($mID, $gpType, $gpCode)]);
    }

    public function ajaxGetMCEventRestrictions(string $mID)
    {
        $data = [
            'config' => $this->memberConfigService->getEventRestrictionsConfig($mID),
            'mID' => $mID
        ];

        return view('Admin.Common.Modal.ajax.detail_member_config_event_restrictions', $data)->render();
    }

    public function toggleMCEventRestrictionsItem(string $mID, string $field)
    {
        $res = $this->memberConfigService->toggleEventRestrictionsItem($mID, $field);

        return response()->json(['success' => $res]);
    }
}
