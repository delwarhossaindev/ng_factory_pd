<x-app-component>
    <x-page.page-title data="Update Password" />
    <x-slot name="content">
        <x-breadcrumb.breadcrumb-component firstLabel='Dashboard' firstLabelRoute='dashboard' secondLable='Profile'
            secondLabelRoute='profile' currentPageText="Update Password" />
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 card">
                <form action="{{ route('update.password') }}" method="post" class="needs-validation card-body"
                    role="form" novalidate>
                    @csrf
                    <div class="row mb-3 mt-3">
                        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-full-name">Previous Password<span
                                class="bg-red">*</span></label>
                        <div class="col-sm-9">
                            <input type="password" name="old_password" class="form-control" required autocomplete="on">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-full-name">New Password<span
                            class="bg-red">*</span></label>
                        <div class="col-sm-9">
                            <input type="password" name="new_password" class="form-control" required autocomplete="on">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-full-name">Confirm Password<span
                            class="bg-red">*</span></label>
                        <div class="col-sm-9">
                            <input type="password" name="password_confirmation" class="form-control" required autocomplete="on">
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="publish-post">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </x-slot>
</x-app-component>
