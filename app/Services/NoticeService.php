<?php

namespace App\Services;

use App\Repositories\NoticeRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\NoticeMemberRepository;

class NoticeService extends BaseService
{
    public function __construct(
        private NoticeRepository $noticeRepository,
        private NoticeMemberRepository $noticeMemberRepository,
        private PartnerRepository $partnerRepository
    ) {
    }

    public function paginateByType(string $type)
    {
        $parameters = ['where' => [['ntType', $type], ['ntStatus', 1]]];

        return $this->noticeRepository->paginate($parameters, [['ntNo', 'desc']]);
    }

    public function paginateByTypeAndPartner(string $type)
    {
        $parameters = [
            'where' => [
                ['ntType', $type],
                ['ntStatus', 1],
            ]
        ];

        return $this->noticeRepository->paginate($parameters, [['ntNo', 'desc']]);
    }

    public function store()
    {
        $data = $this->initData(request()->all());

        $notice = $this->noticeRepository->create($data);

        if ($notice->ntType == \App\Models\Notice::VOTE_TYPE) {
            $notice->config()->create($this->initNoticeConfig());
        }

        return $notice;
    }

    public function sendToMembers($noticeId)
    {
        $pType = request()->input('partner_type');

        $data = $this->initMembers($noticeId, $pType);

        return $this->noticeMemberRepository->insert($data);
    }

    public function find(int $id)
    {
        return $this->noticeRepository->getByPK($id);
    }

    public function update(int $id)
    {
        $data = $this->initData(request()->all());

        if (request()->input('partner_type')) {
            $notice = $this->noticeRepository->getByPK($id);
            if ($notice->ntPartnerType != request()->input('partner_type')) {
                $notice->notice_member()->delete();
                $this->sendToMembers($id);
            }
        }

        return $this->noticeRepository->updateByPK($id, $data);
    }

    public function inActive(int $id)
    {
        return $this->noticeRepository->updateByPK($id, ['ntStatus' => 0]);
    }

    public function initData(array $data)
    {
        return [
            'ntType' => $data['type'] ?? '',
            'ntTitle' => $data['title'] ?? '',
            'ntContent' => $data['content'] ?? '',
            'ntLogo' => $data['logo'] ?? null,
            'ntImage' => $data['image'] ?? null,
            'ntCategory' => $data['category'] ?? null,
            'ntPartnerType' => $data['partner_type'] ?? null,
        ];
    }

    public function initMembers(int $noticeId, string $partneType)
    {
        $partners = $this->partnerRepository->getPartnerByType($partneType);

        $data = $partners->map(function ($partner) use ($noticeId) {
            return [
                'ntNo' => $noticeId,
                'mID' => $partner->mID,
                'nmRegDate' => date('Y-m-d H:i:s'),
                'nmUpdateDate' => date('Y-m-d H:i:s'),
            ];
        })->toArray();

        return $data;
    }

    public function initNoticeConfig()
    {
        $data = request()->all();

        return [
            'ncAvailableOfComments' => $data['ncAvailableOfComments'] ?? [],
            'ncNumberOfPollItems' => $data['ncNumberOfPollItems'] ?? 0,
            'ncPollDurationHour' => $data['ncPollDurationHour'] ?? 0,
            'ncVotingMemberLevel' => $data['ncVotingMemberLevel'] ?? 0,
            'ncEnableMultipleSelection' => $data['ncEnableMultipleSelection'] ?? false,
            'ncEnablePollCancel' => $data['ncEnablePollCancel'] ?? false,
            'ncDivideByItem' => $data['ncDivideByItem'] ?? false,
            'ncItem1' => $data['ncItem1'] ?? '',
            'ncValue1' => $data['ncValue1'] ?? '',
            'ncItem2' => $data['ncItem2'] ?? '',
            'ncValue2' => $data['ncValue2'] ?? '',
            'ncItem3' => $data['ncItem3'] ?? '',
            'ncValue3' => $data['ncValue3'] ?? '',
            'ncItem4' => $data['ncItem4'] ?? '',
            'ncValue4' => $data['ncValue4'] ?? '',
            'ncItem5' => $data['ncItem5'] ?? '',
            'ncValue5' => $data['ncValue5'] ?? '',
        ];
    }
}
