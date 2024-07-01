<?php

namespace App\Events\Client;

use App\Events\BaseEvent;

class CountNoteNoReadEvent extends BaseEvent
{
    protected string $eventAliasName = 'send-note';

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $type,
    ) {
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return ['count' => 1];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return "{$this->eventAliasName}-{$this->type}";
    }

    protected function getChannelName(): string
    {
        return 'note-page';
    }
}
