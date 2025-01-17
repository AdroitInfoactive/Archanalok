<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySetting;
use App\Services\PaymentGatewaySettingService;
use App\Traits\FileUploadTrait;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PaymentGatewaySettingController extends Controller
{
    use FileUploadTrait;
    public function index(): View
    {
        $paymentGateway = PaymentGatewaySetting::pluck('value', 'key');
        return view('admin.payment-setting.index', compact('paymentGateway'));
    }

    function razorpaySettingUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'razorpay_status' => ['required', 'boolean'],
            'razorpay_country' => ['required'],
            'razorpay_currency' => ['required'],
            'razorpay_rate' => ['required', 'numeric'],
            'razorpay_api_key' => ['required'],
            'razorpay_secret_key' => ['required'],
            'razorpay_url' => ['required'],
            'razorpay_test_mode' => ['nullable', 'boolean'],
            'razorpay_api_test_key' => ['required'],
            'razorpay_test_secret_key' => ['required'],
            'razorpay_test_url' => ['required'],
        ]);

        if ($request->hasFile('razorpay_logo')) {
            $request->validate([
                'razorpay_logo' => ['nullable', 'image']
            ]);
            $imagePath = $this->uploadImage($request, 'razorpay_logo', '', 'uploads/payment_logo');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'razorpay_logo'],
                ['value' => $imagePath]
            );
        }

        foreach ($validatedData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully!');
        return redirect()->back();
    }
    function payuSettingUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'payu_status' => ['required', 'boolean'],
            'payu_country' => ['required'],
            'payu_currency' => ['required'],
            'payu_rate' => ['required', 'numeric'],
            'payu_api_key' => ['required'],
            'payu_secret_key' => ['required'],
            'payu_url' => ['required'],
            'payu_test_mode' => ['nullable', 'boolean'], // Allow default 0
            'payu_api_test_key' => ['required'],
            'payu_test_secret_key' => ['required'],
            'payu_test_url' => ['required'],

        ]);
        if ($request->hasFile('payu_logo')) {
            $request->validate([
                'payu_logo' => ['nullable', 'image']
            ]);
            $imagePath = $this->uploadImage($request, 'payu_logo', '', 'uploads/payment_logo');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'payu_logo'],
                ['value' => $imagePath]
            );
        }

        foreach ($validatedData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully!');
        return redirect()->back();
    }
    
}
