<!DOCTYPE html>
<html>
<head>
    <title>Palletization - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

    {{-- Header --}}
    <table class="print-detail-table">
        <tbody>
            <tr>
                <td style="text-align: left;">
                    <img src="{{ asset('images/logo.jpeg') }}" style="width:150px;" alt="Company Logo">
                </td>
                <td style="text-align: left;">
                    @include('common.print-company-address')
                </td>
            </tr>
            <tr>
                <td colspan="2" class="print-page-title"><strong>PALLETIZATION SUMMARY</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Shipment Details --}}
    @php
    // Dummy pallet-wise data
    $pallets = [
        'P-1-1' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-2' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-3' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-4' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-5' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-6' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-7' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-8' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-9' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-1-10' => [
            ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
        ],
        'P-2-1' => [
            ['product' => 'GREEN EMERALD LARGE', 'lot' => 'LOT010', 'size' => '500ml', 'weight_per_unit' => '0.55', 'package_type' => 'Crate', 'no_of_packages' => 200, 'gw_per_package' => '6.6', 'nw_per_package' => '6', 'total_gw' => '264', 'total_nw' => '240'],
        ],
        'P-2-2' => [
            ['product' => 'GREEN EMERALD LARGE', 'lot' => 'LOT010', 'size' => '500ml', 'weight_per_unit' => '0.55', 'package_type' => 'Crate', 'no_of_packages' => 200, 'gw_per_package' => '6.6', 'nw_per_package' => '6', 'total_gw' => '264', 'total_nw' => '240'],
        ],
        'P-2-3' => [
            ['product' => 'GREEN EMERALD LARGE', 'lot' => 'LOT010', 'size' => '500ml', 'weight_per_unit' => '0.55', 'package_type' => 'Crate', 'no_of_packages' => 200, 'gw_per_package' => '6.6', 'nw_per_package' => '6', 'total_gw' => '264', 'total_nw' => '240'],
        ],
        'P-2-4' => [
            ['product' => 'GREEN EMERALD LARGE', 'lot' => 'LOT010', 'size' => '500ml', 'weight_per_unit' => '0.55', 'package_type' => 'Crate', 'no_of_packages' => 200, 'gw_per_package' => '6.6', 'nw_per_package' => '6', 'total_gw' => '264', 'total_nw' => '240'],
        ],
    ];
    @endphp

    <table class="header-table">
        <tr>
            <td><strong>DO No.:</strong> PAL-25-00001</td>
            <td><strong>Date:</strong> 2023-04-25</td>
            <td><strong>Packing List No.:</strong> PL-25-00001</td>
        </tr>
        <tr>
            <td><strong>Sales Order No.:</strong> SO-25-00001</td>
            <td><strong>GRN No.:</strong> GR-1001</td>
            <td><strong>Vehicle No.:</strong> KL-07-AB-1345</td>
        </tr>
        <tr>
            <td><strong>Client:</strong> ABC Foods Ltd</td>
            <td><strong>Supplier:</strong> LMN Group</td>
            <td><strong>Warehouse Unit:</strong> 3</td>
        </tr>
        <tr>
            <td><strong>Empty Pallet Weight:</strong> 28</td>
            <td><strong>Total Pallets:</strong> {{ count($pallets ?? []) }}</td>
            <td><strong>Total Packages:</strong> {{ collect($pallets)->flatten(1)->sum('no_of_packages') }}</td>
        </tr>
    </table>

    {{-- Pallet Table --}}
    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Pallet No.</th>
                <th>QR Code</th>
                <th>Product</th>
                <th>Lot</th>
                <th>Size</th>
                <th>Weight/Unit</th>
                <th>Package Type</th>
                <th>No. of Packages</th>
                <th>G.W./Pkg</th>
                <th>N.W./Pkg</th>
                <th>Total G.W.</th>
                <th>Total N.W.</th>
            </tr>
        </thead>
        <tbody>
            @php
                use Endroid\QrCode\Builder\Builder;
                use Endroid\QrCode\Writer\PngWriter;
                $tot_packages = $tot_gw = $tot_nw = 0;

            @endphp
            @foreach ($pallets as $index => $items)
                @php
                    $first = $items[0];
                    $qrData = "Pallet: {$index}\nProduct: {$first['product']}\nLot: {$first['lot']}\nSize: {$first['size']}\nPackage Type: {$first['package_type']}\nNo. of Packages: {$first['no_of_packages']}\nTotal G.W.: {$first['total_gw']}\nTotal N.W.: {$first['total_nw']}";
                    $builder = new Builder(
                        writer: new PngWriter(),
                        data: $qrData,
                        size: 100,
                        margin: 2
                    );
                    $result = $builder->build();
                    $qrBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

                    $tot_packages += $first['no_of_packages'];
                    $tot_gw += $first['total_gw'];
                    $tot_nw += $first['total_nw'];
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $index }}</td>
                    <td><img src="{{ $qrBase64 }}" style="width:80px;height:80px;"></td>
                    <td>{{ $first['product'] }}</td>
                    <td>{{ $first['lot'] }}</td>
                    <td>{{ $first['size'] }}</td>
                    <td>{{ $first['weight_per_unit'] }}</td>
                    <td>{{ $first['package_type'] }}</td>
                    <td>{{ $first['no_of_packages'] }}</td>
                    <td>{{ $first['gw_per_package'] }}</td>
                    <td>{{ $first['nw_per_package'] }}</td>
                    <td>{{ $first['total_gw'] }}</td>
                    <td>{{ $first['total_nw'] }}</td>
                </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td colspan="8">Total</td>
                <td>{{ $tot_packages }}</td>
                <td colspan="2"></td>
                <td>{{ $tot_gw }}</td>
                <td>{{ $tot_nw }}</td>
            </tr>
        </tbody>
    </table>

     {{-- Summary table (same as Inward) --}}
    <table class="print-summary-table">
        <tr><td><strong>Weight of 1 empty pallet:</strong></td><td class="txt-right">28</td></tr>
        <tr><td><strong>Total No of Pallets:</strong></td><td class="txt-right">{{ count($pallets ?? []) }}</td></tr>
        <tr><td><strong>Total No of Packages:</strong></td><td class="txt-right">{{ $tot_packages }}</td></tr>
        <tr><td><strong>Total G.W.:</strong></td><td class="txt-right">{{ $tot_gw }}</td></tr>
        <tr><td><strong>Total N.W.:</strong></td><td class="txt-right">{{ $tot_nw }}</td></tr>
    </table>

    {{-- Signature table (same as Inward) --}}
    <table class="print-sign-table">
        <tr>
            <td style="height: 60px; vertical-align: bottom;"><strong>Prepared By:</strong> ___________________________</td>
            <td style="height: 60px; vertical-align: bottom;"><strong>Checked By:</strong> ___________________________</td>
            <td style="height: 60px; vertical-align: bottom;"><strong>Approved By:</strong> ___________________________</td>
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
