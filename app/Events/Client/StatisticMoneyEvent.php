<?php

namespace App\Events\Client;

use App\Events\BaseEvent;

class StatisticMoneyEvent extends BaseEvent
{
    protected string $eventAliasName = 'total-money-event';

    /**
     * Create a new event instance.
     */
    public function __construct(public $data)
    {
        $this->data = $data;
    }

    protected function getChannelName(): string {
        return 'money-channel';
    }

    public function broadcastWith(): array
    {
        return [
            'data' => $this->data,
        ];
    }
}
