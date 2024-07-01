<?php

namespace App\Observers;

use App\Models\Member;

class MemberObserver
{
    /**
     * Handle the Member "created" event.
     */
    public function created(Member $member): void
    {
        $member->memberConfig()->create();
    }

    /**
     * Handle the Member "updated" event.
     */
    public function updated(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "deleted" event.
     */
    public function deleted(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "restored" event.
     */
    public function restored(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "force deleted" event.
     */
    public function forceDeleted(Member $member): void
    {
        //
    }
}
