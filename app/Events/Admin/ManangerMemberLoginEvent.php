<?php

namespace App\Events\Admin;

use App\Events\BaseEvent;
use App\Repositories\MembersLoginRepository;

class ManangerMemberLoginEvent extends BaseEvent
{
    protected string $eventAliasName = 'mananger-member-login-event';

    private $count_member_login = 0;
    /**
     * Create a new event instance.
     *
     * @param mixed $data ['key' => 'value']
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'count_member_login' => $this->count_member_login,
        ];
    }

    /**
     * Get channel name
     */
    protected function getChannelName(): string
    {
        return 'mananger-member-login-channel';
    }

    private function handle(): void {
        $now = now();
        $now_sub = $now->subHours(2)->format('Y-m-d H:m:s');
        $now_add = $now->addHours(3)->format('Y-m-d H:m:s');

        $memRepo = new MembersLoginRepository();
        $this->count_member_login = $memRepo->getCountMemberAccess([
            'updated_at',
            [
                $now_sub,
                $now_add,
            ],
        ]);
        
    }
}
