<?php

namespace App\Listeners;

use App\Events\OrderNotificationEvent;
use App\Mail\OrderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Mail;

class OrderNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderNotificationEvent $event): void
    {
        // Log::info("✅ OrderNotificationListener executed for Order ID: " . $event->orderId);
        $orderId = $event->orderId;
        $order = Order::with('user')->find($orderId);
        Mail::send(new OrderMail($order));
    }
}
