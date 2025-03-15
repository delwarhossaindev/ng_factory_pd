<x-app-component>
    <x-page.page-title data="Credit Note Information" />
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    </x-slot>
    <x-slot name="content">
        <div class="card">
            <div class="card-body">
                <h5 class="text-center mb-1 mt-4"><strong>ACI Motors Limited</strong></h5>
                <p class="text-center">Credit Note Information</p>
                <div>
                    <p class="mb-2"><b>Territory:</b> {{ $data['model_data']->Territory }}</p>
                    <p class="mb-0"><b>Region:</b> {{ $data['model_data']->Region }}</p>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-sm table-bordered motors_table">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2">Code No</th>
                                <th rowspan="2">Customer Full Name</th>
                                <th rowspan="2">Invoice Number</th>
                                <th rowspan="2">Invoice Date</th>
                                <th rowspan="2">Captured Date</th>
                                <th colspan="5">Credit Note Type/Information</th>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <th>Qty(Units)</th>
                                <th>Unit Price(TK)</th>
                                <th>Value (TK)</th>
                                <th>Credit Note Value (TK)</th>
                            </tr>
                        </thead>
                        @php
                            $sum = 0;
                        @endphp
                        <tbody>
                            <tr>
                                <td>{{ $data['model_data']->CustomerCode }}</td>
                                <td>{{ $data['model_data']->CustomerName }}</td>
                                <td>{{ $data['model_data']->InvoiceNo }}</td>
                                <td>{{ $data['model_data']?->InvoiceDate }}</td>
                                <td>{{ $data['model_data']->CaptureDate }}</td>
                                @foreach ($data['related_invoice'] as $item)
                                <td>{{ $item->ProductName }}</td>
                                <td class="text-end">{{ $item->SalesQTY }}</td>
                                <td class="text-end">{{ $item->UnitPrice }}</td>
                                <td class="text-end">{{ $item->NET }}</td>
                                <td class="text-end">{{ $item->NET }}</td>
                                @php
                                    $sum += $item->NET;
                                @endphp
                                @break
                                @endforeach
                            </tr>
                            @foreach ($data['related_invoice'] as $item)
                            @if ($loop->first)
                                @continue
                            @endif
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $item->ProductName }}</td>
                                <td class="text-end">{{ $item->SalesQTY }}</td>
                                <td class="text-end">{{ $item->UnitPrice }}</td>
                                <td class="text-end">{{ $item->NET }}</td>
                                <td class="text-end">{{ $item->NET }}</td>
                                @php
                                    $sum += $item->NET;
                                @endphp
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7"></td>
                                <th colspan="2" class="text-center">Total Credit Amount</td>
                                <td class="text-end">{{ number_format($sum,2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-5">
                    <ul class="d-flex justify-content-between mt-5">
                        <div>
                            <hr>
                            <h6><strong>Prepared By</strong></h6>
                            <p>SO/TMO/MO</p>
                        </div>
                        <div>
                            <hr>
                            <h6><strong>Confirmed By</strong></h6>
                            <p>SO/TMO/MO</p>
                        </div>
                        <div>
                            <hr>
                            <h6><strong>Agreed By</strong></h6>
                            <p>SO/TMO/MO</p>
                        </div>
                        <div>
                            <hr>
                            <h6><strong>Checked By</strong></h6>
                            <p>SO/TMO/MO</p>
                        </div>
                        <div>
                            <hr>
                            <h6><strong>Recommended By</strong></h6>
                            <p>SO/TMO/MO</p>
                        </div>
                        <div>
                            <hr>
                            <h6><strong>Forwarded By</strong></h6>
                            <p>SO/TMO/MO</p>
                        </div>
                        <div>
                            <hr>
                            <h6><strong>Approved By</strong></h6>
                            <p>SO/TMO/MO</p>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-component>
