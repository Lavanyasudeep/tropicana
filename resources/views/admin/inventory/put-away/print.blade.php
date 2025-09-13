<!DOCTYPE html>
<html>
<head>
    <title>Putaway - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">
@php
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

$putaway = [
    [
        'product_code'      => 'FRZ-001',
        'product'           => 'Ice Cream Tubs - 35cmx35cmx20cm',
        'lot'               => 'BCH-25-001',
        'expiry_date'       => '2026-02-15',
        'uom'               => 'Boxes',
        'qty'               => 60,
        'volume'            => 8
    ],
    [
        'product_code'      => 'FRZ-002',
        'product'           => 'Paneer Blocks 5kg - 40cmx30cmx25cm',
        'lot'               => 'BCH-25-002',
        'expiry_date'       => '2026-03-20',
        'uom'               => 'Boxes',
        'qty'               => 40,
        'volume'            => 2
    ]
];

$qrPayload = [
    'doc_no' => 'PUT-25-00004',
    'items'  => $putaway
];

$builder = new Builder(
    writer: new PngWriter(),
    data: json_encode($qrPayload),
    size: 150,
    margin: 5
);

$result = $builder->build();
$qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());
@endphp

<!-- Header -->
<table class="print-detail-table">
    <tr>
        <td style="text-align:left;">
            <img src="{{ asset('images/logo.jpeg') }}" style="width:150px;" alt="Company Logo">
        </td>
        <td style="text-align:left;">
            @include('common.print-company-address')
        </td>
    </tr>
    <tr>
        <td colspan="2" class="print-page-title"><strong>PUTAWAY</strong></td>
    </tr>
</table>

<!-- Metadata -->
<table class="print-detail-table">
    <tr>
        <td>
            <strong>Doc No:</strong> PUT-25-00004<br>
            <strong>Doc Date:</strong> 26/08/2025<br>
            <strong>Doc Time:</strong> 09:42<br>
            <strong>Gatepass No.:</strong> GP-1001<br>
            <strong>Packing List No.:</strong> PL-25-00001<br>
            <strong>Vehicle No.:</strong> KL-07-CD-4521<br>
            <strong>Customer:</strong> Chelur Foods
        </td>
        <td>
            <strong>Warehouse Unit:</strong> WU-0001<br>
            <strong>Dock No:</strong> D-07<br>
            <strong>Chamber No:</strong> CR-102<br>
            <strong>Pallet No:</strong> PLT-00001<br>
            <strong>Pallet Location:</strong>  WU0001-CR002-B2-R5-L1-D2<br>
            <strong>Total Volume (m³):</strong> {{ collect($putaway)->sum('volume') }}
        </td>
        <td>
            <strong>Putaway By:</strong> Ramesh Kumar<br>
            <strong>Start Time:</strong> 09:15<br>
            <strong>End Time:</strong> 09:42<br>
            <strong>Team:</strong> Cold Ops Team A<br>
            <strong>Remarks:</strong> All items placed correctly, no discrepancies
        </td>
        <td>
            <strong>Status:</strong> Completed<br>
            <strong>QR Code:</strong><br>
            <img src="{{ $qrCodeBase64 }}" style="width:80px;height:80px;">
        </td>
    </tr>
</table>

<!-- Items Table -->
<table class="print-list-table">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Lot No</th>
            <th>Expiry Date</th>
            <th class="txt-right">Putaway Qty</th>
            <th>UOM</th>
            <th class="txt-right">Volume (m³)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($putaway as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item['product_code'] }}</td>
            <td>{{ $item['product'] }}</td>
            <td>{{ $item['lot'] }}</td>
            <td>{{ $item['expiry_date'] }}</td>
            <td class="txt-right">{{ $item['qty'] }}</td>
            <td>{{ $item['uom'] }}</td>
            <td class="txt-right">{{ $item['volume'] }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="font-weight:bold;">
            <td colspan="5" class="txt-right">Total</td>
            <td class="txt-right">{{ collect($putaway)->sum('qty') }}</td>
            <td></td>
            <td class="txt-right">{{ collect($putaway)->sum('volume') }}</td>
        </tr>
    </tfoot>
</table>

<!-- Signature Table -->
<table class="print-sign-table">
    <tr>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Assigned By:</strong> ___________________________
        </td>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Putaway By:</strong> ___________________________
        </td>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Verified By:</strong> ___________________________
        </td>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Approved By:</strong> ___________________________
        </td>
    </tr>
</table>

<script>
function printAndClose() {
    window.print();
    setTimeout(() => window.close(), 1000);
}
</script>

</body>
</html>
