<?php

namespace App\Events\Client;

use App\Events\BaseEvent;

class StatusMemberEvent extends BaseEvent
{
    protected string $eventAliasName = 'status-member-event';

    private $type;
    private $tr;

    /**
     * Create a new event instance.
     */
    public function __construct($member)
    {
        $this->handleEvent($member);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'type' => $this->type,
            'tr' => $this->tr,
        ];
    }

    protected function getChannelName(): string {
        return 'status-member-channel';
    }

    private function handleEvent(mixed $member = null): void
    {
        $this->type = 'RegMember';
        $this->tr = view('Admin.Member.status_member_row', ['member' => $member, 'includeDetail' => true])->render();
    }
}
