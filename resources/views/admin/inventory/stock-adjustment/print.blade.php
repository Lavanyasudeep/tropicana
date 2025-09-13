<!DOCTYPE html>
<html>
<head>
    <title>Inward - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

    <table class="print-detail-table">
        <tbody>
            <tr>
                <td style="text-align: left;"><img src="{{ asset('images/logo.jpeg') }}" style="width:150px;" alt="Kern Logo"></td>
                <td style="text-align: left;">
                    @include('common.print-company-address')
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td colspan="2" class="print-page-title" ><strong>INWARD SUMMARY</strong></td>
            </tr>
        </tbody>
    </table>

    <table class="print-detail-table">
        <tr>
            <td>
                <strong>Doc. #:</strong> {{ $inward->doc_no }}<br><br>
                <strong>Doc. Date:</strong> {{ $inward->doc_date }}<br><br>
                <strong>Status:</strong> {{ $inward->status }}<br><br>
            </td>
            <td>
                <strong>Packing List:</strong> {{ $inward->packingList->doc_no }}<br><br>
                <strong>Client:</strong> {{ $inward->client->client_name }}<br><br>
                <strong>GRN No:</strong> {{ optional($inward->packingList?->grn)->GRNNo }}<br><br>
            </td>
            <td>
                <strong>Supplier Name:</strong> {{ optional($inward->packingList?->supplier)->supplier_name }}<br><br>
                <strong>Goods:</strong> {{ $inward->packingList->goods }}<br><br>
                <strong>Size:</strong> {{ $inward->packingList->size }}<br><br>
            </td>
        </tr>
    </table>

    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Lot</th>
                <th>Slot Positions</th>
                <th>Pallets</th>
                <th>Size</th>
                <th>Weight/Unit</th>
                <th>Pkg Type</th>
                <th>G.W/Pkg</th>
                <th>N.W/Pkg</th>
                <th>G.W. Total</th>
                <th>N.W. Total</th>
                <th>Total Pkg</th>
                <th>Qty/Pallet</th>
                <th>Pallet Qty</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tot_gw_per_package = $tot_nw_per_package = $tot_gw_with_pallet = $tot_nw_kg = $tot_package_qty = $tot_pallet_qty = $tot_package_qty_per_pallet = 0;
            @endphp
            @foreach ($inwardDetails as $v)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="txt-left">{{ $v['product_name'] }}</td>
                <td class="txt-left" >{{ $v['batch_no'] }}</td>
                <td class="txt-left" >{{ $v['slot_positions'] }}</td>
                <td class="txt-left" >{{ $v['pallets'] }}</td>
                <td class="txt-center">{{ $v['item_size_per_package'] }}</td>
                <td class="txt-center">{{ $v['weight_per_unit'] }}</td>
                <td class="txt-left" >{{ $v['package_types'] }}</td>
                <td class="txt-center">{{ $v['gw_per_package'] }}</td>
                <td class="txt-center">{{ $v['nw_per_package'] }}</td>
                <td class="txt-center">{{ $v['gw_with_pallet'] }}</td>
                <td class="txt-center">{{ $v['nw_kg'] }}</td>
                <td class="txt-center">{{ $v['total_quantity'] }}</td>
                <td class="txt-center">{{ $v['package_qty_per_pallet'] }}</td>
                <td class="txt-center">{{ $v['pallet_qty'] }}</td>
            </tr>
            @php
                $tot_gw_per_package += $v['gw_per_package'];
                $tot_nw_per_package += $v['nw_per_package'];
                $tot_gw_with_pallet += $v['gw_with_pallet'];
                $tot_nw_kg += $v['nw_kg'];
                $tot_package_qty += $v['total_quantity'];
                $tot_package_qty_per_pallet += $v['package_qty_per_pallet'];
                $tot_pallet_qty += $v['pallet_qty'];
            @endphp
            @endforeach
            <tr style="font-weight: bold;">
                <td colspan="8">Total</td>
                <td class="txt-center">{{ $tot_gw_per_package }}</td>
                <td class="txt-center">{{ $tot_nw_per_package }}</td>
                <td class="txt-center">{{ $tot_gw_with_pallet }}</td>
                <td class="txt-center">{{ $tot_nw_kg }}</td>
                <td class="txt-center">{{ $tot_package_qty }}</td>
                <td class="txt-center">{{ $tot_package_qty_per_pallet }}</td>
                <td class="txt-center">{{ $tot_pallet_qty }}</td>
            </tr>
        </tbody>
    </table>

    <table class="print-summary-table">
        <tr>
            <td><strong>Weight of 1 empty pallet:</strong></td>
            <td class="txt-right">{{ $inward->packingList->weight_per_pallet }}</td>
        </tr>
        <tr>
            <td><strong>Total No of Pallets:</strong></td>
            <td class="txt-right" >{{ $tot_pallet_qty }}</td>
        </tr>
        <tr>
            <td><strong>Total No of Packages Assigned:</strong></td>
            <td class="txt-right" >{{ $tot_package_qty }}</td>
        </tr>
        <tr>
            <td><strong>Total G.W with Pallet Weight:</strong></td>
            <td class="txt-right" >{{ $tot_gw_with_pallet }}</td>
        </tr>
        <tr>
            <td><strong>Total N.W:</strong></td>
            <td class="txt-right" >{{ $tot_nw_kg }}</td>
        </tr>
    </table>


    <table class="print-sign-table">
        <tr>
            <td style="height: 60px; vertical-align: bottom;">
                <strong>Assigned By:</strong> ___________________________
            </td>
            <td style="height: 60px; vertical-align: bottom;">
                <strong>Verified By:</strong> ___________________________
            </td>
            <td style="height: 60px; vertical-align: bottom;">
                <strong>Approved By:</strong> ___________________________
            </td>
        </tr>
    </table>
</body>
</html>

<script>
    function printAndClose() {
        window.print();
        setTimeout(() => window.close(), 1000);
    }
</script>
