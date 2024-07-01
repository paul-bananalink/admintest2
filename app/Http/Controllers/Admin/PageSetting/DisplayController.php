<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Services\DisplayService;

class DisplayController extends Controller
{
    public function __construct(private DisplayService $displayService)
    {
    }

    public function index(): View
    {
        $data = $this->displayService->getDisplay();

        return view('Admin.PageSetting.Display.index', compact('data'));
    }

    public function store()
    {
        $this->displayService->updateOrCreate(request()->all());

        return redirect()->route('admin.page-setting.display.index');
    }

    public function render($form)
    {
        return response()->json([
            'form' => view('Admin.PageSetting.Display.form_' . $form)->render()
        ]);
    }
}
