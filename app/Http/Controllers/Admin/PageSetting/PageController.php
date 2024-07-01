<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockIpRequest;
use App\Http\Requests\Admin\DeleteBlockIpRequest;
use App\Http\Requests\Admin\PageSettingRequest;
use App\Http\Requests\Admin\RechargeSettingRequest;
use App\Services\GameProviderService;
use App\Services\SiteInfoService;

class PageController extends Controller
{
    public function __construct(
        private SiteInfoService $siteInfoService,
        private GameProviderService $gameProviderService,
    ) {
    }

    /**
     * Controller focus to get list data render to view
     */
    public function index()
    {
        $data = $this->siteInfoService->getSiteInfo();

        return view('Admin.PageSetting.page_setting', $data);
    }

    /**
     * Controller focus handle update page setting
     */
    public function indexSave(PageSettingRequest $request)
    {
        $this->siteInfoService->createPageSetting($request->all());

        return redirect()->route('admin.page-setting.index');
    }

    /**
     * Controller focus handle update page setting
     */
    public function indexSaveConfig(PageSettingRequest $request)
    {
        $result = $this->siteInfoService->createPageSetting($request->except('_token'));

        return response()->json(['result' => $result]);
    }

    public function blockIp()
    {
        $data['member_disallow_ips'] = $this->siteInfoService->paginateDisAllowIps();

        return view('Admin.PageSetting.page_setting_block_ip', $data);
    }

    /**
     * Controller focus handle update block ip setting
     */
    public function blockIpSave(BlockIpRequest $request)
    {
        $this->siteInfoService->blockIpSetting($request->all());

        return redirect()->route('admin.page-setting.block-ip');
    }

    /**
     * Controller focus handle delete block ip setting
     *
     * @param  PageSettingRequest  $request
     */
    public function blockIpDelete(DeleteBlockIpRequest $request)
    {
        $this->siteInfoService->blockIpDelete($request->all());

        return redirect()->route('admin.page-setting.block-ip');
    }

    public function settingCategory(string $category = '')
    {
        $data = $this->gameProviderService->handle($category);
        return view('Admin.PageSetting.page_setting_category', $data);
    }

    public function enableDisableCategory(string $category = ''): bool
    {
        return $this->siteInfoService->changeCategory($category);
    }

    public function enableDisableGameProvider(int $gpNo = null): bool
    {
        return $this->gameProviderService->changeEnableGameProvider($gpNo);
    }

    public function toggleMaintenanceGameProvider(int $gpNo = null, string $type): bool
    {
        return $this->gameProviderService->toggleMaintenanceGameProvider($gpNo, $type);
    }

    public function getGames(string $gpCode = '')
    {
        $games = $this->gameProviderService->getGamesByGpCode($gpCode);
        return response()->json(['games' => $games]);
    }

    public function enableDisableGame(int $gNo = null): bool
    {
        return $this->gameProviderService->changeStatusGame($gNo);
    }

    public function toggleField(string $field = null)
    {
        $status = $this->siteInfoService->toggleField($field);
        return response()->json(['status' => $status]);
    }

    public function getGame(string $gpCode = '')
    {
        $games = $this->gameProviderService->getGamesByGpCode($gpCode);
        return response()->json(['games' => $games]);
    }

    public function getGameInfo(string $gpCode = '')
    {
        $games = $this->gameProviderService->getGamesByGpCode($gpCode);
        return response()->json(['games' => $games]);
    }
}
