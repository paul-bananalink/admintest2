<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VirtualSportsConfigService;
use App\Repositories\VirtualSportsConfigRepository;

class VirtualSportsConfigController extends Controller
{
    public function __construct(
        private VirtualSportsConfigService $virtualSportsConfigService,
        private VirtualSportsConfigRepository $virtualSportsConfigRepo,
    ) {
    }

    public function index()
    {
        $data['data'] = $this->virtualSportsConfigRepo->getConfig();

        return view('Admin.PageSetting.OptionGames.VirtualSports.index', $data);
    }

    public function update(Request $request)
    {
        $res = $this->virtualSportsConfigService->update($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.virtual-sport-config.index')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.virtual-sport-config.index')->with('error', '업데이트 실패');
    }

    public function toggleField(string $field = null)
    {
        $status = $this->virtualSportsConfigService->toggleField($field);
        return response()->json(['status' => $status]);
    }
}
