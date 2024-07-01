<?php

namespace App\Http\Controllers\Admin\Notice;

use App\Http\Controllers\Controller;
use App\Services\NoticeService;
use App\Models\Notice;

class NoticePartnerController extends Controller
{
    public function __construct(private NoticeService $noticeService)
    {
    }

    public function index()
    {
        $notices = $this->noticeService->paginateByType(Notice::PARTNER_TYPE);

        return view('Admin.Notice.Partner.index', compact('notices'));
    }

    public function edit($id)
    {
        if (request()->isMethod('post')) {
            $this->noticeService->update($id);

            return redirect()->route('admin.notice.partner.index');
        }

        $notices = $this->noticeService->paginateByType(Notice::PARTNER_TYPE);

        $notice = $this->noticeService->find($id);

        return view('Admin.Notice.Partner.index', compact('notice', 'notices'));
    }

    public function inActive($id)
    {
        $this->noticeService->inActive($id);

        return redirect()->route('admin.notice.partner.index')->with('success', '삭제되었습니다.');
    }

    public function store()
    {
        $notice = $this->noticeService->store();

        $this->noticeService->sendToMembers($notice->ntNo);

        return redirect()->route('admin.notice.partner.index');
    }
}
