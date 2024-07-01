<?php

namespace App\Events\Client;

use App\Events\BaseEvent;

class ReplyConsultationEvent extends BaseEvent
{
    protected string $eventAliasName = 'reply-member-consultation';

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
