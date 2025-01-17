<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserCart;
use Cart;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    public function index()
    {
        if (Cart::count() == 0) {
            return redirect()->route('cart.index');
        }
        $addresses  = Address::where('user_id', auth()->user()->id)->get();
        return view('frontend.checkout.index', compact('addresses'));
    }

    public function processCheckout()
    {
        if (Cart::count() > 0) {
            $cartContent = Cart::content();
            $userId = auth()->check() ? auth()->user()->id : null;
            $userType = auth()->check() ? auth()->user()->role : 'user';

            // Fetch billing and shipping addresses
            $billingAddress = Address::where('user_id', $userId)
                ->where('is_default_billing', 1)
                ->first();

            $shippingAddress = Address::where('user_id', $userId)
                ->where('is_default_shipping', 1)
                ->first();

            if (!$billingAddress || !$shippingAddress) {
                return response()->json(['success' => false, 'message' => 'Billing or Shipping address not found!'], 400);
            }

            $billingAddressJson = $billingAddress ? $billingAddress->toJson() : json_encode([]);
            $shippingAddressJson = $shippingAddress ? $shippingAddress->toJson() : json_encode([]);

            if ($userType === 'user') {
            // generate random temp_invoice id using alphabets and numbers
            $invoiceNumber = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
            } else {
                $invoiceNumber = $this->generateInvoiceNumber();
            }

            // Create Order
            $order = new Order();
            if ($userType === 'user') {
                $order->temp_invoice_id = $invoiceNumber;
            }
            else
            {
                $order->invoice_number = $invoiceNumber['invoice_number'];
                $order->financial_year = $invoiceNumber['financial_year'];
            }
            $order->user_id = $userId;
            $order->billing_address_id = $billingAddress->id;
            $order->shipping_address_id = $shippingAddress->id;
            $order->billing_address = $billingAddressJson;
            $order->shipping_address = $shippingAddressJson;
            $order->email = $billingAddress->email;
            $order->phone = $billingAddress->phone;
            $order->subtotal = Cart::subtotal();
            $order->grand_total = Cart::subtotal();
            $order->quantity = Cart::count();

            if ($userType === 'user') {
                $order->payment_method = 'Online';
                $order->payment_type = 'Pay U Money';
                $order->order_status = 'Pending';
            } else {
                $order->payment_method = 'Offline';
                $order->payment_type = null;
                $order->order_status = 'Placed';
            }

            $order->payment_status = 0;
            $order->transaction_id = null;
            $order->save();

            // Insert Order Items
            if ($order) {
                foreach ($cartContent as $item) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item->id;
                    $orderItem->product_name = $item->name;
                    
                    if (isset($item->options['variant_id'])) {
                        $orderItem->variant_id = $item->options['variant_id'] ?? null;
                        $orderItem->variant_name = $item->options['variant_code'] ?? null;
                    }

                    $orderItem->quantity = $item->qty;
                    $orderItem->sale_price = $item->options['sale_price'] ?? 0;
                    $orderItem->offer_price = $item->options['offer_price'] ?? 0;
                    $orderItem->tax = $item->options['tax'] ?? 0;
                    $orderItem->total = $item->qty * $item->price;
                    $orderItem->save();
                }
                Cart::destroy();
                // delete items from the user_carts table
                UserCart::where('user_id', $userId)->delete();
            }

            return response()->json([
                'success' => true,
                'message' => $userType === 'user' ? 'Redirecting to payment gateway...' : 'Order placed successfully!',
                'redirect_url' => $userType === 'user'
                    ? route('payment.gateway', ['order_id' => $order->id])
                    : route('order.success', ['order_id' => $order->id])
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Cart is empty!'], 400);
    }

    private function generateInvoiceNumber()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        if ($currentMonth < 4) {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }
        $financialYear = substr($startYear, 2) ."-". substr($endYear, 2);
        $lastInvoice = Order::where('financial_year', $financialYear)
                            ->latest('id')
                            ->first();
        $lastCount = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -3)) : 0;
        $newCount = $lastCount + 1;
        return [
            'financial_year' => $financialYear,
            'invoice_number' => $newCount
        ];
    }

    public function orderSuccess($order_id)
    {
        $order = Order::findOrFail($order_id);

        // Ensure user owns order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('order.success', compact('order'));
    }

    public function showPaymentGateway($order_id)
    {
        $order = Order::findOrFail($order_id);

        // Ensure the user owns the order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('payment.gateway', compact('order'));
    }
}
