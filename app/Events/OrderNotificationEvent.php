<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $orderId;

    /**
     * Create a new event instance.
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
        // Log::info("🚀 OrderNotificationEvent dispatched for Order ID: " . $orderId);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
