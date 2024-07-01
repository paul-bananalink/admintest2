<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Services\AutoReplyService;

class AutoReplyController extends Controller
{
    public function __construct(private AutoReplyService $autoReplyService)
    {
    }

    public function index()
    {
        $data = $this->autoReplyService->getAutoReplies();

        return view('Admin.PageSetting.AutoReply.index', $data);
    }

    public function store()
    {
        $this->autoReplyService->createOrUpdate(request()->all());

        return redirect()->route('admin.page-setting.auto-reply.index');
    }

    public function getForm($form)
    {
        if ($form == 'quick') {
            $view = view('Admin.PageSetting.AutoReply.quick_form')->render();
        }

        if ($form == 'normal') {
            $view = view('Admin.PageSetting.AutoReply.normal_form')->render();
        }

        return response()->json($view);
    }
}
