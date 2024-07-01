<?php

namespace App\Events\Client;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class DeletedNoteEvent implements ShouldBroadcastNow
{
    protected string $eventAliasName = 'admin-deleted-note';

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
        return ['deleted' => 1];
    }

    public function broadcastOn(): Channel
    {
        return new Channel('note-page');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return "{$this->eventAliasName}-{$this->type}";
    }
}
