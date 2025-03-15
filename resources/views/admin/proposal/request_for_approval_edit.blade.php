<x-app-component>
    <x-page.page-title data="Edit NG Factory PD" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
        <style>
            .typeahead-content {
                background-color: #fff;
                cursor: pointer;
                width: 100%;
                will-change: width, height;
            }
            .typeahead-highlight {
                font-weight: 900;
                color: #f1c40f;
            }
            .tt-cursor,
            .tt-suggestion:hover,
            .typeahead-cursor,
            .typeahead-suggestion:hover {
                background-color: #e9ecef;
                color: #fff;
            }
            .typeahead-notfound {
                cursor: not-allowed;
                padding: 5px 0 10px 10px;
                text-align: start;
            }
            .tt-menu {
                background-color: #fff;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                box-shadow: 0 5px 10px #e9ecef;
                margin-top: 12px;
                padding: 8px 0;
                width: 422px;
            }
            .tt-suggestion {
                font-size: 22px;
                padding: 3px 20px;
                color: #000;
                text-align: start;
            }
            .tt-suggestion:hover {
                cursor: pointer;
            }
            .tt-suggestion p {
                margin: 0;
            }
            span.twitter-typeahead {
                width: 100%;
            }
        </style>
    </x-slot>
    <x-slot name="content">

        <form action="{{ route('credit_note_approval.request_for_approval_update', $creditNote->CodeNo) }}" method="post" class="needs-validation mt-3" role="form" novalidate>
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 mt-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="InvoiceNo">Invoice No<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control w-100 tt-search" name="InvoiceNo" id="InvoiceNo" value="{{ $creditNote->InvoiceNo }}" readonly>
                                    {{-- <span class="display-none" id="search-loader">Searching</span> --}}
                                </div>
                            </div>
                            <div class="row mb-3 mt-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="CustomerCode">Customer Code<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control w-100 CustomerCode" name="CustomerCode" value="{{ $creditNote->CustomerCode }}"  readonly>
                                </div>
                            </div>
                            <input type="hidden" class="form-control w-100 InvoiceDate" name="InvoiceDate" value="{{ $creditNote->InvoiceDate }}"  readonly>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="CustomerName">Customer Name<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control w-100 CustomerName" name="CustomerName" value="{{ $creditNote->CustomerName }}"  readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="DeliveryDate">Delivery Date<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control w-100 DeliveryDate" name="DeliveryDate" value="{{ $creditNote->DeliveryDate }}"  readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="Territory">Territory<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control w-100 Territory" name="Territory" value="{{ $creditNote->Territory }}"  readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="Area">Area<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control w-100 Area" name="Area" value="{{ $creditNote->Area }}"  readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="Region">Region<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control w-100 Zone" name="Region" value="{{ $creditNote->Region }}"  readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="Status">Status<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control w-100 w-80" name="Status"  style="background: #ffffff;" required>
                                        <option value="">Status</option>
                                        @foreach($status as $obj)
                                        <option value="{{ $obj->StatusID }}">{{ $obj->StatusName }}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pt-2">
                                <div class="row justify-content-end">
                                    <div class="col-sm-8">
                                        <button type="submit" class="publish-post me-1" style="background: #f0c40f; color:#000">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-sm table-bordered table-stripped mt-3">
                                <thead>
                                    <tr style="background: #e9ecef;">
                                        <th width="45%">Model</th>
                                        <th width="15%">Qty(Units)</th>
                                        <th width="25%">Unit Price(TK)</th>
                                        <th width="15%">Value(TK)</th>
                                    </tr>
                                </thead>
                                <tbody id="services">
                                    @foreach($creditNoteDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->ProductName }}</td>
                                            <td class="text-end">{{ $detail->SalesQTY }}</td>
                                            <td class="text-end">{{ $detail->UnitPrice }}</td>
                                            <td class="text-end">{{ $detail->NET }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row mb-3 mt-5">
                                <label class="col-sm-4 col-form-label text-sm-end" for="Remarks">Remarks</label>
                                <div class="col-sm-8">
                                    <textarea name="Remarks" class="form-control w-100 w-80" readonly>{{ $creditNote->Remarks }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="CaptureDate">Capture Date<span class="bg-red"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control w-100" name="CaptureDate" value="{{ $creditNote->CaptureDate }}" required readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-sm-end" for="RotavatorModel">Rotavator</label>
                                <div class="col-sm-8">
                                    <select class="form-control w-100 w-80" name="RotavatorModel" disabled>
                                        <option value="">Rotavator Model</option>
                                        <option value="Sonalika Smart Series 48 Blade" {{ $creditNote->RotavatorModel == 'Sonalika Smart Series 48 Blade' ? 'selected' : '' }}>Sonalika Smart Series 48 Blade</option>
                                        <option value="Sonalika Smart Series 54 Blade" {{ $creditNote->RotavatorModel == 'Sonalika Smart Series 54 Blade' ? 'selected' : '' }}>Sonalika Smart Series 54 Blade</option>
                                        <option value="Sonalika Smart Alpha Series 48 Blade" {{ $creditNote->RotavatorModel == 'Sonalika Smart Alpha Series 48 Blade' ? 'selected' : '' }}>Sonalika Smart Alpha Series 48 Blade</option>
                                        <option value="Sonalika Smart Alpha Series 54 Blade" {{ $creditNote->RotavatorModel == 'Sonalika Smart Alpha Series 54 Blade' ? 'selected' : '' }}>Sonalika Smart Alpha Series 54 Blade</option>
                                        <option value="Maschio 48 Blade" {{ $creditNote->RotavatorModel == 'Maschio 48 Blade' ? 'selected' : '' }}>Maschio 48 Blade</option>
                                        <option value="Maschio 54 Blade" {{ $creditNote->RotavatorModel == 'Maschio 54 Blade' ? 'selected' : '' }}>Maschio 54 Blade</option>
                                        <option value="Sicma 48 Blade" {{ $creditNote->RotavatorModel == 'Sicma 48 Blade' ? 'selected' : '' }}>Sicma 48 Blade</option>
                                        <option value="Sicma 54 Blade" {{ $creditNote->RotavatorModel == 'Sicma 54 Blade' ? 'selected' : '' }}>Sicma 54 Blade</option>
                                        <option value="No Rotavator Found" {{ $creditNote->RotavatorModel == 'No Rotavator Found' ? 'selected' : '' }}>No Rotavator Found</option>
                                        <option value="Trailer (Hydraulic)" {{ $creditNote->RotavatorModel == 'Trailer (Hydraulic)' ? 'selected' : '' }}>Trailer (Hydraulic)</option>
                                        <option value="Trailer (Non-Hydraulic)" {{ $creditNote->RotavatorModel == 'Trailer (Non-Hydraulic)' ? 'selected' : '' }}>Trailer (Non-Hydraulic)</option>
                                        <option value="No Trailer Found" {{ $creditNote->RotavatorModel == 'No Trailer Found' ? 'selected' : '' }}>No Trailer Found</option>
                                        <option value="Other Implements" {{ $creditNote->RotavatorModel == 'Other Implements' ? 'selected' : '' }}>Other Implements</option>
                                    </select>
                                </div>
                            </div>
                            @if ($UserLevel !='Level2')
                            <div class="row mb-3 mt-5">
                                <label class="col-sm-4 col-form-label text-sm-end" for="Comment">Comment</label>
                                <div class="col-sm-8">
                                    <textarea name="Comment" class="form-control w-100 w-80" style="background: #ffffff;"></textarea>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>
    <x-slot name="script">
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/datatable.js') }}"></script>
        <script src="https://app.acibd.com/vision_bc/typehead/typehead.js"></script>
        <script>
            const route = "{{ route('search.invoice') }}";
            var content = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: route + '?query=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            var content_typeahead = $(".tt-search").typeahead({
                hint: true,
                highlight: true,
                minLength: 1,
                classNames: {
                    menu: 'typeahead-content',
                    highlight: 'typeahead-highlight',
                    cursor: 'typeahead-cursor'
                }
            }, {
                source: content.ttAdapter(),
                name: 'InvoiceList',
                displayKey: 'InvoiceNo',
                templates: {
                    empty: [
                        '<div class="typeahead-notfound">No invoice found.</div>'
                    ],
                    suggestion: function(data) {
                        return '<div class="typeahead-suggestion">' + data.InvoiceNo + '-' + data.CustomerCode + '</div>';
                    }
                }
            }).on('typeahead:select', function(e, data) {
                const date = new Date(data.DeliveryDate);
                const DeliveryDate = new Date(date.getTime() - (date.getTimezoneOffset() * 60000))
                    .toISOString()
                    .split("T")[0];
                $('.CustomerCode').val(data.CustomerCode);
                $('.DeliveryDate').val(DeliveryDate);
                $('.InvoiceDate').val(data.InvoiceDate);
                $('.CustomerName').val(data.CustomerName1);
                $('.Territory').val(data.Territory);
                $('.Zone').val(data.Zone);
                $('.Area').val(data.Area);
                $.ajax({
                    type: 'get',
                    url: "{{ route('search.invoice.detail') }}" + '?invoiceNo=' + data.InvoiceNo,
                    success: function(data) {
                        let html = '';
                        data.forEach(element => {
                            html += `<tr>
                                        <td>${element.ProductName}</td>
                                        <td class="text-end">${element.SalesQTY}</td>
                                        <td class="text-end">${element.UnitPrice}</td>
                                        <td class="text-end">${element.NET}</td>
                                    </tr>`;
                        });
                        $('#services').html(html);
                    }
                });
            }).on('typeahead:asyncrequest', function(e) {
                $('#search-loader').show();
            }).on('typeahead:asynccancel typeahead:asyncreceive', function(e) {
                $('#search-loader').hide();
            });
        </script>
    </x-slot>
</x-app-component>
