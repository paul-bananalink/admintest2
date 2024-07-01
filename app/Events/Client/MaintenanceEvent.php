<?php

namespace App\Events\Client;

use App\Events\BaseEvent;

class MaintenanceEvent extends BaseEvent
{
    protected string $eventAliasName = 'maintenance-event';

    /**
     * Create a new event instance.
     */
    public function __construct()
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
            'message' => __('login.maintenance'),
            'access_token' => null,
        ];
    }

    /**
     * Get channel name
     */
    protected function getChannelName(): string
    {
        return 'maintenance-channel';
    }
}
