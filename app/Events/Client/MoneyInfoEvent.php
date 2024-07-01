<?php

namespace App\Events\Client;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use \App\Models\MoneyInfo;

class MoneyInfoEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $tr;

    /**
     * handle add/sub money info
     */
    public function __construct($moneyInfo, string $miType)
    {

        if (!in_array($miType, [MoneyInfo::TYPE_UD, MoneyInfo::TYPE_UW])) {
            return;
        }

        $type = $miType == MoneyInfo::TYPE_UD ? MoneyInfo::RECHARGE : MoneyInfo::WITHDRAW;

        $this->type = $type;

        if ($moneyInfo->getType() == MoneyInfo::RECHARGE) {
            $view  = 'Admin.MoneyInfo.recharge_row';
        } else {
            $view  = 'Admin.MoneyInfo.withdraw_row';
        }

        $this->tr = view($view, compact('moneyInfo', 'type'))->with(['showActions' => true])->render();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('money-info-channel'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'money-info-event';
    }
}
