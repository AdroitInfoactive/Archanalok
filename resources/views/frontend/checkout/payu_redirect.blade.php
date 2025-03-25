@extends('frontend.layouts.master')
@section('content')
    <div class="container text-center">
        <h2>Redirecting to PayU Money...</h2>
        <p>Please wait while we process your payment.</p>

        <form id="payu-form" action="{{ $gatewayUrl }}" method="POST">
            @foreach($params as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="btn btn-primary">Click here if you are not redirected</button>
        </form>

        <script>
            document.getElementById('payu-form').submit();
        </script>
    </div>
@endsection