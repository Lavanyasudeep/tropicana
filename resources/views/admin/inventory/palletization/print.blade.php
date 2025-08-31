<!DOCTYPE html>
<html>
<head>
    <title>Pallet - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">
@php
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
$pallet = [
    [
        'pallet_no'         => 'PLT-00001',
        'warehouse_unit_no' => 'WU-0005',
        'room_no'           => 'R-102',
        'dock_no'           => 'D-07',
        'product_code'      => 'FRZ-001',
        'product'           => 'Frozen Prawns 500g',
        'lot'               => 'BCH-25-001',
        'size'              => '500g',
        'package_type'      => 'Carton',
        'no_of_packages'    => 60,
        'total_gw'          => 750,
        'total_nw'          => 720,
        'expiry_date'       => '2026-02-15',
        'uom'               => 'Boxes',
        'palletized_by'     => 'Ramesh Kumar',
        'palletized_time'   => '09:15 – 09:42 (00:27)',
        'supervisor'        => 'Vijay Nair',
        'remarks'           => 'No damage, all boxes sealed',
    ],
    [
        'pallet_no'         => 'PLT-00001',
        'warehouse_unit_no' => 'WU-0005',
        'room_no'           => 'R-102',
        'dock_no'           => 'D-07',
        'product_code'      => 'FRZ-002',
        'product'           => 'Frozen Squid Rings 1kg',
        'lot'               => 'BCH-25-002',
        'size'              => '1kg',
        'package_type'      => 'Carton',
        'no_of_packages'    => 40,
        'total_gw'          => 500,
        'total_nw'          => 480,
        'expiry_date'       => '2026-03-20',
        'uom'               => 'Boxes',
        'palletized_by'     => 'Ramesh Kumar',
        'palletized_time'   => '09:15 – 09:42 (00:27)',
        'supervisor'        => 'Vijay Nair',
        'remarks'           => 'No damage, all boxes sealed',
    ]
];

// Build QR payload with all items for this pallet
$qrPayload = [
    'pallet_no' => $pallet[0]['pallet_no'],
    'items'     => $pallet
];

$builder = new Builder(
    writer: new PngWriter(),
    data: json_encode($qrPayload),
    size: 150,
    margin: 5
);

$result = $builder->build();
$qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

$first = $pallet[0] ?? [];
@endphp

<!-- Header -->
<table class="print-detail-table">
    <tr>
        <td style="text-align:left;">
            <img src="{{ asset('images/logo.jpeg') }}" style="width:150px;" alt="Company Logo">
        </td>
        <td style="text-align:left;">
            <h3>JOHNSON CHILL PRIVATE LIMITED</h3>
            <p>No.314/1A2, Pala, Kottayam District, Kerala - 602105.</p>
            <p>Contact : 9994218509 | Email: coldstore@johnsonchill.com / johnsonchillstore@gmail.com</p>
            <p>Website: www.johnsonchill.com</p>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="print-page-title"><strong>PALLETIZATION</strong></td>
    </tr>
</table>

<!-- Metadata -->
<table class="print-detail-table">
    <tr>
        <td>
            <strong>Doc No:</strong> PAL-25-00001<br>
            <strong>Doc Date:</strong> 26/08/2025<br>
            <strong>Doc Time:</strong> 09:42<br>
            <strong>Gatepass No.:</strong> GP-1001<br>
            <strong>Packing List No.:</strong> PL-25-00001<br>
            <strong>Vehicle No.:</strong> KL-07-CD-4521<br>
            <strong>Customer:</strong> Ocean Fresh Exports Pvt Ltd
        </td>
        <td>
            <strong>Warehouse Unit:</strong> {{ $first['warehouse_unit_no'] ?? '' }}<br>
            <strong>Dock No:</strong> {{ $first['dock_no'] ?? '' }}<br>
            <strong>Room No:</strong> {{ $first['room_no'] ?? '' }}<br>
            <strong>Pallet No:</strong> {{ $first['pallet_no'] ?? '' }}<br>
            <strong>Qty Per Pallet:</strong> {{ collect($pallet)->sum('no_of_packages') }}<br>
            <strong>Total Weight (KG):</strong> {{ $first['total_gw'] ?? '' }}
        </td>
        <td>
            <strong>Palletized By:</strong> {{ $first['palletized_by'] ?? '' }}<br>
            <strong>Palletized Time:</strong> {{ $first['palletized_time'] ?? '' }}<br>
            <strong>Supervisor:</strong> {{ $first['supervisor'] ?? '' }}<br>
            <strong>Remarks:</strong> {{ $first['remarks'] ?? '' }}
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
            <th>Batch No</th>
            <th>Expiry Date</th>
            <th class="txt-right">Quantity</th>
            <th>UOM</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pallet as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item['product_code'] ?? '' }}</td>
            <td>{{ $item['product'] ?? '' }}</td>
            <td>{{ $item['lot'] ?? '' }}</td>
            <td>{{ $item['expiry_date'] ?? '' }}</td>
            <td class="txt-right">{{ $item['no_of_packages'] ?? '' }}</td>
            <td>{{ $item['uom'] ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="font-weight:bold;">
            <td colspan="5" class="txt-right">Total</td>
            <td class="txt-right">{{ collect($pallet)->sum('no_of_packages') }}</td>
            <td>Boxes</td>
        </tr>
    </tfoot>
</table>

<table class="print-sign-table">
    <tr>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Assigned By:</strong> ___________________________
        </td>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Palletized By:</strong> ___________________________
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
