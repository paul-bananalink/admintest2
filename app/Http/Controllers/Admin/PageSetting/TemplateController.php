<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Services\TemplateMessageService;

class TemplateController extends Controller
{
    public function __construct(private TemplateMessageService $templateMessageService)
    {
    }

    public function index()
    {
        $data['templates'] = $this->templateMessageService->getTemplates();

        return view('Admin.PageSetting.Template.index', $data);
    }

    public function store()
    {
        $this->templateMessageService->createOrUpdate(request()->all());

        return redirect()->route('admin.page-setting.template.index');
    }
}
