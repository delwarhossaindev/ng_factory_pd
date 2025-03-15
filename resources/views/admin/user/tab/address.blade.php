<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="alignment-full-name">Type<span
            class="bg-red"> *</span></label>
    <div class="col-sm-9">
        <div class="col-sm-9">
            <label for="radio-3">Primary</label>
            <input type="radio" name="address_type" id="radio-3" class="radio"
                value="Primary" {{ isset($user) ? $user->address?->address_type == 'Primary' ? 'checked' : '' : '' }}>
            <label for="radio-4">Permanent</label>
            <input type="radio" name="address_type" id="radio-4" class="radio"
                value="Permanent" {{ isset($user) ? $user->address?->address_type == 'Permanent' ? 'checked' : '' : '' }}>
        </div>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="address_line_1">Address line 1<span
            class="bg-red"> *</span></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="address_line_1" required value="{{ isset($user) ? $user->address?->address_line_1 : old('address_line_1') }}"/>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="address_line_2">Address line
        2</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="address_line_2" value="{{ isset($user) ? $user->address?->address_line_2 : old('address_line_2') }}"/>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="city">City</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="city" value="{{ isset($user) ? $user->address?->city : old('city') }}"/>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="state">State</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="state" value="{{ isset($user) ? $user->address?->state : old('state') }}"/>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="zip_code">zip code</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="zip_code" value="{{ isset($user) ? $user->address?->zip_code : old('zip_code') }}"/>
    </div>
</div>
<div class="pt-2">
    <div class="row justify-content-end">
        <div class="col-sm-9">
            <button type="submit" class="publish-post me-1">{{! isset($user) ? 'Save changes' : 'Update changes' }}</button>
        </div>
    </div>
</div>