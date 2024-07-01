<?php

namespace App\Services;

use App\Repositories\MemberAllowIpRepository;
use App\Repositories\MemberRepository;

class ManagerAdminService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private MemberRepository $memberRepository,
        private MemberAllowIpRepository $memberAllowIpRepository,
    ) {
    }

    /**
     * Get data for page manager admin setting
     *
     * @param  array  $attributes  from request validated
     */
    public function getDataForPageManager(array $attributes = []): array
    {
        $members = $this->memberRepository->getListAdmin();
        $current_page = data_get($attributes, 'admin_page', 1);
        $members = $this->arrayToPagination($members->all(), $current_page, 'admin_page');

        $mAIps = [];
        if ($m_id = request('open_allow_ip')) {
            $mAIps = $this->memberAllowIpRepository->getMemberAllowIP(['mID' => $m_id]);
            $current_page_ip = data_get($attributes, 'admin_ip_page', 1);
            $mAIps = $this->arrayToPagination($mAIps->all(), $current_page_ip, 'admin_ip_page');
        }

        return [
            'members' => $members,

            'mAIps' => $mAIps,
        ];
    }

    /**
     * Create Admin to DB
     */
    public function newAdmin(array $attributes = []): bool
    {
        $data = $this->initDataCreateAdmin($attributes);

        return $this->tryCatchFuncDB(function () use ($data) {
            $this->memberRepository->create($data);
        });
    }

    /**
     * Update member with role Admin
     *
     * @param  array  $attributes  from request validated
     */
    public function updateAdmin(array $attributes = []): bool
    {
        $data = $this->initDataUpdateAdmin($attributes);

        return $this->tryCatchFuncDB(function () use ($data) {
            $this->memberRepository->updateByPK(
                (int) data_get($data, 'mNo'),
                ['mPW' => data_get($data, 'mPW')]
            );
        });
    }

    /**
     * Change status by primary key of table member
     */
    public function changeStatusAdmin(int $id, bool $is): bool
    {
        return $this->tryCatchFuncDB(function () use ($id, $is) {
            $this->memberRepository->updateByPK($id, [
                'mStatus' => $is ? \App\Models\Member::M_STATUS_NINE : \App\Models\Member::M_STATUS_EIGHT,
            ]);
        });
    }

    /**
     * Create member allow ip to table member_allow_ip
     *
     * @param  array  $attributes  from request validated
     */
    public function createMemberAllowIp(string $m_id = '', array $attributes = []): bool
    {
        if (empty($m_id)) {
            return false;
        }
        $data = $this->initDataCreateMemberAllowIp($attributes);
        $data['mID'] = $m_id;

        return $this->tryCatchFuncDB(function () use ($data) {
            $this->memberAllowIpRepository->create($data);
        });
    }

    /**
     * Delete member allow ip to table member_allow_ip
     *
     * @param  array  $attributes  from request validated
     */
    public function deleteMemberAllowIp(array $attributes = []): bool
    {
        return $this->tryCatchFuncDB(function () use ($attributes) {
            $this->memberAllowIpRepository->deleteByPK(data_get($attributes, 'maiNo'));
        });
    }

    /**
     * -----------------------PRIVATE FUNCTION-----------------------
     */

    /**
     * Initialize from data create member_allow_ip
     *
     * @param  array  $attributes  from request validated
     */
    private function initDataCreateMemberAllowIp(array $attributes = []): array
    {
        return [
            'maiIp' => data_get($attributes, 'mAIp'),
            'maiRegDate' => now(),
        ];
    }

    /**
     * Initialize from data create admin
     *
     * @param  array  $attributes  from request validated
     */
    private function initDataCreateAdmin(array $attributes = []): array
    {
        return [
            'mID' => data_get($attributes, 'mID'),
            'mNick' => data_get($attributes, 'mNick'),
            'mPW' => data_get($attributes, 'mPW'),
            'mLevel' => data_get($attributes, 'mLevel'),
            'mStatus' => \App\Models\Member::M_STATUS_NINE,
            'mRegDate' => now(),
        ];
    }

    /**
     * Initialize from data update admin
     *
     * @param  array  $attributes  from request validated
     */
    private function initDataUpdateAdmin(array $attributes = []): array
    {
        return [
            'mNo' => data_get($attributes, 'mNo'),
            'mPW' => data_get($attributes, 'mPW'),
        ];
    }
}
