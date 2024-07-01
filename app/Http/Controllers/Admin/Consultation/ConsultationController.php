<?php

namespace App\Http\Controllers\Admin\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReplyConsultationRequest;
use App\Repositories\ConsultationRepository;
use App\Services\ConsultationService;
use App\Services\AutoReplyService;
use App\Services\TemplateMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function __construct(
        private ConsultationService $consultationService,
        private ConsultationRepository $consultationRepo,
        private TemplateMessageService $templateMessageService,
        private AutoReplyService $autoReplyService,
    ) {
    }

    public function index()
    {
        $data['data'] = $this->consultationService->getAll();
        // $data['count_no_replied'] = $this->consultationService->totalItemByStatus(\App\Models\Consultation::SEARCH_TYPE_NO_REPLIED);

        return view('Admin.Consultation.index', $data);
    }

    public function showModalReply($id)
    {
        $res = $this->consultationRepo->getByPK($id);
        $data = [
            'data' => $res,
            'templates' => $this->templateMessageService->getAll(),
            'writer' => Auth::user()->mID,
        ];

        if ($res) {
            return view('Admin.Consultation.modal.reply')->with($data);
        }

        return redirect()->route('admin.consultation.index')->with('error', '찾을 수 없다');
    }

    public function reply($id, ReplyConsultationRequest $request)
    {
        $data = $request->all();
        $res = $this->consultationService->reply($id, $data);

        if ($res) {
            return redirect()->route('admin.consultation.index')->with('success', '삭제되었습니다');
        }

        return redirect()->route('admin.consultation.index')->with('error', '찾을 수 없다');
    }

    public function delete($id)
    {
        $data = $this->consultationRepo->getByPK($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => '찾을 수 없다'], 404);
        }

        $delete = $data->delete();

        if ($delete) {
            return response()->json(['success' => true, 'message' => '삭제되었습니다'], 200);
        }

        return response()->json(['success' => false, 'message' => '실패적으로 삭제'], 500);
    }

    public function ajaxShowReply(Request $request)
    {
        $request = $request->all();
        $is_open = data_get($request, 'is_open_reply', 0);
        $id = data_get($request, 'id');

        $data = $this->consultationRepo->getByPK($id);

        return view('Admin.Consultation.form_reply', [
            'data' => $data,
            'is_open' => $is_open,
            'templates' => data_get(
                $this->autoReplyService->getAutoReplies(),
                'normal_types'
            )
        ])->render();
    }
}
