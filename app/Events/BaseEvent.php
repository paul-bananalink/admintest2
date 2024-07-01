<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class BaseEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected string $eventAliasName = 'default';

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel($this->getChannelName());
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return $this->eventAliasName;
    }

    /**
     * Get channel name
     */
    abstract protected function getChannelName(): string;
}
