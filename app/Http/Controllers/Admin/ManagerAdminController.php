<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddAdminRequest;
use App\Http\Requests\Admin\MemberAllowIpDeleteRequest;
use App\Http\Requests\Admin\MemberAllowIpRequest;
use App\Http\Requests\Admin\UpdatePasswordAdminRequest;
use App\Services\ManagerAdminService;

class ManagerAdminController extends Controller
{
    public function __construct(
        private ManagerAdminService $managerAdminService
    ) {
    }

    public function index()
    {
        $data = $this->managerAdminService->getDataForPageManager(request()->all());

        return view('Admin.ManagerAdminSetting.index', $data);
    }

    public function addAdmin(AddAdminRequest $request)
    {
        $is = $this->managerAdminService->newAdmin($request->all());
        if (! $is) {
            return redirect()->route('admin.manager-account-setting.index')->withErrors(__('register.failed'), 'list-admin-setting');
        }

        return redirect()->route('admin.manager-account-setting.index');
    }

    public function updatePasswordAdmin(UpdatePasswordAdminRequest $request)
    {
        $is = $this->managerAdminService->updateAdmin($request->all());
        if (! $is) {
            return redirect()->route('admin.manager-account-setting.index')->withErrors(__('passwords.update_password'), 'list-admin-setting');
        }

        return redirect()->route('admin.manager-account-setting.index');
    }

    public function changeStatus(?int $id = null, bool $is_unlock = false)
    {
        $this->managerAdminService->changeStatusAdmin($id, $is_unlock);

        return redirect()->route('admin.manager-account-setting.index');
    }

    public function allowIpSave(MemberAllowIpRequest $request, string $m_id = '')
    {
        $this->managerAdminService->createMemberAllowIp($m_id, $request->all());

        return redirect()->route('admin.manager-account-setting.index', ['open_allow_ip' => $m_id]);
    }

    public function allowIpDelete(MemberAllowIpDeleteRequest $request)
    {
        $this->managerAdminService->deleteMemberAllowIp($request->all());

        return redirect()->route('admin.manager-account-setting.index');
    }
}
