<?php

namespace App\Events\Client;

use App\Events\BaseEvent;

class CountNotificationEvent extends BaseEvent
{
    protected string $eventAliasName = 'count-notification-event';

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($key, $value = 1) {
        $this->data = ['key' => $key, 'value' => $value];
    }

    protected function getChannelName(): string {
        return 'count-notification-channel';
    }
}
