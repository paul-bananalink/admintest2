<?php

namespace App\Http\Controllers\Admin\MoneyInfo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRechargeOrWithdrawRequest;
use App\Services\MoneyInfoService;
use Illuminate\Http\Request;
use App\Exports\MoneyInfoExport;
use Maatwebsite\Excel\Facades\Excel;

class MoneyInfoController extends Controller
{
    public function __construct(
        private MoneyInfoService $moneyInfoService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $type)
    {
        $attributes = $request->all();
        $attributes['type'] = $data['type'] = $type;

        $data['data'] = $this->moneyInfoService->getAll($attributes);

        $data['over_view'] = $this->moneyInfoService->getOverview($attributes);

        $data['config'] = data_get($data, 'over_view.config', []);

        $data['title'] = $type == 'withdraw' ? '출금' : '입금';

        $data['is_rollback_mode'] = isset($attributes['mode']) && $attributes['mode'] == 'rollback';

        return view('Admin.MoneyInfo.index', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $type, string $id)
    {
        try {
            $status = $this->moneyInfoService->update($request->all(), $id);
            if ($status) {
                return response()->json(['success' => true, 'message' => '업데이트 성공']);
            } else {
                return response()->json(['success' => false, 'message' => '업데이트 실패']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    function updateIds(Request $request, string $type = '')
    {
        $status = $this->moneyInfoService->updateIds($request->all());
        return response()->json(['success' => $status, 'message' => $status ? '업데이트 성공' : '업데이트 실패']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $type, $id)
    {
        $status = $this->moneyInfoService->delete($id);
        if ($status) {
            return response()->json(['success' => true, 'message' => '삭제되었습니다']);
        } else {
            return response()->json(['success' => false, 'message' => '실패적으로 삭제']);
        }
    }

    public function histories(Request $request, string $type, $id)
    {
        $data['data'] = $this->moneyInfoService->find($id);
        if (empty($data['data'])) {
            abort(404);
        }

        $data['type'] = $type;

        return view('Admin.MoneyInfo.histories', $data);
    }

    public function directRechargeOrWithdraw(AdminRechargeOrWithdrawRequest $request, $mID)
    {
        try {
            $attributes = $request->all();
            $attributes['mID'] = $mID;

            $moneyInfo = $this->moneyInfoService->create($attributes);
            if (!$moneyInfo) {
                return response()->json(['status' => false, 'message' => 'Money info not found']);
            }

            return response()->json(['status' => true, 'message' => 'success', 'money_info' => $moneyInfo->member]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function export($type)
    {
        return Excel::download(new MoneyInfoExport($this->moneyInfoService, $type), $type . '_' . date('Y_m_d') . '.xlsx');
    }
}
