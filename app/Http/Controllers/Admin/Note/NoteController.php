<?php

namespace App\Http\Controllers\Admin\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NoteRequest;
use App\Http\Requests\Admin\AddNoteRequest;
use App\Repositories\MemberRepository;
use App\Repositories\NoteRepository;
use App\Services\NoteService;
use App\Events\Client\DeletedNoteEvent;
use App\Services\TemplateMessageService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct(
        private NoteService $noteService,
        private NoteRepository $noteRepo,
        private MemberRepository $memberRepo,
        private TemplateMessageService $templateMessageService
    ) {
    }

    public function index()
    {
        $data['types'] = \App\Models\Note::getTypes();
        $data['notes'] = $this->noteService->getAll();
        $data['categories_send'] = \App\Models\Note::$categories_send;
        $data['templates'] = $this->templateMessageService->getTemplates();

        return view('Admin.Note.index', $data);
    }

    public function view(int $id)
    {
        $note = $this->noteRepo->getByPK($id);
        if (!$note) {
            return redirect()->route('admin.note.index')->with('error', '찾을 수 없다');
        }

        $data['note'] = $note;

        return view('Admin.Note.modal.view', $data);
    }

    public function delete($id)
    {
        $data = $this->noteRepo->getByPK($id);
        if (!$data) {
            return response()->json(['success' => false, 'message' => '찾을 수 없다'], 404);
        }

        $delete = $data->delete();

        if ($delete) {

            if ($data->type == \App\Models\Note::TYPE_ONLY_USER) {
                event(new DeletedNoteEvent($data->mNo_receive));
            } else {
                event(new DeletedNoteEvent('all'));
            }

            return response()->json(['success' => true, 'message' => '삭제되었습니다'], 200);
        }

        return response()->json(['success' => false, 'message' => '실패적으로 삭제'], 500);
    }

    public function addNote(AddNoteRequest $request)
    {
        $res = $this->noteService->addNote($request->all());

        if ($res) {
            return $this->responseData(['message' => '신류 등록 성공', 'type' => 'success']);
        }

        return $this->responseData(['message' => '신류 등록 실패', 'type' => 'error'], 400);
    }

    public function sendNoteAll($id)
    {
        return $this->noteService->sendNote($id);
    }

    public function sendNoteToUser(NoteRequest $request)
    {
        $data = $request->all();

        $res = $this->noteService->sendNoteToUser($data);

        if ($request->ajax()) {
            return response()->json(['status' => (bool)$res]);
        }
    }

    public function deleteAllNote()
    {
        $this->noteService->deleteAllNote();

        return redirect()->route('admin.note.index')->with('success', '삭제되었습니다.');
    }

    public function deleteAllNoteIsRead()
    {
        $this->noteService->deleteAllNoteIsRead();

        return redirect()->route('admin.note.index')->with('success', '삭제되었습니다.');
    }

    public function viewCreate()
    {
        $data = [];
        $data['templates'] = $this->templateMessageService->getAll(\App\Models\TemplateMessage::TYPE_NOTE);
        $data['categories_send'] = \App\Models\Note::$categories_send;

        return view('Admin.Note.modal.add_note', $data);
    }

    public function viewCreateNoteSendUser($mNo)
    {
        $data['member'] = $this->memberRepo->getByPK($mNo);

        return view('Admin.Note.modal.send_note_to_user', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data['data'] = $this->noteRepo->getByPK($id);
        $data['templates'] = $this->templateMessageService->getAll(\App\Models\TemplateMessage::TYPE_NOTE);
        if (!$data) {
            return redirect()->back()->with('error', '찾을 수 없다');
        }
        return view('Admin.Note.edit', $data);
    }

    public function update($id, NoteRequest $request)
    {
        $update = $this->noteRepo->updateByPK($id, $request->all());

        if ($update) {
            return redirect()->route('admin.note.index')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.note.index')->with('error', '업데이트 실패');
    }

    public function ajaxGetTextAreaListUser()
    {
        return view('Admin.Note.ajax.textarea-list-member')->render();
    }

    public function ajaxGetSelectLevel()
    {
        return view('Admin.Note.ajax.select-list-level-member')->render();
    }

    public function ajaxGetCheckboxPartner()
    {
        return view('Admin.Note.ajax.checkbox-partner')->render();
    }

    public function recall(Request $request)
    {
        $res = $this->noteService->recall($request->input('uuid'));

        return response()->json(['status' => $res['status'], 'message' => $res['message']]);
    }
}
