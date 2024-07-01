<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Services\SportsConfigService;
use Illuminate\Http\Request;
use App\Repositories\SportsConfigRepository;

class SportsController extends Controller
{
    public function __construct(
        private SportsConfigService $sportsConfigService,
        private SportsConfigRepository $sportsConfigRepo
    ) {
    }

    public function index()
    {
        $data['data'] = $this->sportsConfigRepo->getConfig();

        return view('Admin.PageSetting.OptionGames.Sports.index', $data);
    }

    public function update(Request $request)
    {
        $res = $this->sportsConfigService->update($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.sport-config.index')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.sport-config.index')->with('error', '업데이트 실패');
    }

    public function toggleField(string $field = null)
    {
        $status = $this->sportsConfigService->toggleField($field);
        return response()->json(['status' => $status]);
    }
}
