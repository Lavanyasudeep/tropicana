<!DOCTYPE html>
<html>
<head>
    <title>Outward - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

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
                <td colspan="2" class="print-page-title" ><strong>OUTWARD SUMMARY</strong></td>
            </tr>
        </tbody>
    </table>

    <table class="print-detail-table">
        <tr>
            <td>
                <strong>Doc. #:</strong> {{ $outward->doc_no }}<br><br>
                <strong>Doc. Date:</strong> {{ $outward->doc_date }}<br><br>
            </td>
            <td>
                <strong>Status:</strong> {{ $outward->status }}<br><br>
                <strong>Client:</strong> {{ $outward->client->client_name }}<br><br>
            </td>
            <td>
                <strong>Contact:</strong> {{ $outward->contact_name }}<br><br>
                <strong>Address:</strong> {{ $outward->contact_address }}<br><br>
            </td>
            <td>
                <strong>Vehicle No:</strong> {{ $outward->vehicle_no }}<br><br>
                <strong>Driver:</strong> {{ $outward->driver }}<br><br>
            </td>
        </tr>
    </table>

    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th class="txt-left" >Product</th>
                <th class="txt-left" >Lot No.</th>
                <th class="txt-center" >Pkg Type</th>
                <th class="txt-center" >Size</th>
                <th class="txt-center" >Slot</th>
                <th class="txt-center" >Pallet</th>
                <th class="txt-center" >G.W/Pkg</th>
                <th class="txt-center" >N.W/Pkg</th>
                <th class="txt-center" >G.W. Total</th>
                <th class="txt-center" >N.W. Total</th>
                <th class="txt-center" >Qty</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tot_qty = $tot_gw_per_package = $tot_nw_per_package = $tot_gw_with_pallet = $tot_nw_kg = $tot_pallet_qty = 0;
            @endphp
            @foreach($outwardDetails as $k => $v)
                <tr>
                    <td>{{ $k + 1 }}</td>
                    <td class="txt-left">{{ $v->pickListDetail->packingListDetail->cargo_description }}</td>
                    <td class="txt-left">{{ $v->pickListDetail->packingListDetail->lot_no }}</td>
                    <td class="txt-center">{{ $v->pickListDetail->packingListDetail->packageType?->description }}</td>
                    <td class="txt-center">{{ $v->pickListDetail->packingListDetail->item_size_per_package }}</td>
                    <td class="txt-center">{{ $v->pickListDetail->room->name }}-{{ $v->pickListDetail->rack->name }}-{{ $v->pickListDetail->slot->level_no }}-{{ $v->pickListDetail->slot->depth_no }}</td>
                    <td class="txt-center">{{ $v->pickListDetail->pallet->name }}</td>
                    <td class="txt-center">{{ $v->pickListDetail->packingListDetail->gw_per_package }}</td>
                    <td class="txt-center">{{ $v->pickListDetail->packingListDetail->nw_per_package }}</td>
                    <td class="txt-center">{{ $v->pickListDetail->packingListDetail->gw_with_pallet }}</td>
                    <td class="txt-center">{{ $v->pickListDetail->packingListDetail->nw_kg }}</td>
                    <td class="txt-center">{{ $v->quantity }}</td>
                </tr>
                @php
                    $tot_qty += $v->quantity;
                    $tot_gw_per_package += $v->pickListDetail->packingListDetail->gw_per_package;
                    $tot_nw_per_package += $v->pickListDetail->packingListDetail->nw_per_package;
                    $tot_gw_with_pallet += $v->pickListDetail->packingListDetail->gw_with_pallet;
                    $tot_nw_kg += $v->pickListDetail->packingListDetail->nw_kg;
                    $tot_pallet_qty += $outward->pallet_qty ?? 0;
                @endphp
            @endforeach
            <tr style="font-weight: bold;" >
                <td class="txt-right" colspan="7" >Total</td>
                <td class="txt-center">{{ $tot_gw_per_package }}</td>
                <td class="txt-center">{{ $tot_nw_per_package }}</td>
                <td class="txt-center">{{ $tot_gw_with_pallet }}</td>
                <td class="txt-center">{{ $tot_nw_kg }}</td>
                <td class="txt-center">{{ $tot_qty }}</td>
            </tr>
        </tbody>
    </table>

    <table class="print-summary-table">
        <tr>
            <td><strong>Weight of 1 empty pallet:</strong></td>
            <td class="txt-right" >{{ $outward->packing_lists?->pluck('weight_per_pallet')->implode(', ') }}</td>
        </tr>
        <tr>
            <td><strong>Total No of Pallets:</strong></td>
            <td class="txt-right" >{{ $tot_pallet_qty }}</td>
        </tr>
        <tr>
            <td><strong>Total No of Packages Picked:</strong></td>
            <td class="txt-right" >{{ $tot_qty }}</td>
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
                <br /><br /><br />
                <strong>Picked By:</strong> ___________________________
            </td>
            <td style="height: 60px; vertical-align: bottom;">
                <br /><br /><br />
                <strong>Verified By:</strong> ___________________________
            </td>
            <td style="height: 60px; vertical-align: bottom;">
                <br /><br /><br />
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
