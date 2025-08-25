<!DOCTYPE html>
<html>
<head>
    <title>Stock Detail Print</title>
    <style>
        
        .section-title {
            font-weight: bold;
            margin-top: 15px;
            background: #eee;
            padding: 4px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()" >
    <table class="print-detail-table">
        <tbody>
            <tr>
                <td style="text-align: left;"><img src="{{ asset('images/logo.jpeg') }}" style="width:150px;" alt="Kern Logo"></td>
                <td style="text-align: left;">
                    <h3>JOHNSON CHILL PRIVATE LIMITED</h3>
                    <p>No.314/1A2, Pala, Kottayam District, Kerala - 602105.</p>
                    <p>Contact : 9994218509 | Email: coldstore@johnsonchill.com / johnsonchillstore@gmail.com</p>
                    <p>Website: www.johnsonchill.com</p>
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td colspan="2" class="print-page-title" ><strong>STOCK DETAIL</strong></td>
            </tr>
            <!-- <tr>
                <td><strong>Party:</strong> {{ $party_name }}</td>
                <td style="text-align: left;"><strong>As on Date:</strong> {{ date('d-M-Y', strtotime($report_date)) }}</td>
            </tr> -->
        </tbody>
    </table>
    @foreach($stock_groups as $grn => $group)
        <table class="print-list-table">
            <thead>
                <tr>
                    <th>Product</th><th>Lot</th><th>Rate</th><th>UOM</th><th>SubUOM</th>
                    <th>Slot</th><th>Pallet</th><th>In Qty</th><th>Out Qty</th><th>Closing Qty</th>
                </tr>
            </thead>
            <tbody>
                <tr class="section-title">
                    <th colspan="5" style="text-align: center; border-right: none;">GRN: {{ $grn }}</th>
                    <th colspan="5" style="text-align: center; border-left: none;">{{ $group['date'] }}</th>
                </tr>
                @foreach($group['items'] as $item)
                    <tr>
                        <td style="text-align: left;" >{{ $item->product->product_description ?? '' }}</td>
                        <td style="text-align: left;" >{{ $item->batch_no }}</td>
                        <td>{{ $item->RateType??'Monthly' }}</td>
                        <td>{{ $item->packingListDetail->packageType ? $item->packingListDetail->packageType?->description : '' }}</td>
                        <td>{{ $item->packingListDetail? $item->packingListDetail->item_size_per_package : '' }}</td>
                        <!-- <td>{{ $item->storage_room_name ?? 'N/A' }}</td> -->
                        <!-- <td>{{ $item->rack->name ?? '' }}</td>
                        <td>{{ $item->slot->name ?? '' }}</td> -->
                        <td>
                            {{
                                ($item->room->name ?? '') . '-' .
                                ($item->rack->name ?? '') . '-' .
                                ($item->slot->level_no ?? '') . '-' .
                                ($item->slot->depth_no ?? '')
                            }}
                        </td>
                        <td>{{ $item->pallet->name ?? '' }}</td>
                        <td>{{ number_format($item->in_qty, 2) }}</td>
                        <td>{{ number_format($item->out_qty, 2) }}</td>
                        <td>{{ number_format($item->available_qty, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="section-title">
                    <th colspan="7" style="text-align: right;">Sub Total:</th>
                    <th style="text-align: center;">{{ number_format($group['subintotal'], 2) }}</th>
                    <th style="text-align: center;">{{ number_format($group['subouttotal'], 2) }}</th>
                    <th style="text-align: center;">{{ number_format($group['subtotal'], 2) }}</th>
                </tr>
                <tr class="summary footer">
                    <th colspan="7" style="text-align: right;">Total Qty:</th>
                    <th style="text-align: center;">{{ number_format($total_in_qty, 2) }}</th>
                    <th style="text-align: center;">{{ number_format($total_out_qty, 2) }}</th>
                    <th style="text-align: center;">{{ number_format($total_qty, 2) }}</th>
                </tr>
            </tbody>
        </table>
        <!-- <div class="summary footer">Sub Total: {{ number_format($group['subtotal'], 2) }}</div> -->
    @endforeach
    <!-- <div class="summary footer">Total Qty: {{ number_format($total_qty, 2) }}</div> -->

    <!-- <div class="footer no-print">
        <button onclick="window.print()">Print</button>
    </div> -->
</body>
</html>

<script>
    function printAndClose() {
      window.print();
      setTimeout(() => {
        window.close();
      }, 1000); // Give time for the print dialog to open
    }
</script>