@extends('frontend.layouts.master')
@section('content')
<div class="container text-center">
    <!-- <h2>Redirecting to Payment Gateway...</h2>
    <p>Please wait while we process your payment.</p> -->
    <body onload="document.getElementById('iciciPaymentForm').submit();">
        <h3>Redirecting to ICICI Payment Gateway...</h3>
        <p>Please wait while we process your payment.</p>
        <form id="iciciPaymentForm" method="POST"
            action="{{ url('/ICICI_MS/ICICI_MS_UAT/processSale.php') }}">
            @foreach($paymentData as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <noscript><input type="submit" value="Click here to continue"></noscript>
        </form>
    </body>
</div>
@endsection