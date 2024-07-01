<?php

namespace App\Services;

use App\Repositories\MembersLoginRepository;

class MembersLoginService extends BaseService
{
    private MembersLoginRepository $memloginRepo;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->memloginRepo = new MembersLoginRepository();
    }

    /**
     * Create or update by primary key of table members_login
     */
    public function createOrUpdateByPK(?string $id = null, array $data = []): void
    {
        if (empty($id)) {
            return;
        }
        $this->tryCatchFuncDB(function () use ($id, $data) {
            $mem_login = $this->memloginRepo->updateOrCreate([
                'mID' => $id,
            ], $data);
            if ($mem_login) {
                $mem_login->member->update([
                    'mLoginDateTime' => $mem_login->updated_at,
                    'mLoginIP' => $mem_login->mlIpv4,
                ]);
            }
        });
    }
}
