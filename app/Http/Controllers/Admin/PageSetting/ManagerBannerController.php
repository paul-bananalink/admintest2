<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use App\Services\BannerService;
use App\Services\SiteInfoService;
use Illuminate\Http\Request;

class ManagerBannerController extends Controller
{
    public function __construct(
        private SiteInfoService $siteInfoService,
        private BannerService $bannerService,
        private BannerRepository $bannerRepo
    ) {
    }

    public function index(string $type)
    {
        if (in_array($type, Banner::TYPES)) {
            return $this->{$type}();
        }
        return abort(404);
    }
    
    /**
     * Controller focus to get list data render to view
     */
    public function logo()
    {
        $data = $this->siteInfoService->getSiteInfo();
        return view('Admin.PageSetting.manager_banner.page_logo', $data);
    }

    public function updateLogo(Request $request)
    {
        $result = $this->siteInfoService->update($request->except('_token'));

        if ($result) {
            return redirect()->back()->with('success', '업데이트 성공');
        } else {
            return redirect()->back()->with('error', '업데이트 실패');
        }
    }

    /**
     * Controller focus to get list data render to view
     */
    public function center()
    {
        $data['data'] = $this->bannerService->getBanner(Banner::TYPE_CENTER);
        return view('Admin.PageSetting.manager_banner.page_center', $data);
    }

    /**
     * Controller focus to get list data render to view
     */
    public function centerBelow()
    {
        $data['data'] = $this->bannerService->getBanner(Banner::TYPE_CENTER_BELOW);
        return view('Admin.PageSetting.manager_banner.page_center_below', $data);
    }

    /**
     * Controller focus to get list data render to view
     */
    public function right()
    {
        $data['data'] = $this->bannerService->getBanner(Banner::TYPE_RIGHT);
        return view('Admin.PageSetting.manager_banner.page_right', $data);
    }

    /**
     * Controller focus to get list data render to view
     */
    public function left()
    {
        $data['data'] = $this->bannerService->getBanner(Banner::TYPE_LEFT);
        return view('Admin.PageSetting.manager_banner.page_left', $data);
    }

    public function ajaxGetBannerItem()
    {
        return view('Admin.PageSetting.manager_banner.ajax.banner-item');
    }

    public function updateBanner(UpdateBannerRequest $request)
    {
        $update = $this->bannerService->update($request->all());

        if ($update) {
            return redirect()->route('admin.page-setting.manager-banner.index', ['type' => $request->bPosition])->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.manager-banner.index', ['type' => $request->bPosition])->with('error', '업데이트 실패');
    }

    public function delete($id)
    {
        $data = $this->bannerRepo->getByPK($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => '찾을 수 없다'], 404);
        }
        $delete = $data->delete();
        if ($delete) {
            return response()->json(['success' => true, 'message' => '삭제되었습니다'], 200);
        }

        return response()->json(['success' => false, 'message' => '실패적으로 삭제'], 500);
    }
}
