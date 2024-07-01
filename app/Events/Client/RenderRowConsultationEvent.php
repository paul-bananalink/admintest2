<?php

namespace App\Events\Client;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RenderRowConsultationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tr;
    public $type;

    /**
     * handle add/sub money info
     */
    public function __construct($consultation, string $type)
    {
        $this->type = $type;
        $this->tr = view('Admin.Consultation.item_table_row', compact('consultation', 'type'))->render();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('count-notification-channel'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'add-row-consultation-event';
    }
}
