<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Services\CasinoConfigService;
use Illuminate\Http\Request;
use App\Repositories\CasinoConfigRepository;
use App\Repositories\GameProviderRepository;
use App\Repositories\GameRepository;
use App\Services\GameProviderService;
use App\Services\GameService;
use Carbon\CarbonPeriod;

class CasinoController extends Controller
{
    public function __construct(
        private CasinoConfigService $casinoConfigService,
        private CasinoConfigRepository $casinoConfigRepo,
        private GameProviderService $gameProviderService,
        private GameProviderRepository $gameProviderRepository,
        private GameService $gameService,
        private GameRepository $gameRepository,
    ) {
    }

    public function index(string $ccType)
    {
        if (empty(request('gpCode'))) {
            $gp = $this->gameProviderRepository->firstByType($ccType);
            $route = request()->route()->getName();

            return redirect()->route($route, ['ccType' => $ccType, 'gpCode' => $gp->gpCode, ...request()->query()]);
        }

        $data['data'] = $this->casinoConfigRepo->getConfig($ccType);
        $data['ccType'] = $ccType;
        $data['gameConfigData'] = $this->gameProviderService->handleConfigCasinoByCategory($ccType);

        return view('Admin.PageSetting.OptionGames.Casino.index', $data);
    }

    public function update(string $ccType, Request $request)
    {
        $request['gpTimeMaintain'] = convertDateTimeRangeToString($request->maintain_from_date, $request->maintain_from_time, $request->maintain_to_date, $request->maintain_to_time);
        $res = $this->gameProviderService->updateData($ccType, $request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.casino-config.index', ['ccType' => $ccType, 'gpCode' => $request->gpCode])->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.casino-config.index', ['ccType' => $ccType, 'gpCode' => $request->gpCode])->with('error', '업데이트 실패');
    }

    public function toggleFieldConfig(string $field = null, string $ccType)
    {
        $status = $this->casinoConfigService->toggleField($field, $ccType);
        return response()->json(['status' => $status]);
    }

    public function toggleField(string $field = null, int $gNo)
    {
        $status = $this->gameService->toggleField($field, $gNo);
        return response()->json(['status' => $status]);
    }

    public function updateGame(string $ccType, Request $request)
    {
        $res = $this->gameService->updateGame($request->gData);

        if ($res) {
            return redirect()->route('admin.page-setting.casino-config.index', ['ccType' => $ccType, 'gpCode' => $request->gpCode])->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.casino-config.index', ['ccType' => $ccType, 'gpCode' => $request->gpCode])->with('error', '업데이트 실패');
    }
}
