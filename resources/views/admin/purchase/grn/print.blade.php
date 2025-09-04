<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>GRN - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        @media print {
            body { font-family: Arial, sans-serif; font-size: 12px; }
            .print-detail-table, .print-list-table, .print-sign-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }
            .print-detail-table td,
            .print-list-table th,
            .print-list-table td,
            .print-sign-table td {
                border: 1px solid #000;
                padding: 4px;
                vertical-align: top;
            }
            .print-list-table th {
                background: #f2f2f2;
            }
            .txt-right { text-align: right; }
            .badge { border: 1px solid #000; background: none; color: #000; padding: 2px 4px; }
        }
    </style>
</head>
<body onload="printAndClose()">

@php
$products = [
    ['product'=>'RED JOANPRINCE SMALL','lot'=>'LOT001','no_of_packages'=>100,'package_type'=>'Carton','total_gw'=>'525','total_nw'=>'500','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'GREEN EMERALD LARGE','lot'=>'LOT010','no_of_packages'=>200,'package_type'=>'Crate','total_gw'=>'264','total_nw'=>'240','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'BLUE OCEAN MEDIUM','lot'=>'LOT015','no_of_packages'=>150,'package_type'=>'Sack','total_gw'=>'180','total_nw'=>'150','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'YELLOW SUNBURST XL','lot'=>'LOT020','no_of_packages'=>80,'package_type'=>'Carton','total_gw'=>'400','total_nw'=>'380','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'ORANGE BLAZE SMALL','lot'=>'LOT025','no_of_packages'=>100,'package_type'=>'Crate','total_gw'=>'260','total_nw'=>'250','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'PURPLE REGALIA','lot'=>'LOT030','no_of_packages'=>140,'package_type'=>'Carton','total_gw'=>'420','total_nw'=>'400','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'WHITE CRYSTAL LARGE','lot'=>'LOT035','no_of_packages'=>60,'package_type'=>'Bag','total_gw'=>'120','total_nw'=>'115','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'BLACK DIAMOND MEDIUM','lot'=>'LOT040','no_of_packages'=>90,'package_type'=>'Crate','total_gw'=>'220','total_nw'=>'210','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'SILVER MIST SMALL','lot'=>'LOT045','no_of_packages'=>110,'package_type'=>'Carton','total_gw'=>'330','total_nw'=>'320','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
    ['product'=>'GOLDEN PEARL XL','lot'=>'LOT050','no_of_packages'=>130,'package_type'=>'Crate','total_gw'=>'390','total_nw'=>'375','man_date'=>'02/09/2025','exp_date'=>'02/09/2026'],
];
@endphp

<!-- Header -->
<table class="print-detail-table">
    <tr>
        <td style="text-align:left; width: 150px;">
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
        <td colspan="2" style="text-align:center; font-weight:bold;">
            GOODS RECEIPT NOTE (GRN)
        </td>
    </tr>
</table>

<!-- Metadata -->
<table class="print-detail-table">
    <tr>
        <td>
            <strong>Doc No:</strong> GRN-25-00001<br>
            <strong>Doc Date:</strong> 25/08/2025<br>
            <strong>Invoice No:</strong> INV-250100<br>
            <strong>Customer Order No:</strong> ORD-90876<br>
            <strong>Status:</strong> <span class="badge">Completed</span>
        </td>
        <td>
            <strong>Customer:</strong> ABC Foods Ltd<br>
            <strong>Packing List No:</strong> PKG-25-00005<br>
            <strong>Gate Pass No:</strong> GP-1001<br>
            <strong>Vehicle No:</strong> KL-07-AB-1234<br>
            <strong>Vehicle Temp:</strong> -18°C (OK)
        </td>
        <td>
            <strong>Warehouse Unit:</strong> WU-0028<br>
            <strong>Dock No:</strong> D-12<br>
            <strong>Dock In Time:</strong> 12:00<br>
            <strong>Total Pallets:</strong> 8<br>
            <strong>Remarks:</strong> All items passed QC inspection
        </td>
    </tr>
</table>

<!-- Products Table -->
<table class="print-list-table">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Product</th>
            <th>Lot</th>
            <th class="txt-right">Qty</th>
            <th>UOM</th>
            <th class="txt-right">Total G.W.</th>
            <th class="txt-right">Total N.W.</th>
            <th>Manufacturing Date</th>
            <th>Expiry Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item['product'] }}</td>
            <td>{{ $item['lot'] }}</td>
            <td class="txt-right">{{ $item['no_of_packages'] }}</td>
            <td>{{ $item['package_type'] }}</td>
            <td class="txt-right">{{ $item['total_gw'] }}</td>
            <td class="txt-right">{{ $item['total_nw'] }}</td>
            <td>{{ $item['man_date'] }}</td>
            <td>{{ $item['exp_date'] }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="font-weight:bold;">
            <td colspan="3" class="txt-right">Total</td>
            <td class="txt-right">{{ collect($products)->sum('no_of_packages') }}</td>
            <td>Units</td>
            <td class="txt-right">{{ collect($products)->sum('total_gw') }}</td>
            <td class="txt-right">{{ collect($products)->sum('total_nw') }}</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>

<!-- Sign-off -->
<table class="print-sign-table">
    <tr>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Received By:</strong> ___________________________
        </td>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Checked By:</strong> ___________________________
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
