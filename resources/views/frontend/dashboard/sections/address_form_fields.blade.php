<div class="form-group">
    <label>First Name</label>
    <input type="text" class="form-control" name="first_name" id="{{ $prefix }}_first_name">
</div>
{{-- <div class="form-group">
    <label>Last Name</label>
    <input type="text" class="form-control" name="last_name" id="{{ $prefix }}_last_name">
</div> --}}
<div class="form-group">
    <label>Email</label>
    <input type="text" class="form-control" name="email" id="{{ $prefix }}_email">
</div>
<div class="form-group">
    <label>Phone</label>
    <input type="text" class="form-control" name="phone" id="{{ $prefix }}_phone">
</div>
<div class="form-group">
    <label>Address</label>
    <input type="text" class="form-control" name="address" id="{{ $prefix }}_address">
</div>

<div class="form-group">
    <label>City</label>
    <input type="text" class="form-control" name="city" id="{{ $prefix }}_city">
</div>
<div class="form-group">
    <label>State</label>
    <input type="text" class="form-control" name="state" id="{{ $prefix }}_state">
</div>
<div class="form-group">
    <label>ZIP</label>
    <input type="text" class="form-control" name="zip" id="{{ $prefix }}_zip">
</div>
<div class="form-group">
    <label>Country</label>
    <input type="text" class="form-control" name="country" id="{{ $prefix }}_country">
</div>
<div class="form-group">
    <label for="is_default">Is Default Address</label>
    <!-- Hidden input ensures a default value of 0 -->
    <input type="hidden" name="is_default" value="0">
    <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
</div>



