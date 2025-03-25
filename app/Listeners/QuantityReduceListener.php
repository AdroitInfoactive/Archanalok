<?php

namespace App\Listeners;

use App\Events\QuantityReduceEvent;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QuantityReduceListener
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
    public function handle(QuantityReduceEvent $event): void
    {
        $orderId = $event->orderId;
        $order = Order::with('orderItems')->find($orderId);

        foreach ($order->orderItems as $orderItem) {
            $productId = $orderItem->product_id;
            if($orderItem->variant_id){
                $variantId = $orderItem->variant_id;
                // reduce quantity of variant
                $variant = ProductVariant::find($variantId);
                $variant->qty = $variant->qty - $orderItem->quantity;
                $variant->save();
            }
            else {
                // reduce quantity of product
                $product = Product::find($productId);
                $product->qty = $product->qty - $orderItem->quantity;
                $product->save();
            }
        }
    }
}
