<?php

namespace App\Http\Controllers\Partner\PartnerManager;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Services\Partner\PartnerManagerService;

class PartnerManagerController extends Controller
{
    public function __construct(
        private PartnerManagerService $partnerService,
    ) {
    }

    public function index(): View
    {
        $data['data'] = $this->partnerService->getTreeViewPartner();

        return view('Partner.Manager.index', $data);
    }

    public function indexLevel($level_type)
    {
        $data['partners'] = $this->partnerService->paginatePartners($level_type);

        $data['title'] = app('site_info')->siPartners[$level_type] ?? '전체';

        $data['type'] = $level_type;

        return view('Partner.Manager.level.index', $data);
    }
}
