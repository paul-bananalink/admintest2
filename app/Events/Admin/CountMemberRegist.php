<?php

namespace App\Events\Admin;

use App\Events\BaseEvent;
use App\Repositories\MemberRepository;

class CountMemberRegist extends BaseEvent
{
    protected string $eventAliasName = 'mananger-member-regist-event';

    private $count_member_register_today = 0;
    private $count_member_register_yesterday = 0;
    private $count_member_suspended_today = 0;
    private $count_member_suspended_yesterday = 0;
    /**
     * Create a new event instance.
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
            'count_member_register_today' => $this->count_member_register_today,
            'count_member_register_yesterday' => $this->count_member_register_yesterday,
            'count_member_register' => $this->count_member_register_today - $this->count_member_register_yesterday,
            'count_member_suspended_today' => $this->count_member_suspended_today,
            'count_member_suspended' => $this->count_member_suspended_today - $this->count_member_suspended_yesterday,

        ];
    }

    /**
     * Get channel name
     */
    protected function getChannelName(): string
    {
        return 'mananger-member-regist-channel';
    }

    private function handle(): void
    {
        $memRepo = new MemberRepository();
        $today = now()->today();
        $yesterday = now()->subDays(1);

        //금일 신규가입 유저수 (차단)
        $this->count_member_register_today = $memRepo->getCountMemberRegisterByDate($today);
        $this->count_member_register_yesterday = $memRepo->getCountMemberRegisterByDate($yesterday);
        $this->count_member_suspended_today = $memRepo->getCountMemberSuspendedByDate($today);
        $this->count_member_suspended_yesterday = $memRepo->getCountMemberSuspendedByDate($yesterday);
    }
}
