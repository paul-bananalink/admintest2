<?php

namespace App\Http\Controllers\Admin\Sport;

use App\Http\Controllers\Controller;
use App\Services\Sports\SportService;
use Illuminate\Http\Request;
use App\Repositories\TbTeamRepository;

class SportController extends Controller
{
    public function __construct(
        private SportService $sportService,
        private TbTeamRepository $tbTeamRepository
    ) {
    }

    /**
     * Page index is show infomation of line money
     */
    public function index($type)
    {
        $data['type'] = $type;
        $data['data'] = $this->sportService->getDataByType($type);

        return view('Admin.Sport.index', $data);
    }

    public function toggleShow($type, $idx)
    {
        $status = $this->sportService->toggleShow($type, $idx);
        return response()->json(['status' => $status]);
    }

    public function updateTable(string $type, Request $request)
    {
        $updated = $this->sportService->updateTable($type, $request->all());

        if ($updated) {
            return redirect()->back()->with('success', '업데이트 성공.');
        }

        return redirect()->back()->with('error', '업데이트 실패.');
    }

    public function updateRowTableTeam($idx, Request $request)
    {
        $status = $this->sportService->updateRowTableTeam($idx, data_get($request->all(), 'data', []));
        return response()->json(['status' => $status, 'message' => $status ? '업데이트 성공.' : '업데이트 실패.']);
    }
}
