<!DOCTYPE html>
<html>
<head>
    <title>Picking List - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()" >

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
                <td colspan="2" class="print-page-title" ><strong>PICKING LIST</strong></td>
            </tr>
        </tbody>
    </table>

    <table class="print-detail-table">
        <tr>
            <td>
                <strong>Doc. #:</strong> {{ $pickList->doc_no }}<br><br>
                <strong>Doc. Date:</strong> {{ $pickList->doc_date }}<br><br>
            </td>
            <td>
                <strong>Dispatch Date:</strong> {{ $pickList->dispatch_date }}<br><br>
                <strong>Dispatch Location:</strong> {{ $pickList->dispatch_location }}<br><br>
            </td>
            <td>
                <strong>Client:</strong> {{ $pickList->client->client_name }}<br><br>
                <strong>Contact:</strong> {{ $pickList->contact_name }} - {{ $pickList->contact_address }}<br><br>
            </td>
            <td>
                <strong>No. of Items Picked:</strong> {{ $pickList->pickListDetails->count() }}<br><br>
                <strong>Total Package Qty:</strong> {{ $pickList->tot_package_qty }}<br><br>
            </td>
        </tr>
    </table>

    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th class="txt-left" >Product</th>
                <th class="txt-left" >Lot No.</th>
                <th>Pkg Type</th>
                <th>Pallet Location</th>
                <th>Pallet</th>
                <th>Size</th>
                <th>G.W/Pkg</th>
                <th>N.W/Pkg</th>
                <th>G.W. Total</th>
                <th>N.W. Total</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tot_qty = $tot_gw_per_package = $tot_nw_per_package = $tot_gw_with_pallet = $tot_nw_kg = 0;
            @endphp
            @foreach($pickListDetails as $k => $v)
                <tr>
                    <td>{{ $k + 1 }}</td>
                    <td class="txt-left">{{ $v->packingListDetail->cargo_description }}</td>
                    <td class="txt-left">{{ $v->packingListDetail->lot_no }}</td>
                    <td class="txt-center">{{ $v->packingListDetail->packageType?->description }}</td>
                    <td class="txt-left">{{ $v->pallet->pallet_position }}</td>
                    <td>{{ $v->pallet->pallet_no }}</td>
                    <td class="txt-center">{{ $v->packingListDetail->item_size_per_package }}</td>
                    <td class="txt-center">{{ $v->packingListDetail->gw_per_package }}</td>
                    <td class="txt-center">{{ $v->packingListDetail->nw_per_package }}</td>
                    <td class="txt-center">{{ $v->packingListDetail->gw_with_pallet }}</td>
                    <td class="txt-center">{{ $v->packingListDetail->nw_kg }}</td>
                    <td class="txt-center">{{ $v->quantity }}</td>
                </tr>
                @php
                    $tot_qty += $v->quantity;
                    $tot_gw_per_package += $v->packingListDetail->gw_per_package;
                    $tot_nw_per_package += $v->packingListDetail->nw_per_package;
                    $tot_gw_with_pallet += $v->packingListDetail->gw_with_pallet;
                    $tot_nw_kg += $v->packingListDetail->nw_kg;
                @endphp
            @endforeach
            <tr style="font-weight: bold;">
                <td class="txt-right" colspan="7">Total</td>
                <td class="txt-center">{{ $tot_gw_per_package }}</td>
                <td class="txt-center">{{ $tot_nw_per_package }}</td>
                <td class="txt-center">{{ $tot_gw_with_pallet }}</td>
                <td class="txt-center">{{ $tot_nw_kg }}</td>
                <td class="txt-center">{{ $tot_qty }}</td>
            </tr>
        </tbody>
    </table>

    <table class="print-sign-table">
        <tr>
            <td style="height: 60px; vertical-align: bottom;">
                <strong>Picked By:</strong> ___________________________
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
      setTimeout(() => {
        window.close();
      }, 1000); // Give time for the print dialog to open
    }
</script>
