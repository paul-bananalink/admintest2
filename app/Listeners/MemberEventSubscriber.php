<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MemberEventSubscriber
{
    public function onMemberLogin($event)
    {
    }

    public function onMemberLogout($event)
    {
        // Xử lý sự kiện logout
    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Client\MemberLoggedIn',
            'App\Listeners\MemberEventSubscriber@onMemberLogin'
        );

        $events->listen(
            'App\Events\Client\MemberLoggedOut',
            'App\Listeners\MemberEventSubscriber@onMemberLogout'
        );
    }
}
