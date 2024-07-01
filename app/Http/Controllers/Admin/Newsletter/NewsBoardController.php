<?php

namespace App\Http\Controllers\Admin\Newsletter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsBoardRequest;
use App\Repositories\NewsletterRepository;
use App\Services\NewsBoardService;
use Illuminate\Http\Request;

class NewsBoardController extends Controller
{
    public function __construct(
        private NewsletterRepository $newsletterRepo,
        private NewsBoardService $newsBoardService
    ) {
    }

    public function index()
    {
        $data['data'] = $this->newsletterRepo->getAllNewsBoard();
        $data['categories'] = \App\Models\Newsletter::$categories_newboard;
        $data['count_items'] = $this->newsletterRepo->listCountNewsBoardByCategory();

        return view('Admin.NewsBoard.index', $data);
    }

    public function viewCreate()
    {
        $data['categories'] = \App\Models\Newsletter::$categories_newboard;

        return view('Admin.NewsBoard.create', $data);
    }

    public function create(NewsBoardRequest $request)
    {
        $res = $this->newsletterRepo->createNewsBoard($request->all());

        if ($res) {
            return redirect()->route('admin.news-board.index')->with('success', '신류 등록 성공');
        }

        return redirect()->route('admin.news-board.index')->with('error', '신류 등록 실패');
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

    public function edit($id)
    {
        $res = $this->newsletterRepo->getByPK($id);

        if (!$res) {
            return redirect()->back()->with('error', '찾을 수 없다');
        }

        $data['data'] = $res;
        $data['categories'] = \App\Models\Newsletter::$categories_newboard;

        return view('Admin.NewsBoard.edit', $data);
    }

    public function update($id, NewsBoardRequest $request)
    {
        $update = $this->newsletterRepo->updateById($id, $request->all());

        if ($update) {
            return redirect()->route('admin.news-board.index')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.news-board.index')->with('error', '업데이트 실패');
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
        $status = $this->newsBoardService->toggleField($id);
        return response()->json(['status' => $status]);
    }
}
