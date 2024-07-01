<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RechargeConfigRequest;
use App\Services\RechargeConfigService;

class RechargeConfigController extends Controller
{
    public function __construct(
        private RechargeConfigService $rechargeConfigService,
    ) {
    }

    public function index()
    {
        $data['recharge_config'] = $this->rechargeConfigService->getConfig();

        return view('Admin.PageSetting.recharge.index', $data);
    }

    public function store(RechargeConfigRequest $request)
{
    $is_ajax = $request->ajax();

    $this->rechargeConfigService->syncRechargeConfig($request->all());

    if ($is_ajax) {
        return response()->json(['status' => true, 'message' => 'Success']);
    }

    return redirect()->route('admin.page-setting.recharge-config.index')->with('success', '업데이트 성공.');
}


    public function toggleField($field)
    {
        $status = $this->rechargeConfigService->toggleField($field);
        return response()->json(['status' => $status]);
    }
}
