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
                <h3>JOHNSON CHILL PRIVATE LIMITED</h3>
                <p>No.314/1A2, Pala, Kottayam District, Kerala - 602105.</p>
                <p>Contact : 9994218509 | Email: coldstore@johnsonchill.com / johnsonchillstore@gmail.com</p>
                <p>Website: www.johnsonchill.com</p>
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
            <strong>Quotation #:</strong> SQ‑25‑00045<br><br>
            <strong>Client:</strong> ABC Cold Storage Ltd.<br>
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
            <strong>Transport Mode:</strong> Refrigerated Truck<br><br>
            <strong>Gatepass #:</strong> GP‑25‑00012<br>
        </td>
        <td>
            <strong>Security Verified By:</strong> S. Nair<br><br>
            <strong>Supervisor Verified By:</strong> M. Thomas<br><br>
            <strong>Driver Contact:</strong> 9876543210<br><br>
            <strong>Temperature Check:</strong> Passed<br>
        </td>
    </tr>
</table>

<!-- Items Table -->
<table class="print-list-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>UOM</th>
            <th>Qty</th>
            <th>Batch No.</th>
            <th>Cold Storage Location</th>
            <th>Temperature (°C)</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Frozen Prawns</td>
            <td>KG</td>
            <td>500</td>
            <td>BATCH‑PR‑001</td>
            <td>Cold Room A1</td>
            <td>-18</td>
            <td>OK</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Frozen Green Peas</td>
            <td>KG</td>
            <td>300</td>
            <td>BATCH‑GP‑002</td>
            <td>Cold Room B2</td>
            <td>-20</td>
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
<table class="print-sign-table" style="margin-top: 40px;">
    <tr>
        <td style="height: 80px; vertical-align: bottom;">
            <strong>Security Signature:</strong> ___________________________
        </td>
        <td style="height: 80px; vertical-align: bottom;">
            <strong>Supervisor Signature:</strong> ___________________________
        </td>
        <td style="height: 80px; vertical-align: bottom;">
            <strong>Driver Signature:</strong> ___________________________
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
