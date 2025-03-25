<?php

namespace App\Http\Controllers\Frontend;

use App\Events\OrderNotificationEvent;
use App\Events\QuantityReduceEvent;
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
        $addresses = Address::where('user_id', auth()->user()->id)->get();
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
            } else {
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
            $order->subtotal = floatval(str_replace(',', '', Cart::subtotal()));
            $order->grand_total = floatval(str_replace(',', '', Cart::subtotal()));
            $order->quantity = Cart::count();

            if ($userType === 'user') {
                $order->payment_method = 'Online';
                $order->payment_type = 'ICICI';
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
                UserCart::where('user_id', $userId)->delete();
            }

            if ($userType !== 'user') {
                OrderNotificationEvent::dispatch($order->id);
            }

            return response()->json([
                'success' => true,
                'message' => $userType === 'user' ? 'Redirecting to payment gateway...' : 'Order placed successfully!',
                'redirect_url' => $userType === 'user'
                    ? route('payment.icici_gateway', ['order_id' => $order->id])
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
        $financialYear = substr($startYear, 2) . "-" . substr($endYear, 2);
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

        return view('frontend.order.success', compact('order'));
    }

    public function showPaymentGateway($order_id)
    {
        $order = Order::findOrFail($order_id);

        // Ensure the user owns the order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $billingAddress = json_decode($order->billing_address, true);

        // ------------ test config ------------
        require_once(public_path('ICICI_MS/ICICI_MS_UAT/lib/Config.php'));
        // ------------ live config ------------
        // require_once(public_path('ICICI_MS/ICICI_MS_LIVE/lib/Config.php'));

        // Fetch order details
        $order = Order::findOrFail($order_id);

        // Get the ICICI payment URL from the kit

        // ----------------- test URL -----------------
        $iciciPaymentUrl = url('/ICICI_MS/ICICI_MS_UAT/saleApi.php');
        // ----------------- live URL -----------------
        // $iciciPaymentUrl = url('/ICICI_MS/ICICI_MS_LIVE/saleApi.php');

        // Prepare request data for ICICI Payment Gateway
        $paymentData = [
            'TxnRefNo' => $order->temp_invoice_id,
            'Amount' => $order->grand_total,
            'Currency' => 356, // INR
            'MerchantId' => MERCHANTID, // Defined in Config.php
            'TerminalId' => TERMINALID, // Defined in Config.php
            'orderInfo' => "Payment for Order #" . $order->id,
            'email' => $order->email,
            'phone' => $order->phone,
            'TxnType' => 'Pay',
        ];
        // Load the view with payment form
        return view('frontend.checkout.icici_redirect', compact('paymentData'));

        /* if (config('gatewaySettings.payu_status') == 1) {
            if (config('gatewaySettings.payu_test_mode') == 1) {
                $gatewayUrl = config('gatewaySettings.payu_test_url');
                $siteKey = config('gatewaySettings.payu_api_test_key');
                $secretKey = config('gatewaySettings.payu_test_secret_key');
            } else {
                $gatewayUrl = config('gatewaySettings.payu_url');
                $siteKey = config('gatewaySettings.payu_api_key');
                $secretKey = config('gatewaySettings.payu_secret_key');
            }

            if (empty($gatewayUrl)) {
                return redirect()->back()->withErrors('PayU Money gateway URL is missing.');
            }

            // Prepare payment parameters
            $params = [
                'key' => $siteKey,
                'txnid' => $order->temp_invoice_id,
                'amount' => $order->grand_total,
                'productinfo' => $order->temp_invoice_id . "<-->" . $order->id,
                'firstname' => $billingAddress['name'] ?? 'Customer',
                'email' => $order->email,
                'phone' => $order->phone,
                'surl' => route('payment.callback'),
                'furl' => route('order.failure', ['order_id' => $order->id]),
            ];

            // Generate Secure Hash
            $params['hash'] = $this->generatePayUHash($params, $secretKey);

            // Pass parameters to the view for POST submission
            return view('frontend.checkout.payu_redirect', compact('gatewayUrl', 'params'));
        } */

        return redirect()->back()->withErrors('PayU Money payment gateway is not enabled.');
    }

    /* private function generatePayUHash($params, $salt)
    {
        // Ensure all parameters exist; use empty strings if missing
        $hashSequence = implode('|', [
            $params['key'],
            $params['txnid'],
            $params['amount'],
            $params['productinfo'],
            $params['firstname'],
            $params['email'],
            $params['udf1'] ?? '',
            $params['udf2'] ?? '',
            $params['udf3'] ?? '',
            $params['udf4'] ?? '',
            $params['udf5'] ?? '',
            $params['udf6'] ?? '',
            $params['udf7'] ?? '',
            $params['udf8'] ?? '',
            $params['udf9'] ?? '',
            $params['udf10'] ?? '',
            $salt
        ]);

        return hash('sha512', $hashSequence);
    } */

    public function paymentCallback(Request $request)
    {
        $responseCode = $request->get('ResponseCode');
        $transactionId = $request->get('RetRefNo');
        $orderReference = $request->get('TxnRefNo');
        $order = Order::where('temp_invoice_id', $orderReference)->first();
        if ($responseCode !== "00") {
            return redirect()->route('order.failure', ['order_id' => $order->temp_invoice_id]);
        }

        if (!auth()->check() && $order->user_id) {
            auth()->loginUsingId($order->user_id);
        }

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $invoiceNumber = $this->generateInvoiceNumber();
        $order->update([
            'financial_year' => $invoiceNumber['financial_year'],
            'invoice_number' => $invoiceNumber['invoice_number'],
            'payment_status' => 1,
            'transaction_id' => $transactionId,
            'order_status' => 'Payment Received',
        ]);

        OrderNotificationEvent::dispatch($order->id);
        // reduce quantity of products if usertype == user
        if(auth()->user()->role == 'user'){
            QuantityReduceEvent::dispatch($order->id);
        }

        return redirect()->route('order.success', ['order_id' => $order->id]);
    }
    /* public function paymentCallback(Request $request)
    {
        $order = Order::where('temp_invoice_id', $request->get('txnid'))->first();
        if ($request->get('status') !== 'success' || !$order) {
            $productInfo = $request->get('productinfo');
            $orderId = explode('<-->', $productInfo)[1] ?? null;
            return redirect()->route('order.failure', ['order_id' => $orderId]);
        }

        if (!auth()->check() && $order->user_id) {
            auth()->loginUsingId($order->user_id);
        }

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $invoiceNumber = $this->generateInvoiceNumber();
        $order->update([
            'financial_year' => $invoiceNumber['financial_year'],
            'invoice_number' => $invoiceNumber['invoice_number'],
            'payment_status' => 1,
            'transaction_id' => $request->get('bank_ref_num'),
            'order_status' => 'Payment Received',
        ]);

        OrderNotificationEvent::dispatch($order->id);

        return redirect()->route('order.success', ['order_id' => $order->id]);
    } */

    public function orderFailure($order_id)
    {
        // dd($order_id);
        $order = Order::where('temp_invoice_id', $order_id)->first();
        return view('frontend.order.failure', compact('order'));
    }
}
