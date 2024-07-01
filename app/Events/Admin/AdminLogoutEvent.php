<?php

namespace App\Events\Admin;

use App\Events\BaseEvent;

class AdminLogoutEvent extends BaseEvent
{
    protected string $eventAliasName = 'admin-logout-event';

    /**
     * Create a new event instance.
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
        return 'admin-logout-channel';
    }
}
