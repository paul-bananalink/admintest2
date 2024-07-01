<?php

namespace App\Services;

use App\Events\Client\MaintenanceEvent;
use App\Repositories\MemberDisallowIpRepository;
use App\Repositories\MemberLoginFailedRepository;
use App\Repositories\MembersLoginRepository;
use App\Repositories\RechargeConfigRepository;
use App\Repositories\SiteInfoRepository;

class SiteInfoService extends BaseService
{
    const COUNT_TRIM_SITE_INFO_BANK = 3;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    private $member;

    private SiteInfoRepository $siteInfoRepository;
    private MemberDisallowIpRepository $memberDisallowIpRepository;
    private MembersLoginRepository $memLoginRepo;

    private MemberLoginFailedRepository $memberLoginFailedRepository;
    public function __construct()
    {
        $this->member = auth('admin')->user();
        $this->siteInfoRepository = new SiteInfoRepository;
        $this->memberLoginFailedRepository = new MemberLoginFailedRepository;
        $this->memberDisallowIpRepository = new MemberDisallowIpRepository;
        $this->memLoginRepo = new MembersLoginRepository;
    }

    public function changeCategory(string $category = ''): bool
    {
        if (empty($category)) {
            return false;
        }

        $site = app('site_info');
        if (empty($site)) {
            return false;
        }

        $data = [];
        if ($category == \App\Models\GameProvider::NAME_CASINO) {
            $data['siIsGameProviderCasino'] = !data_get($site, 'siIsGameProviderCasino', true);
        } elseif ($category == \App\Models\GameProvider::NAME_SLOT) {
            $data['siIsGameProviderSlot'] = !data_get($site, 'siIsGameProviderSlot', true);
        }

        return $this->tryCatchFuncDB(function () use ($site, $data) {
            $this->siteInfoRepository->updateByPK($site, $data);
        });
    }
    public function update(array $attributes = [])
    {
        return $this->tryCatchFuncDB(fn () => $this->siteInfoRepository->updateByPK(app('site_info'), $attributes));
    }

    /**
     * Get Site info sent to client
     *
     * @return mixed|null
     */
    public function getSiteConfig(): mixed
    {
        return $this->siteInfoRepository->getByPK(env('PAGE_ADMIN_ID', 1)) ?? null;
    }

    /**
     * Get site info by current user login
     */
    public function getSiteInfo(): array
    {
        $site_info = [];
        $member_login_failed = null;
        if ($page_id = env('PAGE_ADMIN_ID')) {
            $site_info = $this->siteInfoRepository->getByPK($page_id);
            $member_login_failed = $this->memberLoginFailedRepository->getModel();
        }
        return [
            'site_info' => $site_info,
            'member_login_failed' => $member_login_failed,
        ];
    }

    /**
     * paginate disallow ips
     */
    public function paginateDisAllowIps(): mixed
    {
        $per_page = request('per_page', self::COUNT_PER_PAGE);
        $mdiIps = $this->memberDisallowIpRepository->getPaginate($per_page);

        return $mdiIps;
    }

    public function getDisAllowIps(): mixed
    {
        return $this->siteInfoRepository->get();
    }

    /**
     * Handle initialize or update for form page setting
     *
     * @param  array  $attributes  from request validated
     */
    public function createPageSetting(array $attributes = []): bool
    {
        $dataBank = data_get($attributes, 'siBankBankAccountOwner', STR_EMPTY);
        if ($dataBank != '') {
            $siBank = $this->trimSiBankBankAccountOwner($dataBank);
            $attributes['siBank'] = data_get($siBank, 'siBank');
            $attributes['siBankAccount'] = data_get($siBank, 'siBankAccount');
            $attributes['siOwner'] = data_get($siBank, 'siOwner');
        }

        $blackList = data_get($attributes, 'siBlackList', STR_EMPTY);
        if ($blackList != '') {
            $attributes['siBlackList'] = array_unique(explode("\r\n", $blackList));
        }

        return $this->tryCatchFuncDB(fn () => $this->siteInfoRepository->updateByPK(app('site_info'), $attributes));
    }

    /**
     * Handle initialize or update for form recharge setting
     *
     * @param  array  $attributes  from request validated
     */
    public function createRechargeSetting(array $attributes = []): void
    {
        $data_site_info = $this->initDataSiteInfoRecharge($attributes);
        $this->tryCatchFuncDB(fn () => $this->handlePageSetting($data_site_info));
    }

    /**
     * Handle IP member disallow ip
     *
     * @param  array  $attributes  from request validated
     */
    public function blockIpSetting(array $attributes = []): void
    {
        $data_block_ip = $this->initDataBlockIp($attributes);
        $this->tryCatchFuncDB(fn () => $this->handleBlockIpSetting($data_block_ip));
    }

    /**
     * Handle delete IP member
     *
     * @param  array  $attributes  from request
     */
    public function blockIpDelete(array $attributes): void
    {
        $this->tryCatchFuncDB(function () use ($attributes) {
            $this->memberDisallowIpRepository->deleteByPK(data_get($attributes, 'mdiiNo'));
        });
    }

    public function toggleField(string $field = ''): bool
    {
        try {
            if (empty($field)) {
                return false;
            }

            $site = app('site_info');
            if (empty($site)) {
                return false;
            }

            $site->{$field} = !$site->{$field};
            $site->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    //--------------------------------PRIVATE FUNCTION--------------------------------

    /**
     * Handle add ip to table member_disallow_ip
     */
    private function handleBlockIpSetting(array $attributes = []): void
    {
        $this->memberDisallowIpRepository->create([
            'mID' => $this->member->mID ?? null,
            'mdiIp' => data_get($attributes, 'mdiIp'),
            'mdiRegDate' => now(),
        ]);
    }

    /**
     * Handle initialize for block ip setting
     *
     * @param  array  $attributes  from request validated
     */
    private function initDataBlockIp(array $attributes = []): array
    {
        return [
            'mdiIp' => data_get($attributes, 'mdiIp'),
        ];
    }

    /**
     * Handle initialize or update for page setting
     *
     * @param  array  $attributes  from request validated
     */
    private function handlePageSetting(array $data_site_info = []): bool
    {
        $page_id = env('PAGE_ADMIN_ID');
        if (!$page_id) {
            return false;
        }
        $is_exec = $this->tryCatchFuncDB(fn () => $this->siteInfoRepository->updateOrCreate([
            'siNo' => $page_id,
        ], $data_site_info));

        if ($is_exec && data_get($data_site_info, 'siOpenType', false)) {
            $this->runEvent(new MaintenanceEvent());
            $members_login = $this->memLoginRepo->getMemberAccessAll();
            $this->tryCatchFuncDB(function () use ($members_login) {
                $this->memLoginRepo->deleteMultiple($members_login->pluck('mlNo')->toArray());
                foreach ($members_login as $member_login) {
                    $member_login->member->tokens()->delete();
                }
            });
        }

        return $is_exec;
    }

    /**
     * Initialize for data site info
     *
     * @param  array  $attributes  from request validated
     */
    private function initDataSiteInfoRecharge(array $attributes = []): array
    {
        return [
            'siOptionMinDeposit' => data_get($attributes, 'siOptionMinDeposit'),
            'siOptionMinWithraw' => data_get($attributes, 'siOptionMinWithraw'),
            'siOptionDepositText' => data_get($attributes, 'siOptionDepositText'),
            'siOptionWithrawText' => data_get($attributes, 'siOptionWithrawText'),
        ];
    }

    /**
     * Initialize for data site info
     *
     * @param  array  $attributes  from request validated
     */
    private function initDataSiteInfo(array $attributes = []): array
    {
        $dataBank = $this->trimSiBankBankAccountOwner(data_get($attributes, 'siBankBankAccountOwner', STR_EMPTY));

        $black_list = explode("\r\n", $attributes['siBlackList'] ?? '');
        $black_list = array_unique($black_list);

        return [
            'siOpenUserJoin' => (bool) data_get($attributes, 'siOpenUserJoin', false),
            'siOpenType' => (bool) data_get($attributes, 'siOpenType', false),
            'siTimeOUt' => data_get($attributes, 'siTimeOUt', 120),
            'siTel' => data_get($attributes, 'siTel'),
            'siName' => data_get($attributes, 'siName'),
            'siEmail' => data_get($attributes, 'siEmail'),
            'siBank' => data_get($dataBank, 'siBank'),
            'siBankAccount' => data_get($dataBank, 'siBankAccount'),
            'siOwner' => data_get($dataBank, 'siOwner'),
            'siDescription' => data_get($attributes, 'siDescription'),
            'siKeywords' => data_get($attributes, 'siKeywords'),
            'siMaxHoursHistories' => data_get($attributes, 'siMaxHoursHistories'),
            'siSMSPhone' => data_get($attributes, 'siSMSPhone'),
            'siSMSApiKey' => data_get($attributes, 'siSMSApiKey'),
            'siSMSId' => data_get($attributes, 'siSMSId'),
            'siConsultationContents' => data_get($attributes, 'siConsultationContents'),
            'siMemberFirstTimeLoginContents' => data_get($attributes, 'siMemberFirstTimeLoginContents'),
            'siSMSContents' => data_get($attributes, 'siSMSContents'),
            'siMemberNoteContents' => data_get($attributes, 'siMemberNoteContents'),
            'siWarningMaxBetValues' => data_get($attributes, 'siWarningMaxBetValues'),
            'siPartners' => data_get($attributes, 'siPartners'),
            'siBlackList' => $black_list,
        ];
    }

    /**
     * Handle string splitting to array
     *
     * @return array max length = 3
     */
    private function trimSiBankBankAccountOwner(?string $str = ''): array
    {
        if (empty($str)) {
            return [];
        }

        //String splitting to sibank, siBankAccount, siOwner
        $dataBank = explode('/', $str);
        if (count($dataBank) != self::COUNT_TRIM_SITE_INFO_BANK) {
            return [];
        }

        return [
            'siBank' => $dataBank[0],
            'siBankAccount' => $dataBank[1],
            'siOwner' => $dataBank[2],
        ];
    }
}
