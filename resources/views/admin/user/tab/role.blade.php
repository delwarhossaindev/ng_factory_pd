<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="zip_code">Role<span class="bg-red">
            *</span></label>
    <div class="col-sm-9">
        @foreach (role_list() as $role)
            <label class="switch switch-square mt-1">
                <input type="radio" class="switch-input" value="{{ $role->id }}" name="role"
                    value="{{ $role->id }}"
                    {{ in_array($role->id,isset($user)? $user->roles()->pluck('id')->toArray(): [])? 'checked': '' }}
                    required>
                <span class="switch-toggle-slider">
                    <span class="switch-on">
                        <i class="bx bx-check"></i>
                    </span>
                    <span class="switch-off">
                        <i class="bx bx-x"></i>
                    </span>
                </span>
                <span class="switch-label">{{ $role->display_name }}</span>
            </label>
        @endforeach
    </div>
</div>
<div class="pt-2">
    <div class="row justify-content-end">
        <div class="col-sm-9">
            <button type="submit" class="publish-post me-1">{{ !isset($user) ? 'Save changes' : 'Update changes' }}</button>
        </div>
    </div>
</div>