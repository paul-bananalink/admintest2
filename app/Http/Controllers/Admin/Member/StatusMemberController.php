<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateMemberRequest;
use App\Http\Requests\Admin\CreateOrUpdateMemberRequest;
use App\Http\Requests\Admin\UpdateMemberRequest;
use App\Models\MoneyInfo;
use App\Repositories\MoneyInfoRepository;
use App\Repositories\PointHistoryRepository;
use App\Repositories\TransactionRepository;
use App\Services\MemberConfigService;
use App\Services\MemberService;
use App\Services\RechargeConfigService;
use App\Services\StatusMemberService;

class StatusMemberController extends Controller
{
    public function __construct(
        private MemberConfigService $memberConfigService,
        private StatusMemberService $stMemService,
        private MemberService $memberService,
        private MoneyInfoRepository $moneyInfoRepository,
        private RechargeConfigService $rechargeConfigService,
        private TransactionRepository $transactionRepository,
        private PointHistoryRepository $pointHistoryRepository,
    ) {
    }

    public function index()
    {
        $data = $this->stMemService->getStatusMemberAccess(request()->all());

        return view('Admin.Member.index', $data);
    }

    public function resetPass(int $id)
    {
        $this->stMemService->resetPass($id);

        return redirect()->route('admin.status-members.index', request()->query());
    }

    public function statusMemberNormal(int $id)
    {
        $this->stMemService->statusMemberNormal($id);

        return redirect()->route('admin.status-members.index', request()->query());
    }

    public function statusMemberStop(int $id)
    {
        $this->stMemService->statusMemberStop($id);

        return redirect()->route('admin.status-members.index', request()->query());
    }

    public function updateStatusMember(int $id, string $type, bool $value)
    {
        $response = $this->stMemService->updateStatusMember($id, $type, $value);

        return response()->json(['data' => $response]);
    }

    public function deleteMember()
    {
        $this->stMemService->deleteMember(request('member_id'));

        return redirect()->route('admin.status-members.index', request()->query());
    }

    public function create()
    {
        return view('Admin.Member.create');
    }

    public function createMember(CreateMemberRequest $request)
    {
        try {
            $member = $this->stMemService->createMember($request->all());
            if ($member) {
                $data = view('Admin.Member.status_member_row', compact('member'))->with(['includeDetail' => true])->render();
            }

            return response()->json(['status' => (bool)$member, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function checkMemberId()
    {
        return response()->json(['is_check' => $this->stMemService->checkMemberId(request('mID', ''), request('mMemberId', ''))]);
    }

    public function checkPartnerCode()
    {
        return response()->json(['is_check' => $this->stMemService->checkPartnerCode(request('mID', ''), request('mPartnerCode', ''))]);
    }

    public function checkUniqueMemberId()
    {
        return response()->json([
            'is_check' => $this->stMemService->checkMemberId(request('mID', ''), '', true),
        ]);
    }

    public function checkMemberNick()
    {
        return response()->json([
            'is_check' => $this->stMemService->checkMemberNick(request('mNick', ''), true),
        ]);
    }

    public function updateToggleField(string $field, $mID)
    {
        if ($field === 'mIsPartner') {
            $data = $this->stMemService->updateIsPartnerByMember($mID);

            return response()->json([
                'success' => $data['status'],
                'message' => $data['message'],
                'is_partner' => $data['is_partner'],
                'mNo' => $data['mNo'],
            ]);
        } else {
            $isSuccess = $this->stMemService->updateByMember($field, $mID);

            return response()->json(['success' => $isSuccess]);
        }
    }

    public function update(int $id)
    {
        $member = $this->stMemService->getMemberById($id);

        return view('Admin.Member.update', ['member' => $member]);
    }

    public function updateMember(UpdateMemberRequest $request, int $id)
    {
        $this->stMemService->updateMember($id, $request->all());

        return redirect()->route('admin.status-members.update', ['id' => $id, ...request()->query()]);
    }

    public function info(int $id)
    {
        $member = $this->stMemService->getMemberById($id)->load(['members_login', 'memberConfig']);
        $mNick = $member->partner_parent ? $member->partner_parent->mNick : '';
        $member->partner_name = $member->partner ? $member->partner->pName : $mNick;
        return response()->json($member);
    }

    public function banByField(string $field, int $id)
    {
        $this->stMemService->banByField($field, $id);

        return response()->json(['success' => true]);
    }

    public function disableOrEnableGames(string $game, int $id)
    {
        $this->stMemService->banByField($game, $id);

        return response()->json(['success' => true]);
    }

    public function updateProviderList(string $provider, int $id)
    {
        $status = $this->stMemService->updateProviderList($provider, $id);

        return response()->json(['success' => $status]);
    }

    public function updateGameList(string $game, int $id)
    {
        $status = $this->stMemService->updateGameList($game, $id);

        return response()->json(['success' => $status]);
    }

    public function forceLogout($id)
    {
        try {
            $this->stMemService->forceLogout($id);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    // public function updateMemberConfig(UpdateMemberConfigRequest $req)
    // {
    //     try {
    //         $this->stMemService->updateMemberConfig($req->all());
    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false]);
    //     }
    // }

    public function resetPassword($id)
    {
        $status = $this->stMemService->resetPassword($id);

        return response()->json(['status' => $status]);
    }

    public function createOrUpdateMember(CreateOrUpdateMemberRequest $req)
    {
        $status = $this->stMemService->createOrUpdateMember($req->all());

        return response()->json(['status' => $status]);
    }

    public function detail(int $id)
    {
        $member = $this->stMemService->getMemberById($id);
        $recentRechargeHistory = $this->moneyInfoRepository->getRecentRechargeWithdrawHistory($member->mID, MoneyInfo::RECHARGE, 10);
        $recentWithdrawHistory = $this->moneyInfoRepository->getRecentRechargeWithdrawHistory($member->mID, MoneyInfo::WITHDRAW, 10);
        $recentTransactionHistory = $this->transactionRepository->getRecentTransactionHistory($member->mID, 10);
        $recentPointHistory = $this->pointHistoryRepository->getRecentPointHistory($member->mID, 10);
        $bankList = $this->rechargeConfigService->getBanks();
        $data = view('Admin.Member.status_member_detail', compact('member', 'recentRechargeHistory', 'recentWithdrawHistory', 'recentTransactionHistory', 'recentPointHistory', 'bankList'))->render();

        return response()->json(['data' => $data]);
    }

    public function getMemberRow(int $id)
    {
        $member = $this->stMemService->getMemberById($id);
        $data = view('Admin.Member.status_member_row', ['member' => $member, 'includeDetail' => false])->render();

        return response()->json(['data' => $data]);
    }

    public function actionButton(string $name)
    {
        $res = $this->stMemService->handleActionPageStatusMembers($name);

        if ($res) return redirect()->route('admin.status-members.index')->with('success', '업데이트 성공');

        return redirect()->route('admin.status-members.index')->with('error', '업데이트 실패');
    }
}
