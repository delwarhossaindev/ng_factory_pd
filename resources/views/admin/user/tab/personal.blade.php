<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="alignment-email">UserID<span class="bg-red"> *</span></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="UserID" required
                value="{{ isset($user) ? $user->UserID : old('UserID') }}" {{ isset($user) ? 'readonly' : '' }}>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="SupervisorID">Supervisor ID<span class="bg-red"> *</span></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="SupervisorID" id="SupervisorID" required
            value="{{ isset($user) ? $user->SupervisorID : old('SupervisorID') }}">
    </div>
</div>
@if (!isset($user))
    <div class="row mb-3 form-password-toggle">
        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-password">Password<span class="bg-red">
                *</span></label>
        <div class="col-sm-9">
            <input type="password" name="Password" class="form-control" required autocomplete="on">
        </div>
    </div>
@endif
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="UserName">UserName<span class="bg-red"> *</span></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="UserName" required value="{{ isset($user) ? $user->UserName : old('UserName') }}">
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="Level">Level<span class="bg-red"> *</span></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="Level" id="Level" required
            value="{{ isset($user) ? $user->Level : old('Level') }}">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="profile-pic">
        Profile Pic
    </label>
    <div class="col-sm-9">
        <input type="file" class="form-control" name="ProfilePath" accept="image/*"
            id="profile-pic" onchange="imageOnly()" />
    </div>
</div>
@if (isset($user) && $user->ProfilePath)
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label text-sm-end"></label>
        <div class="col-sm-9">
            <img src="{{ storage_asset_path($user->ProfilePath) }}" alt="profile-image"
                width="50" height="50">
        </div>
    </div>
@endif

<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-sm-end" for="signature-pic">
        Signature Pic
    </label>
    <div class="col-sm-9">
        <input type="file" class="form-control" name="SignaturePath" accept="image/*"
            id="signature-pic" onchange="imageOnly()" />
    </div>
</div>
@if (isset($user) && $user->SignaturePath)
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label text-sm-end"></label>
        <div class="col-sm-9">
            <img src="{{ storage_asset_path($user->SignaturePath) }}" alt="signature-image"
                width="50" height="50">
        </div>
    </div>
@endif

@php
   $menus =\DB::table('menus')->get();
   if(isset($user)){
    $user_meuns =\DB::table('user_menus')->where('user_id',$user->UserID)->get();
   }

@endphp

<div class="row">
    <div class="col-3">
        <label class="control-label">Menu Permissions</label>
    </div>
    <div class="col-9 row">
            @foreach($menus as $menu)
            <div class="col-12">
                <div class="form-check form-check-flat form-check-primary">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="Menus[]"
                            value="{{$menu->id}}"
                            @isset($user)
                            @foreach($user_meuns as $user_meun)
                            {{($user_meun->menu_id == $menu->id) ? 'checked' : 'true'}}
                            @endforeach
                            @endisset
                            >
                            {{$menu->name}}
                    </label>
                </div>
            </div>
        @endforeach

     </div>
</div>

<div class="pt-2">
    <div class="row justify-content-end">
        <div class="col-sm-9">
            <button type="submit" class="publish-post me-1">{{! isset($user) ? 'Save changes' : 'Update changes' }}</button>
        </div>
    </div>
</div>
