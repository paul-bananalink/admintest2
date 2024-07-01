<?php

namespace App\Http\Controllers\Admin\Casino;

use App\Http\Controllers\Controller;
use App\Services\GameProviderService;
use App\Repositories\GameProviderRepository;
use Illuminate\Http\Request;

class GameProviderController extends Controller
{
    public function __construct(
        private GameProviderService $gameProviderService,
        private GameProviderRepository $gameProviderRepository
    ) {
    }

    public function index()
    {
        $data['data'] = $this->gameProviderService->getAll();
        $data['start_no'] = $this->gameProviderService->getNoTotal(
            $data['data']->total(),
            $data['data']->perPage(),
            $data['data']->currentPage()
        );

        return view('Admin.GameProvider.index', $data);
    }

    public function edit(int $id)
    {
        $data['data'] = $this->gameProviderRepository->getByPK($id);

        if (!$data['data']) abort(404);

        return view('Admin.GameProvider.edit', $data);
    }

    public function update(int $id, Request $request)
    {
        $update = $this->gameProviderService->update($id, $request->all());

        if ($update) {
            return redirect()->route('admin.game-provider.index')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.game-provider.index')->with('error', '업데이트 실패');
    }

    public function ajaxUpdate(int $id, Request $request)
    {
        $is_update = $this->gameProviderService->update($id, $request->all());

        if ($is_update) {
            return $this->responseData(['messages' => '업데이트 성공', 'type' => 'success']);
        }
        return $this->responseData(['messages' => '업데이트 실패', 'type' => 'error'], 400);
    }

    public function handleGameProvider()
    {
        $this->gameProviderService->handleGetGameProvider();

        return 'Update game provider success!';
    }
}
