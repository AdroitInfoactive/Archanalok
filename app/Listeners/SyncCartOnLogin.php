<?php

namespace App\Listeners;

use App\Models\UserCart;
use Auth;
use Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncCartOnLogin
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
    public function handle(Login $event)
    {
        $userId = Auth::id();

        // Fetch existing database cart items for the user
        $dbCartItems = UserCart::where('user_id', $userId)->get();
        // Fetch session-based cart items
        $sessionCartItems = Cart::content();
        // Sync database cart items into the session
        foreach ($dbCartItems as $dbItem) {
            $existingSessionItem = $sessionCartItems->firstWhere('id', $dbItem->product_id);

            if ($existingSessionItem) {
                // Update the session cart item quantity
                Cart::update($existingSessionItem->rowId, [
                    'qty' => $existingSessionItem->qty + $dbItem->quantity,
                ]);
            } else {
                // Add the database item to the session cart
                Cart::add([
                    'id' => $dbItem->product_id,
                    'name' => $dbItem->name,
                    'price' => $dbItem->price,
                    'qty' => $dbItem->quantity,
                    'weight' => $dbItem->weight,
                    'tax' => $dbItem->tax,
                    'options' => [
                        'image' => $dbItem->image,
                        'variant_id' => $dbItem->variant_id,
                        'sale_price' => $dbItem->sale_price,
                        'offer_price' => $dbItem->offer_price,
                        'variant_code' => $dbItem->variant_code,
                    ],
                ]);
            }
        }

        // Sync session cart items into the database
        foreach ($sessionCartItems as $sessionItem) {
            UserCart::updateOrCreate(
                [
                    'user_id' => $userId,
                    'product_id' => $sessionItem->id,
                    'variant_id' => $sessionItem->options['variant_id'] ?? null,
                ],
                [
                    'quantity' => $sessionItem->qty,
                    'price' => $sessionItem->price,
                    'sale_price' => $sessionItem->options['sale_price'] ?? null,
                    'offer_price' => $sessionItem->options['offer_price'] ?? null,
                    'name' => $sessionItem->name,
                    'weight' => $sessionItem->weight ?? 0,
                    'tax' => $sessionItem->tax ?? 0,
                    'image' => $sessionItem->options['image'] ?? null,
                    'variant_code' => $sessionItem->options['variant_code'] ?? null,
                    'updated_at' => now(),
                ]
            );
        }
    }
}
