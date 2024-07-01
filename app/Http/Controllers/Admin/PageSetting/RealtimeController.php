<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Services\RealtimeConfigService;
use Illuminate\Http\Request;
use App\Repositories\RealtimeConfigRepository;

class RealtimeController extends Controller
{
    public function __construct(
        private RealtimeConfigService $realtimeConfigService,
        private RealtimeConfigRepository $realtimeConfigRepo
    ) {
    }

    public function index()
    {
        $data['data'] = $this->realtimeConfigRepo->getConfig();

        return view('Admin.PageSetting.OptionGames.Sports.RealTimes.index', $data);
    }

    public function update(Request $request)
    {
        $res = $this->realtimeConfigService->update($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.realtime-config.index')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.realtime-config.index')->with('error', '업데이트 실패');
    }

    public function toggleField(string $field = null)
    {
        $status = $this->realtimeConfigService->toggleField($field);
        return response()->json(['status' => $status]);
    }
}
