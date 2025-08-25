<!DOCTYPE html>
<html>
<head>
    <title>Stock Summary Print</title>
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
                <td colspan="2" class="print-page-title" ><strong>STOCK SUMMARY</strong></td>
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
                    <th>Slot</th><th>Pallet</th><th>Pallet Count</th>
                    <th>In Qty</th><th>Out Qty</th><th>Closing Qty</th>
                </tr>
            </thead>
            <tbody>
                <tr class="section-title">
                    <th colspan="6" style="text-align: centre; border-right: none;">GRN: {{ $grn }}</th>
                    <th colspan="5" style="text-align: right; border-left: none;">{{ $group['date'] }}</th>
                </tr>
                @foreach($group['items'] as $item)
                    <tr>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['batch_no'] }}</td>
                        <td>{{ $item->RateType??'Monthly' }}</td>
                        <td>{{ $item['UOM'] }}</td>
                        <td>{{ $item['SubUOM'] }}</td>
                        <!-- <td>{{ $item['rooms'] ?? 'N/A' }}</td>
                        <td>{{ $item['racks'] ?? '' }}</td>
                        <td>{{ $item['slots'] ?? '' }}</td> -->
                        <td>
                            {{
                                $item['slot_positions'] ?? ''
                            }}
                        </td>
                        <td>{{ $item['pallets'] ?? '' }}</td>
                        <td>{{ $item['pallet_count'] ?? '' }}</td>
                        <td>{{ number_format($item['in_quantity'], 2) }}</td>
                        <td>{{ number_format($item['out_quantity'], 2) }}</td>
                        <td>{{ number_format($item['total_quantity'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="section-title">
                    <th colspan="7" style="text-align: right;">Sub Total:</th>
                    <th style="text-align: center;">{{ number_format($group['subpallettotal'], 2) }}</th>
                    <th style="text-align: center;">{{ number_format($group['subintotal'], 2) }}</th>
                    <th style="text-align: center;">{{ number_format($group['subouttotal'], 2) }}</th>
                    <th style="text-align: center;">{{ number_format($group['subtotal'], 2) }}</th>
                </tr>
                <tr class="summary footer">
                    <th colspan="7" style="text-align: right;">Total Qty:</th>
                    <th style="text-align: center;">{{ number_format($total_pallet, 2) }}</th>
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