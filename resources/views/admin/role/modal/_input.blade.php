<div class="row">
    <div class="col mb-3">
        <label class="form-label">Name<span class="bg-red">
            *</span></label>
        <input type="text" name="name" class="form-control w-100" required value="{{ isset($role) ? $role->name : '' }}">
    </div>
</div>
<div class="row g-2">
    <div class="col mb-0">
        <label class="form-label">Display Name<span class="bg-red">
            *</span></label>
        <input type="text" name="display_name" class="form-control w-100" required
            value="{{ isset($role) ? $role->display_name : '' }}">
    </div>
    <div class="col mb-0">
        <label class="form-label">Description<span class="bg-red">
            *</span></label>
        <input type="text" name="description" class="form-control w-100" required
            value="{{ isset($role) ? $role->description : '' }}">
    </div>
</div>
<hr>

@php  $previous_permission = "";  @endphp

<div class="">
    <input type="checkbox" id="selectAll" class="form-check-input" />
    <label class="checkboxSuccess1" for="selectAll" id="replace">
        Check All
    </label>
</div>
<div class="form-inline">
    @foreach (permission_list() as $permission)
        @if ($previous_permission != $permission->description)
            <div class="col mb-0" style="margin-top:10px;">
                <input type="checkbox" class="form-check-input {{ lcfirst($permission->description) }}"
                    value="{{ $permission->id }}"
                    onClick="selectPermission('{{ lcfirst($permission->description) }}')" />
                <label for="{{ $permission->description }}" class="form-label bold">
                    {{ ucfirst($permission->description) }}
                </label>
            </div>
        @endif
        <div class="form-check mb-2 form-inline">
            <input class="form-check-input" id="{{ lcfirst($permission->description) }}" type="checkbox"
                id="{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                {{ isset($role) &&in_array($permission->id,$role->permissions()->pluck('id')->toArray())? 'checked': '' }}>
            <label class="form-check-label" for="{{ $permission->id }}">
                {{ $permission->display_name }}
            </label>
        </div>
        @php
            $previous_permission = $permission->description;
            $check = isset($permissions[$loop->index + 1]->description) ? $permissions[$loop->index + 1]->description : '-';
        @endphp
        @if ($previous_permission != $check || $check == '-')
        @endif
    @endforeach
</div>
<div class="col-sm-8 ui-dialog-buttonset mt-2">
    <button type="submit" class="ui-button ui-widget ui-corner-all">{{ !isset($role) ? 'Save changes' : 'Update changes' }}</button>
</div>