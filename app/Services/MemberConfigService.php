<?php

namespace App\Services;

use App\Models\BonusConfig;
use App\Models\MemberConfig;
use App\Repositories\MemberConfigRepository;
use App\Repositories\MemberRepository;
use App\Repositories\GameProviderRepository;

class MemberConfigService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private MemberConfigRepository $memberConfigRepository,
        private MemberRepository $memberRepository,
        private TransactionService $transactionService,
        private GameProviderRepository $gameProviderRepository
    ) {
    }

    public function updateByMember(string $field, string $mID)
    {
        $member = $this->memberRepository->getFirstWithConditions([['mID', $mID]]);
        // $this->memberConfigRepository->updateOrCreate(['mID' => $mID], [$field => !$field]);
        if (!empty($member->memberConfig)) {
            $member->memberConfig->{$field} = !$member->memberConfig->{$field};
            $member->memberConfig->save();
        } else {
            $this->memberConfigRepository->create([
                'mID' => $mID,
                $field => true
            ]);
        }
    }

    public function toggleGameProviderConfig(string $mID, string $gpType, string $gpCode)
    {
        $member_config = $this->memberConfigRepository->getFirstWithConditions([['mID', $mID]]);
        $g_provider = $this->gameProviderRepository->findByGpCode($gpCode);

        if (empty($g_provider)) return false;

        $config = $member_config->mcGameProvider;

        if (!$config) { // Init
            if ($g_provider->gpCategory === \App\Models\GameProvider::TYPE_SLOT_AND_CASINO) {
                $config = array_merge(
                    $this->initGameProviderMemberConfig('slot', $gpCode),
                    $this->initGameProviderMemberConfig('casino', $gpCode)
                );
            } elseif ($g_provider->gpCategory === \App\Models\GameProvider::TYPE_SLOT) {
                $config = $this->initGameProviderMemberConfig('slot', $gpCode);
            } elseif ($g_provider->gpCategory === \App\Models\GameProvider::TYPE_CASINO) {
                $config = $this->initGameProviderMemberConfig('casino', $gpCode);
            }
        } else {
            $config = $member_config->mcGameProvider;
        }
        $config[$gpType][$gpCode] = !$config[$gpType][$gpCode];
        $member_config->mcGameProvider = $config;
        return $member_config->save();
    }

    private function initGameProviderMemberConfig(string $gpType, string $gpCode): array
    {
        $categories = $this->gameProviderRepository->getCategories($gpType);
        $providers = $this->gameProviderRepository->getAllByCategories($categories, $gpCode); //getListWithConditions

        foreach ($providers as $provider) {
            $data[$gpType][$provider->gpCode] = true;
        }

        return $data;
    }

    public function getConfigGameProviderByMemberID(string $mID, string $gpType)
    {
        $config = $this->memberConfigRepository->getFirstWithConditions([['mID', $mID]]);
        return $config->mcGameProvider[$gpType] ?? [];
    }

    public function listGameProviderIsNotDisplayed(string $mID, array $categoryGame)
    {
        if (empty(array_diff_assoc(\App\Models\GameProvider::CATEGORY_SLOT, $categoryGame)) && empty(array_diff_assoc($categoryGame, \App\Models\GameProvider::CATEGORY_SLOT))) {
            $gpType = \App\Models\GameProvider::NAME_SLOT;
        } else {
            $gpType = \App\Models\GameProvider::NAME_CASINO;
        }

        $config = $this->getConfigGameProviderByMemberID($mID, $gpType);

        if (empty($config)) return [];

        $result = array_filter($config, function ($enable) {
            return $enable === false;
        });

        return array_keys($result);
    }

    public function getEventRestrictionsConfig(string $mID)
    {
        $config = $this->memberConfigRepository->getFirstWithConditions([['mID', $mID]]);

        if (!$config->mcEventRestrictions) return $this->initDataEventRestrictions($config);

        return $config->mcEventRestrictions;
    }

    private function initDataEventRestrictions(MemberConfig $config)
    {
        $data = [];

        foreach (BonusConfig::LIST_EVENT_RESTRICTIONS as $event_type => $event_name) {
            $data[$event_type] = true;
        }

        $config->mcEventRestrictions = $data;

        return $config->save() ? $config->mcEventRestrictions : [];
    }

    public function toggleEventRestrictionsItem(string $mID, string $field)
    {
        $mc = $this->memberConfigRepository->getFirstWithConditions([['mID', $mID]]);

        $config = $mc->mcEventRestrictions;
        $config[$field] = !$config[$field];

        $mc->mcEventRestrictions = $config;

        return $mc->save();
    }
}
