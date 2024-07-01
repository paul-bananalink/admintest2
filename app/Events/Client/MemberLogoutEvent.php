<?php

namespace App\Events\Client;

use App\Events\BaseEvent;

class MemberLogoutEvent extends BaseEvent
{
    protected string $eventAliasName = 'member-logout-event';

    /**
     * Create a new event instance.
     *
     * @param  int  $id  mNo member sent trigger to user
     * @return void
     */
    public function __construct(private int $id)
    {
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'status' => true,
            'message' => __('auth.auto_logout_by_admin'),
            'access_token' => null,
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return "{$this->eventAliasName}-{$this->id}";
    }

    /**
     * Get channel name
     */
    protected function getChannelName(): string
    {
        return 'member-logout-channel';
    }
}
