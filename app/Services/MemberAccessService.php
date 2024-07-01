<?php

namespace App\Services;

use App\Events\Client\MemberLogoutEvent;
use App\Repositories\MemberRepository;
use App\Repositories\MembersLoginRepository;

class MemberAccessService extends BaseService
{
    private MembersLoginRepository $memLoginRepo;

    private MemberRepository $memRepo;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->memLoginRepo = new MembersLoginRepository();
        $this->memRepo = new MemberRepository();
    }

    /**
     * Get member access login
     *
     * @param  array  $attributes  from request validated
     */
    public function getInfoMemberAccess(array $attributes = []): array
    {
        $members_login = $this->handleSearch($attributes);

        return [
            'members_login' => $members_login,
        ];
    }

    /**
     * Handle member logout
     *
     * @param  int  $id  primary key of table member
     * @param  bool  $on_event  on/off is trigger event of pusher to client
     */
    public function memberLogout(?int $id = null, bool $on_event = false): bool
    {
        if (empty($id)) {
            return false;
        }

        $mem = $this->memRepo->getByPK($id);
        if (empty($mem)) {
            return false;
        }

        return $this->tryCatchFuncDB(function () use ($mem, $id, $on_event) {
            $mem->tokens()->delete();
            $mem->members_login()->delete();
            if ($on_event) {
                $this->runEvent(new MemberLogoutEvent($id));
            }
        });
    }

    /**
     * Initalize conditions when select record
     */
    public function initDataForMemberAccessLogin(): array
    {
        $now = now();
        $now_sub = $now->subHours(2)->format('Y-m-d H:m:s');
        $now_add = $now->addHours(3)->format('Y-m-d H:m:s');

        return [
            $this->memLoginRepo::OPERATOR_WHERE_BETWEEN => [
                'updated_at', [$now_sub, $now_add],
            ],
        ];
    }

    /**
     * -------------------------PRIVATE FUNCTION-------------------------
     */

    /**
     * Handle search member access login
     *
     * @param  array  $attributes  from request validated
     * @return Illuminate\Pagination\LengthAwarePaginator|array
     */
    private function handleSearch(array $attributes = [])
    {
        $conditions = $this->initDataForMemberAccessLogin();
        $key = data_get($attributes, 'search');
        if (empty($key)) {
            return $this->memLoginRepo->getPaginate(self::COUNT_PER_PAGE, $conditions);
        }
        $field = data_get($attributes, 'select_field_search', config('constant_view.VIEW.SELECT_ALL_FIELD'));
        return $this->memLoginRepo->getMemberAccessQuerySearch($key, $this->convertToFieldDB($field));
    }

    private function convertToFieldDB(string $field = ''): string
    {
        if ($field == config('constant_view.VIEW.SELECT_ALL_FIELD')) {
            return $field;
        } elseif ($field == 'member_id') {
            return 'mID';
        } elseif ($field == 'ip') {
            return 'mlIpv4';
        } elseif ($field == 'member_header_access') {
            return 'mlBrowserSystem';
        } elseif ($field == 'login_date') {
            return 'updated_at';
        }
        return 'mID';
    }
}
