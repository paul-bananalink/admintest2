<?php

namespace App\Http\Controllers\Admin\Newsletter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Repositories\NewsletterRepository;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private NewsletterRepository $newsletterRepo,
        private EventService $eventService
    ) {
    }

    public function index()
    {
        $data['data'] = $this->newsletterRepo->getAllEvent();

        return view('Admin.Event.index', $data);
    }

    public function viewCreate()
    {
        return view('Admin.Event.create');
    }

    public function create(EventRequest $request)
    {
        $res = $this->newsletterRepo->createEvent($request->all());
        if ($res) {
            return redirect()->route('admin.event.index')->with('success', '신류 등록 성공');
        }

        return redirect()->route('admin.event.index')->with('error', '신류 등록 실패');
    }

    public function edit($id)
    {
        $data = $this->newsletterRepo->getByPK($id);
        if (!$data) {
            return redirect()->back()->with('error', '찾을 수 없다');
        }
        $data->created_date = \Carbon\Carbon::parse($data->created_date)->format('Y/m/d h:i:s A');

        return view('Admin.Event.edit', ['data' => $data]);
    }

    public function update($id, EventRequest $request)
    {
        $update = $this->newsletterRepo->updateById($id, $request->all());

        if ($update) {
            return redirect()->route('admin.event.index')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.event.index')->with('error', '업데이트 실패');
    }

    public function updateStatus($id, Request $request)
    {
        $update = $this->newsletterRepo->updateShowUI($id, $request->all());
        if ($update) {
            return response()->json(['success' => true, 'message' => '업데이트 성공'], 200);
        }

        return response()->json(['success' => false, 'message' => '업데이트 실패'], 500);
    }

    public function toggleField(int $id)
    {
        $status = $this->eventService->toggleField($id);
        return response()->json(['status' => $status]);
    }

    public function delete($id)
    {
        $data = $this->newsletterRepo->getByPK($id);
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
