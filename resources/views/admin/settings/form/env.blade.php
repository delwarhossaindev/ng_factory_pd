<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('env.update') }}" method="post" class="needs-validation" role="form" novalidate>
            @csrf
            <div class="row mb-3 mt-2">
                <label class="col-sm-3 col-form-label" for="MAIL MAILER">MAILER</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="MAIL_MAILER" value="{{ env('MAIL_MAILER') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3 mt-2">
                <label class="col-sm-3 col-form-label" for="MAIL_HOST">HOST</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="MAIL_HOST" value="{{ env('MAIL_HOST') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3 mt-2">
                <label class="col-sm-3 col-form-label" for="MAIL_PORT">PORT</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="MAIL_PORT" value="{{ env('MAIL_PORT') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3 mt-2">
                <label class="col-sm-3 col-form-label" for="MAIL_USERNAME"> USERNAME</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="MAIL_USERNAME"
                            value="{{ env('MAIL_USERNAME') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3 mt-2">
                <label class="col-sm-3 col-form-label" for="MAIL_PASSWORD"> PASSWORD</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="MAIL_PASSWORD"
                            value="{{ env('MAIL_PASSWORD') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3 mt-2">
                <label class="col-sm-3 col-form-label" for="MAIL_ENCRYPTION"> ENCRYPTION</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <select class="selectpicker form-control" name="MAIL_ENCRYPTION" data-container="body" data-live-search="true" data-live-search-style="begins" data-actions-box="true"  data-max-options="1" required>
                            <option value="ssl" {{ env('MAIL_ENCRYPTION') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="tls" {{ env('MAIL_ENCRYPTION') == 'tls' ? 'selected' : '' }}>TLS</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mb-3 mt-2">
                <label class="col-sm-3 col-form-label" for="MAIL_FROM_ADDRESS"> FROM ADDRESS</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="MAIL_FROM_ADDRESS"
                            value="{{ env('MAIL_FROM_ADDRESS') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-3 mt-2">
                <label class="col-sm-3 col-form-label" for="MAIL_FROM_ADDRESS"></label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <button type="submit" class="publish-post">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
