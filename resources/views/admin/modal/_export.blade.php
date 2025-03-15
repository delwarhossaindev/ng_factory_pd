<div id="export-form-datatable" title="Export data as csv file" tabindex="-1" style="display: none;">
    <small class="py-0"><span class="bg-red"> *</span> You have to select at least one</small>
    <form class="needs-validation export-form" role="form" novalidate>
        @csrf
        <div class="row mb-0" style="margin-top:10px;">
            <div class="form-group col-md-6">
                <label for="date_form" class="form-label">Date From</label>
                <input class="form-control" type="date" id="date_form" name="date_form">
            </div>
            <div class="form-group col-md-6">
                <label for="date_to" class="form-label">Date To</label>
                <input class="form-control" type="date" id="date_to" name="date_to">
            </div>
        </div>
        <div class="col mb-0" style="margin-top:10px;">
            <div class="form-check mb-2">
                <input class="form-check-input selected_all_row" type="checkbox" id="selected_column">
                <label class="form-check-label" style="margin-right:5px;">Select All</label>
            </div>
        </div>
        <input type="hidden" id="db_table" value="{{ $db_table }}">
        <div class="form-inline">
            @foreach (Schema::getColumnListing($db_table) as $index => $row)
            @if ($row === 'id' || $row === 'deleted_at' || $row === 'updated_at' || $row === 'created_at' ||  $row === 'remember_token'|| $row === 'email_verified_at' || $row === 'ah_signatured' || $row === 'rsm_signatured' || $row === 'gm_signatured' || $row === 'hq_signatured')
            @continue
            @endif
                <div class="col mb-0" style="margin-top:10px;">
                    <div class="form-check mb-2">
                        <input class="selected_row_column" type="checkbox" name="selected_rows[]"
                            id="selected_column" value="{{ $row }}">
                        <label class="form-check-label" style="margin-right:5px;">{{ $row }}</label>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pt-3">
            <div class="row justify-content-start">
                <div class="col-sm-8 ui-dialog-buttonset">
                    <button type="submit" class="ui-button ui-widget ui-corner-all" id="export">Export</button>
                </div>
            </div>
        </div>
        <center>
            <p class="display-none text-red" id="checkbox_error">Please select at least one column!
            </p>
        </center>
        <center>
            <p class="display-none" id="loader">Exporting....... please wait</p>
        </center>
    </form>
</div>
