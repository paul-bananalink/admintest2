<?php

namespace App\Services\GraphQL;

use App\Models\Member;
use App\Repositories\MemberRepository;
use App\Repositories\SiteInfoRepository;

class SiteInfoService
{
    public function __construct(
        private SiteInfoRepository $siteInfoRepository,
        private MemberRepository $memberRepository
    ) {
    }

    public function getSiteInfo($member): array
    {
        $adminMember = $this->getAdminMember($member->mMemberID ?? null);
        $isADValid = ! empty($adminMember) && in_array($adminMember->mLevel, Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE);

        $siteInfo = [];
        if ($isADValid) {
            $siteInfo = $adminMember->site_info->toArray();
        }

        return $siteInfo;
    }

    private function getAdminMember($mMemberID)
    {
        return $this->memberRepository->getFirstWithConditions([['mNo', $mMemberID]]);
    }
}
