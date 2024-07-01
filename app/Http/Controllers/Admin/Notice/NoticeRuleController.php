<?php

namespace App\Http\Controllers\Admin\Notice;

use App\Http\Controllers\Controller;
use App\Services\NoticeService;
use App\Models\Notice;

class NoticeRuleController extends Controller
{
    public function __construct(private NoticeService $noticeService)
    {
    }

    public function index()
    {
        $notices = $this->noticeService->paginateByType(Notice::RULE_TYPE);

        return view('Admin.Notice.Rule.index', compact('notices'));
    }

    public function edit($id)
    {
        if (request()->isMethod('post')) {
            $this->noticeService->update($id);

            return redirect()->route('admin.notice.rule.index');
        }

        $notices = $this->noticeService->paginateByType(Notice::RULE_TYPE);

        $notice = $this->noticeService->find($id);

        if ($notice == null) {
            return redirect()->route('admin.notice.rule.index');
        }

        return view('Admin.Notice.Rule.index', compact('notice', 'notices'));
    }

    public function inActive($id)
    {
        $this->noticeService->inActive($id);

        return redirect()->route('admin.notice.rule.index')->with('success', '삭제되었습니다.');
    }

    public function store()
    {
        $this->noticeService->store();

        return redirect()->route('admin.notice.rule.index');
    }
}
