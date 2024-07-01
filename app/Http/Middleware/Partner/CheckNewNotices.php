<?php

namespace App\Http\Middleware\Partner;

use App\Models\Notice;
use App\Repositories\NoticeRepository;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CheckNewNotices
{
    public function __construct(
        private NoticeRepository $noticeRepository,
    ) {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('partner')) {
            $partner = auth('partner')->user();
            if ($partner) {
                if ($this->noticeRepository->countUnreadByPartner($partner->mID) > 0 && request()->route()->getName() != 'partner.notice.index') {
                    request()->request->add(['swal_message' => '메시지를 바로 확인해 주세요.']);
                }
            }
        }

        return $next($request);
    }
}
