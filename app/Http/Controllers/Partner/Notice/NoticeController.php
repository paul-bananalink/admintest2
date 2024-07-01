<?php

namespace App\Http\Controllers\Partner\Notice;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Notice;
use App\Repositories\NoticeRepository;
use App\Services\NoticeService;

class NoticeController extends Controller
{
    public function __construct(
        private NoticeService $noticeService,
        private NoticeRepository $noticeRepo,
    ) {
    }

    public function index()
    {
        /** @var Member */
        $partner = auth()->guard('partner')->user();
        $partner->notice_member()->update(['nmRead' => 1]);
        $data = $this->noticeService->paginateByTypeAndPartner(Notice::PARTNER_TYPE, $partner->mID);

        return view('Partner.Notice.index', compact('data'));
    }

    public function ajaxGetContent(int $ntNo)
    {
        $data['data'] = $this->noticeRepo->getByPK($ntNo);

        return view('Partner.Notice.ajax.content', $data)->render();
    }
}
