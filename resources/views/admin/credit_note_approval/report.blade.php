

 <h5 class="text-center mb-1 mt-4"><strong>ACI Motors Limited</strong></h5>
    <p class="text-center">Credit Note Information</p>
    <div>
        <p class="mb-2"><b>Territory:</b> {{ $data[0]->Territory ?? null }}</p>
        <p class="mb-0"><b>Region:</b> {{ $data[0]->Region ?? null }}</p>
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
                    <th colspan="4">Credit Note Type/Information</th>
                </tr>
                <tr>
                    <th>Product Name</th>
                    <th>Qty(Units)</th>
                    <th>Unit Price(TK)</th>
                    <th>Value (TK)</th>
                </tr>
            </thead>
            @php
                $sum = 0;
            @endphp
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->CustomerCode }}</td>
                        <td>{{ $item->CustomerName }}</td>
                        <td>{{ $item->InvoiceNo }}</td>
                        <td>{{ $item->InvoiceDate }}</td>
                        <td>{{ $item->CaptureDate }}</td>

                        <td>{{ $item->ProductName }}</td>
                        <td class="text-end">{{ $item->SalesQTY }}</td>
                        <td class="text-end">{{ $item->UnitPrice }}</td>
                        <td class="text-end">{{ number_format($item->SalesValue, 2) }}</td>
                    </tr>
                    @php
                        $sum += $item->CreditNoteValue;
                    @endphp
                @endforeach

            <tfoot>
                <tr>
                    <td colspan="7"></td>
                    <th colspan="2" class="text-center">Total Credit Amount</td>
                    <td class="text-end">{{ number_format($sum, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-5">
        <ul class="d-flex justify-content-between mt-5">
            <div>
                @if (isset($signature[0]->PreparedBy))
                @if ($signature[0]->PreparedBy!='')
                <img src="{{ asset('public/storage/'. $signature[0]->PreparedBy) }}" style="width: 100px; height: 50px; border: 2px solid white;">
                @else
                <div style="width: 100px; height: 50px; border: 2px solid white;"></div>
                @endif
                @endif
                <hr>
                <h6><strong>Prepared By</strong></h6>
                <p>SO/TMO/MO</p>
            </div>
            <div>
                @if (isset($signature[0]->ConfirmedBy))
                @if ($signature[0]->ConfirmedBy!='')
                <img src="{{ asset('public/storage/'. $signature[0]->ConfirmedBy) }}" style="width: 100px; height: 50px; border: 2px solid white;">
                @else
                <div style="width: 100px; height: 50px; border: 2px solid white;"></div>
                @endif
                @endif
                <hr>
                <h6><strong>Confirmed By</strong></h6>
                <p>SO/TMO/MO</p>
            </div>
            <div>
                @if (isset($signature[0]->AgreedBy))
                @if ($signature[0]->AgreedBy!='')
                <img src="{{ asset('public/storage/'. $signature[0]->AgreedBy) }}" style="width: 100px; height: 50px; border: 2px solid white;">
                @else
                <div style="width: 100px; height: 50px; border: 2px solid white;"></div>
                @endif
                @endif
                <hr>
                <h6><strong>Agreed By</strong></h6>
                <p>SO/TMO/MO</p>
            </div>
            <div>
                @if (isset($signature[0]->CheckedBy))
                @if ($signature[0]->CheckedBy!='')
                <img src="{{ asset('public/storage/'. $signature[0]->CheckedBy) }}" style="width: 100px; height: 50px; border: 2px solid white;">
                @else
                <div style="width: 100px; height: 50px; border: 2px solid white;"></div>
                @endif
                @endif
                <hr>
                <h6><strong>Checked By</strong></h6>
                <p>SO/TMO/MO</p>
            </div>
            <div>
                @if (isset($signature[0]->RecommendedBy))
                @if ($signature[0]->RecommendedBy!='')
                <img src="{{ asset('public/storage/'. $signature[0]->RecommendedBy) }}" style="width: 100px; height: 50px; border: 2px solid white;">
                @else
                <div style="width: 100px; height: 50px; border: 2px solid white;"></div>
                @endif
                @endif
                <hr>
                <h6><strong>Recommended By</strong></h6>
                <p>SO/TMO/MO</p>
            </div>
            <div>
                @if (isset($signature[0]->ForwaredBy))
                @if ($signature[0]->ForwaredBy!='')
                <img src="{{ asset('public/storage/'. $signature[0]->ForwaredBy) }}" style="width: 100px; height: 50px; border: 2px solid white;">
                @else
                <div style="width: 100px; height: 50px; border: 2px solid white;"></div>
                @endif
                @endif
                <hr>
                <h6><strong>Forwarded By</strong></h6>
                <p>SO/TMO/MO</p>
            </div>
            <div>
                @if (isset($signature[0]->ApprovedBy))
                @if ($signature[0]->ForwaredBy!='')
                <img src="{{ asset('public/storage/'. $signature[0]->ApprovedBy) }}" style="width: 100px; height: 50px; border: 2px solid white;">
                @else
                <div style="width: 100px; height: 50px; border: 2px solid white;"></div>
                @endif
                @endif
                <hr>
                <h6><strong>Approved By</strong></h6>
                <p>SO/TMO/MO</p>
            </div>
        </ul>



    </div>

