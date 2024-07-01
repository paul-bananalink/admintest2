<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\WithdrawConfigRequest;
use App\Services\WithdrawConfigService;

class WithdrawConfigController extends Controller
{
    public function __construct(
        private WithdrawConfigService $withdrawConfigService,
    ) {
    }

    public function index()
    {
        $data['withdraw_config'] = $this->withdrawConfigService->getConfig();

        return view('Admin.PageSetting.withdraw.index', $data);
    }

    public function store(WithdrawConfigRequest $request)
    {
        $this->withdrawConfigService->syncWithdrawConfig($request->all());

     return redirect()->route('admin.page-setting.withdraw-config.index')->with('success', '업데이트 성공.');

    }

    public function toggleField($field)
    {
        $status = $this->withdrawConfigService->toggleField($field);
        return response()->json(['status' => $status]);
    }
}
