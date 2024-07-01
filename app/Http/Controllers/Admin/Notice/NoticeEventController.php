<?php

namespace App\Http\Controllers\Admin\Notice;

use App\Http\Controllers\Controller;
use App\Services\NoticeService;
use App\Models\Notice;

class NoticeEventController extends Controller
{
    public function __construct(private NoticeService $noticeService)
    {
    }

    public function index()
    {
        $notices = $this->noticeService->paginateByType(Notice::EVENT_TYPE);

        return view('Admin.Notice.Event.index', compact('notices'));
    }

    public function edit($id)
    {
        if (request()->isMethod('post')) {
            $this->noticeService->update($id);

            return redirect()->route('admin.notice.event.index');
        }

        $notices = $this->noticeService->paginateByType(Notice::EVENT_TYPE);

        $notice = $this->noticeService->find($id);

        return view('Admin.Notice.Event.index', compact('notice', 'notices'));
    }

    public function inActive($id)
    {
        $this->noticeService->inActive($id);

        return redirect()->route('admin.notice.event.index')->with('success', '삭제되었습니다.');
    }

    public function store()
    {
        $this->noticeService->store();

        return redirect()->route('admin.notice.event.index');
    }
}
