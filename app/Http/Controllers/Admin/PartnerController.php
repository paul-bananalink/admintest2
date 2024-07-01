<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PartnerService;
use Illuminate\Http\Request;
use App\Repositories\PartnerRepository;
use App\Services\RechargeConfigService;

class PartnerController extends Controller
{
    public function __construct(
        private PartnerService $partnerService,
        private PartnerRepository $partnerRepository,
        private RechargeConfigService $rechargeConfigService
    ) {
    }

    public function index()
    {
        $data['data'] = $this->partnerService->getTreeView();

        return view('Admin.MemberPartner.index', $data);
    }

    public function indexLevel($level_type)
    {
        $data['partners'] = $this->partnerService->paginatePartners($level_type);

        $data['title'] = app('site_info')->siPartners[$level_type] ?? '전체';

        $data['type'] = $level_type;

        return view('Admin.MemberPartner.level.index', $data);
    }

    public function create(Request $request)
    {
        $res = $this->partnerService->create($request->all());

        if ($res) {
            return redirect()->route('admin.partner.indexLevel', ['level_type' => 'all'])->with('success', '신류 등록 성공');
        } else {
            return redirect()->route('admin.partner.indexLevel', ['level_type' => 'all'])->with('error', '신류 등록 실패');
        }
    }

    public function ajaxValidData(Request $request)
    {
        if ($request->input('form')) {
            $res = $this->partnerService->validData($request->all());
        } else {
            $res = $this->partnerService->validData($request->input('data'));
        }

        return response()->json($res);
    }

    //Sau bo
    public function ajaxGetData($pNo)
    {
        $res = $this->partnerService->getDataItem($pNo);

        return response()->json($res);
    }

    public function ajaxGetFormData($pNo)
    {
        $data['data'] = $this->partnerRepository->getByPk($pNo);
        $data['bankList'] = $this->rechargeConfigService->getBanks();
        return view('Admin.Common.Modal.Partner.form_update_partner', $data)->render();
    }

    public function update($pNo, Request $request)
    {
        $valid = $this->partnerService->validData($request->all());

        if (!$valid["success"]) return response()->json($valid);

        $res = $this->partnerService->update($pNo, $request->all());

        if ($res) {
            return response()->json(['success' => true, 'message' => '업데이트 성공']);
        } else {
            return response()->json(['success' => false, 'message' => '업데이트 실패']);
        }
    }

    public function toggleField(string $field = null, $pNo)
    {
        $status = $this->partnerService->toggleField($field, $pNo);
        return response()->json(['status' => $status]);
    }

    public function ajaxGetDataPartner()
    {
        $data = $this->partnerService->getDataTreeview();
        $arr_open = !empty(json_decode(request('data_show'), true)) ? $this->partnerService->setDataShowPartners(json_decode(request('data_show'), true)) : [];

        return response()->json(['data' => $data, 'show_list' => $arr_open]);
    }

    public function updateTreePartner()
    {
        $data = request()->input('data');

        $res = $this->partnerService->updateTreePartner($data);

        return response()->json(['status' => $res['status'] ? 'success' : 'warning', 'message' => $res['status'] ? '업데이트 성공' : $res['message']]);
    }
}
