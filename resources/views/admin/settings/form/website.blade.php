<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('store.website.info') }}" method="post" class="needs-validation" role="form" novalidate
            enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">App Name<span class="bg-red">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control"
                        value="{{ isset($site) ? $site->title : old('title') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="slogan" class="col-sm-2 col-form-label">Slogan</label>
                <div class="col-sm-10">
                    <input type="text" name="slogan" class="form-control"
                        value="{{ isset($site) ? $site->slogan : old('slogan') }}" required>
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="logo" class="col-sm-2 col-form-label">Logo</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="logo" onchange="imageOnly('event')"
                        id="image">
                    @if (isset($site) && $site?->logo)
                        <div class="mt-3">
                            <img src="{{ storage_asset_path($site?->logo) }}" style="width: 100px; height:100px;">
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="favicon" class="col-sm-2 col-form-label">Favicon</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="favicon" onchange="imageOnly('event')"
                        id="image">
                    @if (isset($site) && $site?->favicon)
                        <div class="mt-3">
                            <img src="{{ storage_asset_path($site?->favicon) }}" style="width: 100px; height:100px;">
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="Date" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10" style="color: rgb(255, 255, 255)">
                    <button type="submit" class="publish-post">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
