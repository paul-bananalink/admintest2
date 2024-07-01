<?php

namespace App\Repositories;

use App\Models\MemberConfig;
use Exception;

class MemberConfigRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return MemberConfig::class;
    }

    public function disableEventRestrictionByKey(string $mID, string $key): bool
    {
        $mc = $this->getFirstWithConditions([['mID', $mID]]);

        if (!$mc) return false;

        if (empty($mc->mcEventRestrictions)) return false;

        return !$mc->mcEventRestrictions[$key];
    }
}
