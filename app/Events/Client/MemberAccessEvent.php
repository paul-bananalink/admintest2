<?php

namespace App\Events\Client;

use App\Events\BaseEvent;
use App\Services\MembersLoginService;

class MemberAccessEvent extends BaseEvent
{
    protected string $eventAliasName = 'member-access-event';

    private MembersLoginService $memsloginService;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $id,
        public array $data,
    ) {
        $this->memsloginService = new MembersLoginService();
        $this->handleEvent();
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [];
    }

    protected function getChannelName(): string
    {
        return 'member-access-page';
    }

    private function handleEvent(): void
    {
        $this->memsloginService->createOrUpdateByPK($this->id, [
            'mlIpv4' => data_get($this->data, 'ip'),
            'mlBrowserSystem' => data_get($this->data, 'member_header_access'),
            'updated_at' => data_get($this->data, 'login_date'),
        ]);
    }
}
