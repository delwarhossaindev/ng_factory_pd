<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('settings') }}" method="post" class="needs-validation" role="form" novalidate>
            @csrf
            @method('patch')
            @foreach ($settings as $setting)
                <div class="form-group row {{ $loop->last ? 'mt-3' : '' }}">
                    @if ($setting->value == '0' || $setting->value == '1')
                        <label class="col-sm-3 mt-1" for="status">{{ $setting->display_name }}</label>
                        <div class="col-sm-9 d-flex">
                            <label class="switch switch-square">
                                <input type="radio" class="switch-input" name="key[{{ $setting->key }}]"
                                    value="1" {{ $setting->value == true ? 'checked' : '' }} required>
                                <span class="switch-toggle-slider">
                                    <span class="switch-on">
                                        <i class="bx bx-check"></i>
                                    </span>
                                    <span class="switch-off">
                                        <i class="bx bx-x"></i>
                                    </span>
                                </span>
                                <span class="switch-label text-sm">Enable</span>
                            </label>
                            <label class="switch switch-square">
                                <input type="radio" class="switch-input" name="key[{{ $setting->key }}]"
                                    value="0" {{ $setting->value == false ? 'checked' : '' }} required>
                                <span class="switch-toggle-slider">
                                    <span class="switch-on">
                                        <i class="bx bx-check"></i>
                                    </span>
                                    <span class="switch-off">
                                        <i class="bx bx-x"></i>
                                    </span>
                                </span>
                                <span class="switch-label text-sm">Disable</span>
                            </label>
                        </div>
                    @else
                        <label class="col-sm-3 col-form-label"
                            for="{{ $setting->key }}">{{ $setting->display_name }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="key[{{ $setting->key }}]" class="form-control mb-3"
                                value="{{ $setting->value }}" placeholder="{{ $setting->display_name }}" required>
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="form-group row mt-3">
                <label for="Date" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <button type="submit" class="publish-post">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
