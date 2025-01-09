<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Name *</label>
            <input type="text" class="form-control" name="name" id="{{ $prefix }}_name">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Email *</label>
            <input type="text" class="form-control" name="email" id="{{ $prefix }}_email">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Phone *</label>
            <input type="text" class="form-control" name="phone" id="{{ $prefix }}_phone">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Address *</label>
            <input type="text" class="form-control" name="address" id="{{ $prefix }}_address">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>City *</label>
            <input type="text" class="form-control" name="city" id="{{ $prefix }}_city">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>State *</label>
            <select name="state" id="{{ $prefix }}_state" class="form-control">
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>ZIP *</label>
            <input type="text" class="form-control" name="zip" id="{{ $prefix }}_zip">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Company</label>
            <input type="text" class="form-control" name="company" id="{{ $prefix }}_company">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>GST</label>
            <input type="text" class="form-control" name="gst" id="{{ $prefix }}_gst">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <input type="checkbox" name="is_default_billing" id="{{ $prefix }}_is_default_billing" value="1"
            {{ old('is_default_billing') ? 'checked' : '' }}>
            <label for="{{ $prefix }}_is_default_billing">Default Billing Address</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="checkbox" name="is_default_shipping" id="{{ $prefix }}_is_default_shipping" value="1"
            {{ old('is_default_shipping') ? 'checked' : '' }}>
            <label for="{{ $prefix }}_is_default_shipping">Default Shipping Address</label>
        </div>
    </div>
</div>
