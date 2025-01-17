<div class="tab-pane fade show active" id="payu-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.payu-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="">Payu Status</label>
                    <select name="payu_status" id="" class="select3 form-control">
                        <option @selected(@$paymentGateway['payu_status'] == 1) value="1">Active</option>
                        <option @selected(@$paymentGateway['payu_status'] == 0) value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Payu Country Name</label>
                    <select name="payu_country" id="" class="select3 form-control">
                        <option value="">Select</option>
                        @foreach (config('country_list') as $key => $country)
                            <option @selected(@$paymentGateway['payu_country'] === $key) value="{{ $key }}">{{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Payu Currency</label>
                    <select name="payu_currency" id="" class="select3 form-control">
                        <option value="">Select</option>
                        @foreach (config('currencys.currency_list') as $currency)
                            <option @selected(@$paymentGateway['payu_currency'] === $currency) value="{{ $currency }}">{{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Currency Rate ( Per {{ config('settings.site_default_currency') }} )</label>
                    <input name="payu_rate" type="text" class="form-control"
                        value="{{ @$paymentGateway['payu_rate'] }}">
                </div>

                <div class="form-group">
                    <label for="">Payu Key</label>
                    <input name="payu_api_key" type="text" class="form-control"
                        value="{{ @$paymentGateway['payu_api_key'] }}">
                </div>

                <div class="form-group">
                    <label for="">Payu Secret Key</label>
                    <input name="payu_secret_key" type="text" class="form-control"
                        value="{{ @$paymentGateway['payu_secret_key'] }}">
                </div>
                <div class="form-group">
                    <label for="">Payu URL</label>
                    <input name="payu_url" type="text" class="form-control"
                        value="{{ @$paymentGateway['payu_url'] }}">
                </div>
{{-- checkbox for testmode keys --}}
<div class="form-group">
    <label for="">Payu Test Mode</label>  
    <!-- Hidden input to ensure value is sent when unchecked -->
    <input type="hidden" name="payu_test_mode" value="0">
    <!-- Custom styled checkbox -->
    <input name="payu_test_mode" type="checkbox" id="payu_test_mode"
        class="custom-checkbox checkbox"
        value="1" {{ @$paymentGateway['payu_test_mode'] == 1 ? 'checked' : '' }}>
    <!-- Label Clickable + Dynamic Color Change -->
    <label for="payu_test_mode" class="custom-label">Are You Using Test Mode?</label>
</div>

                        <div class="form-group">
                            <label for="">Payu Test URL</label>
                            <input name="payu_test_url" type="text" class="form-control"
                                value="{{ @$paymentGateway['payu_test_url'] }}">
                        </div>
                        <div class="form-group">
                            <label for="">Payu Test Key</label>
                            <input name="payu_api_test_key" type="text" class="form-control"
                                value="{{ @$paymentGateway['payu_api_test_key'] }}">
                        </div>

                        <div class="form-group">
                            <label for="">Payu Test Secret Key</label>
                            <input name="payu_test_secret_key" type="text" class="form-control"
                                value="{{ @$paymentGateway['payu_test_secret_key'] }}">
                        </div>
{{-- testmode end --}}
                <div class="form-group">
                    <label>Payu Logo</label>
                    <div id="image-preview" class="image-preview payu-preview">
                        <label for="image-upload" id="image-label">Choose File</label>
                        <input type="file" name="payu_logo" id="image-upload" />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function(){
            $('.payu-preview').css({
				'background-image': `url({{ asset(@$paymentGateway['payu_logo']) }})`,
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush

