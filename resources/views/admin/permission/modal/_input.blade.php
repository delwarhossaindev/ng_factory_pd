<div class="row mb-3 mt-3">
    <label class="col-sm-4 col-form-label text-sm-end" for="name">Name<span class="bg-red">
        *</span></label>
    <div class="col-sm-8">
        <input type="text" name="name" class="form-control" required
              value="{{ isset($permission) ? $permission->name : '' }}">
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label text-sm-end" for="name">Display Name<span class="bg-red">
        *</span></label>
    <div class="col-sm-8">
        <input type="text" name="display_name" class="form-control" required
              value="{{ isset($permission) ? $permission->display_name : '' }}">
    </div>
</div>
<div class="row mb-3 col-form-label text-sm-end">
    <label class="col-sm-4 mt-2" for="status">Description<span class="bg-red">
        *</span></label>
    <div class="col-sm-8 d-flex">
        <input type="text" name="description" class="form-control" required
              value="{{ isset($permission) ? $permission->description : '' }}">
    </div>
</div>
<div class="pt-0">
    <div class="row justify-content-end">
        <div class="col-sm-8 ui-dialog-buttonset">
            <button type="submit" class="ui-button ui-widget ui-corner-all">{{ !isset($permission) ? 'Save changes' : 'Update changes' }}</button>
        </div>
    </div>
</div>