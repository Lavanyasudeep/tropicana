<!DOCTYPE html>
<html>
<head>
    <title>Pre‑Alert - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

<!-- Company Header -->
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
            <td colspan="2" class="print-page-title"><strong>PRE‑ALERT</strong></td>
        </tr>
    </tbody>
</table>

<!-- Document Meta -->
<table class="print-detail-table">
    <tr>
        <td>
            <strong>Doc. #:</strong> PA‑25‑00001<br><br>
            <strong>Doc. Date:</strong> 25/08/2025<br><br>
            <strong>Arriving. Date:</strong> 25/10/2025<br><br>
            <strong>Ref No. #:</strong> SQ‑25‑00045<br><br>
            <strong>Customer:</strong> Australian Foods India Pvt. Ltd.<br>
        </td>
        <td>
            <strong>Status:</strong> Created<br><br>
            <strong>Contact Name:</strong> John Mathew<br><br>
            <strong>Contact Address:</strong> Warehouse Road, Kochi<br><br>
            <strong>Remarks:</strong> Handle with care — perishable goods<br>
        </td>
        <td>
            <strong>Vehicle No.:</strong> KL‑07‑AB‑1234<br><br>
            <strong>Driver Name:</strong> Ramesh Kumar<br><br>
        </td>
    </tr>
</table>

<!-- Items Table -->
<table class="print-list-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Batch No.</th>
            <th>Qty</th>
            <th>UOM</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Frozen Peas 5kg</td>
            <td>BATCH‑PR‑001</td>
            <td>500</td>
            <td>Boxes</td>
            <td>OK</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Mixed Veg 1kg</td>
            <td>BATCH‑GP‑002</td>
            <td>300</td>
            <td>Crates</td>
            <td>OK</td>
        </tr>
        <tr style="font-weight: bold;">
            <td></td>
            <td colspan="2">Total</td>
            <td>800</td>
            <td colspan="4"></td>
        </tr>
    </tbody>
</table>

<!-- Signature Section -->
<table class="print-sign-table">
    <tr>
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
