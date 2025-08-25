<!DOCTYPE html>
<html>
<head>
    <title>Packing List - Print</title>
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
            <td colspan="2" class="print-page-title" ><strong>PACKING LIST</strong></td>
        </tr>
    </tbody>
</table>

<table class="print-detail-table">
    <tr>
        <td>
            <strong>Doc. #:</strong> {{ $packingList->doc_no }}<br><br>
            <strong>Doc. Date:</strong> {{ $packingList->doc_date }}<br><br>
            <strong>Invoice #:</strong> {{ $packingList->invoice_no }}<br><br>
            <strong>Invoice Date:</strong> {{ $packingList->invoice_date }}<br>
        </td>

        <!-- Column 2 -->
        <td>
            <strong>Status:</strong> {{ $packingList->status }}<br><br>
            <strong>Supplier:</strong> {{ $packingList->supplier->supplier_name }}<br><br>
            <strong>Client:</strong> {{ $packingList->client->client_name ?? '' }}<br><br>
            <strong>Notify:</strong> {{ $packingList->contact_person }}<br>
        </td>

        <!-- Column 3 -->
        <td>
            <strong>Container #:</strong> {{ $packingList->container_nos }}<br><br>
            <strong>Package Type:</strong> {{ $packingList->package_types }}<br><br>
            <strong>Loading Date:</strong> {{ $packingList->loading_date }}<br><br>
            <strong>Goods:</strong> {{ $packingList->goods }}<br>
        </td>

        <!-- Column 4 -->
        <td>
            <strong>Size:</strong> {{ $packingList->size }}<br><br>
            <strong>Port of Loading:</strong> {{ $packingList->loading_port_id }}<br><br>
            <strong>Port of Discharge:</strong> {{ $packingList->discharge_port_id }}<br><br>
            <strong>Vessel:</strong> {{ $packingList->vessel_name }} / {{ $packingList->voyage_no }}<br>
        </td>
    </tr>
</table>

<table class="print-list-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Size</th>
            <th>No. of Pallets</th>
            <th>No. of Packages</th>
            <th>Package Type</th>
            <th>Cargo Desc.</th>
            <th>Variety</th>
            <th>G.W/Pkg</th>
            <th>N.W/Pkg</th>
            <th>G.W. Total</th>
            <th>N.W. Total</th>
            <th>Class</th>
            <th>Brand</th>
            <th>Lot</th>
        </tr>
    </thead>
    <tbody>
        @php
            $tot_pallet_qty = $tot_package_qty = $tot_gw_per_package = $tot_nw_per_package = $tot_gw_with_pallet = $tot_nw_kg = 0;
        @endphp
        @foreach($packingListDetails as $k => $v)
        <tr>
            <td>{{ $k + 1 }}</td>
            <td>{{ $v->item_size_per_package }}</td>
            <td>{{ $v->pallet_qty }}</td>
            <td>{{ $v->package_qty }}</td>
            <td>{{ $v->packageType?->description }}</td>
            <td>{{ $v->cargo_description }}</td>
            <td>{{ $v->variety->ProductCategoryName }}</td>
            <td>{{ $v->gw_per_package }}</td>
            <td>{{ $v->nw_per_package }}</td>
            <td>{{ $v->gw_with_pallet }}</td>
            <td>{{ $v->nw_kg }}</td>
            <td>{{ $v->class ?? '' }}</td>
            <td>{{ $v->brand->brand_name ?? '' }}</td>
            <td>{{ $v->lot_no }}</td>
        </tr>
        @php
            $tot_pallet_qty += $v->pallet_qty;
            $tot_package_qty += $v->package_qty;
            $tot_gw_per_package += $v->gw_per_package;
            $tot_nw_per_package += $v->nw_per_package;
            $tot_gw_with_pallet += $v->gw_with_pallet;
            $tot_nw_kg += $v->nw_kg;
        @endphp
        @endforeach
        <tr style="font-weight: bold;">
            <td></td>
            <td>Total</td>
            <td>{{ $tot_pallet_qty }}</td>
            <td>{{ $tot_package_qty }}</td>
            <td colspan="3"></td>
            <td>{{ $tot_gw_per_package }}</td>
            <td>{{ $tot_nw_per_package }}</td>
            <td>{{ $tot_gw_with_pallet }}</td>
            <td>{{ $tot_nw_kg }}</td>
            <td colspan="3"></td>
        </tr>
    </tbody>
</table>

</body>
</html>

<script>
function printAndClose() {
    window.print();
    setTimeout(() => window.close(), 1000);
}
</script>
