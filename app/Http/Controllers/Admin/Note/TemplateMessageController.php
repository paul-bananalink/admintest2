<?php

namespace App\Http\Controllers\Admin\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TemplateMessageRequest;
use App\Repositories\TemplateMessageRepository;
use App\Services\TemplateMessageService;
use App\Repositories\AutoReplyRepository;

class TemplateMessageController extends Controller
{
    public function __construct(
        private TemplateMessageService $templateMessageService,
        private TemplateMessageRepository $templateMessageRepo,
        private AutoReplyRepository $autoReplyRepo,
    ) {
    }

    public function index()
    {
        $data = [
            'data' => $this->templateMessageService->getAll(\App\Models\TemplateMessage::TYPE_NOTE),
        ];

        return view('Admin.Note.template', $data);
    }

    public function viewCreate()
    {
        return view('Admin.Note.form_create_template');
    }

    public function create(TemplateMessageRequest $request)
    {
        $template = $this->templateMessageService->createWithNote($request->all());

        if ($template) {
            return redirect()->route('admin.note.indexTemplate')->with('success', '신류 등록 성공');
        }

        return redirect()->route('admin.note.indexTemplate')->with('error', '신류 등록 실패');
    }

    public function edit($id)
    {
        $data = $this->templateMessageRepo->getByPK($id);
        if (!$data) {
            return redirect()->back()->with('error', '찾을 수 없다');
        }
        return view('Admin.Note.form_edit_template', ['data' => $data]);
    }

    public function update($id, TemplateMessageRequest $request)
    {
        $update = $this->templateMessageRepo->updateByPK($id, $request->all());

        if ($update) {
            return redirect()->route('admin.note.indexTemplate')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.note.indexTemplate')->with('error', '업데이트 실패');
    }

    public function delete($id)
    {
        $data = $this->templateMessageRepo->getByPK($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => '찾을 수 없다'], 404);
        }
        $delete = $data->delete();
        if ($delete) {
            return response()->json(['success' => true, 'message' => '삭제되었습니다'], 200);
        }

        return response()->json(['success' => false, 'message' => '실패적으로 삭제'], 500);
    }

    public function ajaxGetContent(int $id)
    {
        $data = $this->autoReplyRepo->getByPK($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data], 200);
        } else {
            return response()->json(['error' => false, 'message' => '찾을 수 없다'], 404);
        }
    }

    public function ajaxGetContentNote(int $id)
    {
        $data = $this->templateMessageRepo->getByPK($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data], 200);
        } else {
            return response()->json(['error' => false, 'message' => '찾을 수 없다'], 404);
        }
    }
}