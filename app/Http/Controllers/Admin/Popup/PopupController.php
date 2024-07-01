<?php

namespace App\Http\Controllers\Admin\Popup;

use App\Http\Controllers\Controller;
use App\Services\PopupService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PopupController extends Controller
{
    /**
     * Dependency injection constructor
     * https://laravel.com/docs/11.x/container#introduction
     */
    public function __construct(
        private PopupService $popupService
    ) {
    }

    public function index(): View
    {
        $data['data'] = $this->popupService->getData();
        return view('Admin.Popup.index', $data);
    }

    public function create(): View
    {
        return view('admin.popup.create');
    }

    public function update(int $id, Request $request)
    {
        $updated = $this->popupService->update($id, data_get($request->all(), 'data', []));

        if ($updated) {
            return response()->json(['status' => true, 'data' => $updated]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function enableDisable(int $poNo = null, string $field): bool
    {
        return $this->popupService->change($poNo, $field);
    }

    public function reset(int $poNo)
    {
        $deleted = $this->popupService->reset($poNo);

        if ($deleted) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function destroy(int $id)
    {
        $deleted = $this->popupService->getRepo()->deleteByPK($id);

        if ($deleted) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
