<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Services\MiniGameConfigService;
use Illuminate\Http\Request;
use App\Repositories\MiniGameConfigRepository;

class MiniGameController extends Controller
{
    public function __construct(
        private MiniGameConfigService $miniGameConfigService,
        private MiniGameConfigRepository $miniGameConfigRepo
    ) {
    }

    public function index(string $gcType)
    {
        $data['data'] = $this->miniGameConfigRepo->getConfig($gcType);
        $data['gcType'] = $gcType;

        return view('Admin.PageSetting.OptionGames.Games.index', $data);
    }

    public function update(string $gcType, Request $request)
    {
        $res = $this->miniGameConfigService->update($request->all(), $gcType);

        if ($res) {
            return redirect()->route('admin.page-setting.game-config.index', ['gcType' => $gcType])->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.game-config.index', ['gcType' => $gcType])->with('error', '업데이트 실패');
    }

    public function toggleField(string $field = null, string $gcType)
    {
        $status = $this->miniGameConfigService->toggleField($field, $gcType);
        return response()->json(['status' => $status]);
    }
}
