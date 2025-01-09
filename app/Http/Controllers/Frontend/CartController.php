<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\UserCart;
use Auth;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class CartController extends BaseController
{

    public function index()
    {
        return view('frontend.cart.index');
    }
    public function addCart(Request $request)
    {   
        if (!Auth::check()) {
            throw ValidationException::withMessages(['Please login for adding products to the cart.']);
        }

        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'nullable', // Nullable for products without variants
            'quantity' => 'required|integer',
        ]);

        $productId = $validatedData['product_id'];
        $variantId = $validatedData['variant_id'] ?? null;
        $quantity = $validatedData['quantity'];

        // Fetch user type (e.g., 'user', 'ws', 'dr') or default to 'guest'
        $userType = auth()->check() ? auth()->user()->role : 'user';

        // Fetch the product and variant details
        $product = Product::findOrFail($productId);
        $variants = ProductVariant::where('product_id', $productId)
            ->where('status', 1)
            ->get();

        $variant = $variants->first(function ($variant) use ($variantId) {
            // Decode the JSON variation_ids field into an array
            $variantVariationIds = json_decode($variant->variation_ids, true);

            // Check if $variantIds matches $variantVariationIds irrespective of order
            return !array_diff($variantId, $variantVariationIds) && !array_diff($variantVariationIds, $variantId);
        });

        // Get image based on product or variant
        $image = $variantId
            ? ProductImage::where('product_id', $product->id)
                ->where('variant_id', $variant->id)
                ->orderBy('order', 'desc')
                ->first() ?? // Check if variant image exists; if not, fallback to product image
                ProductImage::where('product_id', $product->id)
                    ->orderBy('order', 'asc')
                    ->first()
            : ProductImage::where('product_id', $product->id)
                ->orderBy('order', 'asc')
                ->first();

        // Determine price based on user type and variant
        $price = $variant
            ? match ($userType) {
                'ws' => $variant->wholesale_price,
                'dr' => $variant->distributor_price,
                'user' => $variant->offer_price ?? $variant->sale_price,
                default => $variant->sale_price,
            }
            : match ($userType) {
                'ws' => $product->wholesale_price,
                'dr' => $product->distributor_price,
                'user' => $product->offer_price ?? $product->sale_price,
                default => $product->sale_price,
            };

        $salePrice = $variant ? $variant->sale_price : $product->sale_price;
        $offerPrice = $variant ? ($variant->offer_price ?? null) : ($product->offer_price ?? null);

        // Prepare the cart item
        $cartItemList = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $price,
            'qty' => $quantity,
            'weight' => $variant ? ($variant->weight ?? 0) : ($product->weight ?? 0),
            'options' => [
                'tax' => $product->gst,
                'image' => $image ? $image->image_path : null,
                'sale_price' => $salePrice,
                'offer_price' => $offerPrice,
                'variant_id' => $variant ? $variant->id : null,
                'variant_code' => $variant ? $variant->variation_code : null,
            ],
        ];

        Cart::add($cartItemList);

        if (auth()->check()) {
            // For logged-in users, fetch session cart items
            $sessionCartItems = Cart::content(); // Fetch all items in the session-based cart
            foreach ($sessionCartItems as $sessionCartItem) {
                UserCart::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'product_id' => $sessionCartItem->id,
                        'variant_id' => $sessionCartItem->options['variant_id'] ?? null,
                    ],
                    [
                        'quantity' => $sessionCartItem->qty,
                        'price' => $sessionCartItem->price,
                        'sale_price' => $sessionCartItem->options['sale_price'] ?? null,
                        'offer_price' => $sessionCartItem->options['offer_price'] ?? null,
                        'name' => $sessionCartItem->name,
                        'weight' => $sessionCartItem->weight ?? 0,
                        'tax' => $sessionCartItem->options['tax'] ?? 0,
                        'image' => $sessionCartItem->options['image'] ?? null,
                        'variant_code' => $sessionCartItem->options['variant_code'] ?? null,
                        'updated_at' => now(),
                    ]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully!',
            'cartCount' => $sessionCartItems->count(),
        ]);
    }

    public function updateCart(Request $request)
    {
        $validatedData = $request->validate([
            'row_id' => 'required|string',
            'product_id' => 'required|integer',
            'variant_id' => 'nullable|integer', // Nullable for products without variants
            'quantity' => 'required|integer|min:1',
        ]);

        $rowId = $validatedData['row_id'];
        $productId = $validatedData['product_id'];
        $variantId = $validatedData['variant_id'] ?? null;
        $quantity = $validatedData['quantity'];

        // Fetch user type
        $userType = auth()->check() ? auth()->user()->role : 'user';

        // Fetch product and variant details
        $product = Product::findOrFail($productId);
        $variant = $variantId ? ProductVariant::find($variantId) : null;

        $price = $variant
            ? match ($userType) {
                'ws' => $variant->wholesale_price,
                'dr' => $variant->distributor_price,
                'user' => $variant->offer_price ?? $variant->sale_price,
                default => $variant->sale_price,
            }
            : match ($userType) {
                'ws' => $product->wholesale_price,
                'dr' => $product->distributor_price,
                'user' => $product->offer_price ?? $product->sale_price,
                default => $product->sale_price,
            };

        $minQty = $userType === 'user' ? 1 : ($variant ? $variant->min_order_qty : $product->min_order_qty);
        $maxQty = $userType === 'user' ? ($variant ? $variant->qty : $product->qty) : PHP_INT_MAX;

        // Validate quantity limits
        if ($quantity < $minQty) {
            return response()->json(['success' => false, 'message' => "Minimum quantity is $minQty.", 'min_qty' => $minQty], 400);
        }
        if ($quantity > $maxQty) {
            return response()->json(['success' => false, 'message' => "Maximum quantity is $maxQty.", 'max_qty' => $maxQty], 400);
        }

        // Get image and other details
        $image = $variantId
            ? ProductImage::where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->orderBy('order', 'desc')
                ->first() ?? // Check if variant image exists; if not, fallback to product image
                ProductImage::where('product_id', $productId)
                    ->orderBy('order', 'asc')
                    ->first()
            : ProductImage::where('product_id', $productId)
                ->orderBy('order', 'asc')
                ->first();

        $variantCode = $variant ? $variant->variation_code : null;

        // Update the cart
        Cart::update($rowId, [
            'qty' => $quantity,
            'price' => $price,
            'weight' => $variant ? $variant->weight : $product->weight,
            'options' => [
                'image' => $image ? $image->image_path : null,
                'variant_id' => $variantId,
                'variant_code' => $variantCode,
                'tax' => $product->gst,
                'sale_price' => $variant ? $variant->sale_price : $product->sale_price,
                'offer_price' => $variant ? ($variant->offer_price ?? null) : ($product->offer_price ?? null),
            ]
        ]);

        // Update in the user carts as well
        if (auth()->check()) {
            UserCart::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->update([
                    'quantity' => $quantity,
                    'price' => $price,
                    'sale_price' => $variant ? $variant->sale_price : $product->sale_price,
                    'offer_price' => $variant ? ($variant->offer_price ?? null) : ($product->offer_price ?? null),
                    'weight' => $variant ? $variant->weight : $product->weight,
                    'tax' => $product->gst,
                    'image' => $image,
                    'variant_code' => $variantCode,
                ]);
        }

        $totalPrice = $price * $quantity;

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.',
            'price' => number_format($price, 2),
            'total_price' => number_format($totalPrice, 2),
        ]);
    }

    public function clearCart(Request $request)
    {
        try {
            // Clear the cart package session
            Cart::destroy();

            // If the user is logged in, clear their cart from the database
            if (auth()->check()) {
                UserCart::where('user_id', auth()->id())->delete();
            }

            return response()->json(['success' => true, 'message' => 'Cart cleared successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to clear the cart.']);
        }
    }

    public function removeItem(Request $request)
    {
        $validatedData = $request->validate([
            'row_id' => 'required|string',
        ]);

        try {
            // Fetch the cart item directly using the rowId
            $rowData = Cart::get($validatedData['row_id']);

            if ($rowData) {
                $productId = $rowData->id; // Access the 'id' field from the cart item
                $variantId = $rowData->options['variant_id'] ?? null;
                $userId = auth()->id();

                // Remove the item from the database if user is logged in
                UserCart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->where('variant_id', $variantId)
                    ->delete();

                // Remove item from the cart session
                Cart::remove($validatedData['row_id']);

                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart successfully.',
                    'cart_count' => Cart::count(),
                ], 200); // Status code 200 for success
            }

            // If rowData is null, item doesn't exist in the cart
            return response()->json([
                'success' => false,
                'message' => 'Item not found in the cart.',
            ], 404);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Cart remove error:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product. Please try again.',
            ], 500);
        }
    }

    public function checkStock(Request $request)
    {
        $validatedData = $request->validate([
            'cart_items' => 'required|array',
            'cart_items.*.row_id' => 'required|string',
            'cart_items.*.product_id' => 'required|integer',
            'cart_items.*.variant_id' => 'nullable|integer',
            'cart_items.*.quantity' => 'required|integer|min:1',
        ]);

        $responseItems = [];

        foreach ($validatedData['cart_items'] as $item) {
            $product = Product::find($item['product_id']);
            $variant = $item['variant_id'] ? ProductVariant::find($item['variant_id']) : null;

            $availableQty = $variant ? $variant->qty : $product->qty;

            $responseItems[] = [
                'row_id' => $item['row_id'],
                'requested_qty' => $item['quantity'],
                'available_qty' => $availableQty,
            ];
        }

        return response()->json([
            'success' => true,
            'items' => $responseItems,
        ]);
    }

    public function validateBeforeCheckout(Request $request)
    {
        $cartContent = Cart::content();
        $userType = auth()->check() ? auth()->user()->role : 'user'; // Get user type
        $errors = [];

        foreach ($cartContent as $item) {
            $product = Product::find($item->id);
            $variant = $item->options->variant_id ? ProductVariant::find($item->options->variant_id) : null;

            $availableQty = $variant ? $variant->qty : $product->qty;
            $minOrderQty = $variant ? $variant->min_order_qty : $product->min_order_qty;

            if ($userType === 'user') {
                // For "user" type, check available stock
                if ($availableQty <= 0) {
                    $errors[] = [
                        'row_id' => $item->rowId,
                        'message' => "Out of stock. Please remove this item.",
                    ];
                } elseif ($item->qty > $availableQty) {
                    $errors[] = [
                        'row_id' => $item->rowId,
                        'message' => "Only {$availableQty} are available. Please adjust your quantity.",
                    ];
                }
            } else {
                // For "ws" or "dr" types, check minimum order quantity
                if ($item->qty < $minOrderQty) {
                    $errors[] = [
                        'row_id' => $item->rowId,
                        'message' => "Minimum order quantity is {$minOrderQty}.",
                    ];
                }
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'All items are valid. Proceeding to checkout.',
        ]);
    }
}
