@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Payment Gateway</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Gateways</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2">
                      <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#payu-setting" role="tab" aria-controls="home" aria-selected="true">payu</a>
                        </li>
                       
                        <li class="nav-item">
                          <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#razorpay-setting" role="tab" aria-controls="contact" aria-selected="false">Razorpay</a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                      <div class="tab-content no-padding" id="myTab2Content">
                        @include('admin.payment-setting.sections.payu')

                        @include('admin.payment-setting.sections.razorpay')


                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </section>
@endsection
<style>
  /* Increase checkbox size */
  .custom-checkbox {
      width: 20px;
      height: 20px;
      accent-color: red; /* Red color when checked */
      cursor: pointer;
  }

  /* Style label to change when checkbox is checked */
  .custom-label {
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      color: black;
      transition: 0.3s;
  }

  /* Change label color dynamically when checked */
  .checkbox:checked + .custom-label {
      color: red;
  }
</style>

