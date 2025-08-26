<!DOCTYPE html>
<html>
<head>
    <title>Gatepass‑In - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

<!-- Header -->
<table class="print-detail-table">
    <tbody>
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
            <td colspan="2" class="print-page-title"><strong>GATEPASS‑IN</strong></td>
        </tr>
    </tbody>
</table>

<!-- Details -->
<table class="print-detail-table">
    <tr>
        <td>
            <strong>Doc No. #:</strong> GPI‑25‑00001<br><br>
            <strong>Date:</strong> 25/08/2025<br><br>
            <strong>Time In:</strong> 14:30<br><br>
            <strong>Customer:</strong> Blue Ocean Seafood Traders<br>
            <strong>Pre‑Alert #:</strong> PA‑25‑00001<br>
            <strong>Invoice No #:</strong> INV‑25‑0010<br>
        </td>
        <td>
            <strong>Transporter / STN No.:</strong> STN‑BLUO‑250826<br><br>
            <strong>Vehicle Type:</strong> Open Truck<br><br>
            <strong>Vehicle No.:</strong> KL‑07‑AB‑1234<br><br>
            <strong>Driver Name:</strong> Ramesh Kumar<br><br>
            <strong>Driver Contact:</strong> 9876543210<br><br>
            <strong>Transport Mode:</strong> Refrigerated Truck<br>
            <strong>Vehicle Temperature (°C):</strong> -18.5<br>
        </td>
        <td>
            <strong>Dock In Time:</strong> 09:55<br><br>
            <strong>Dock In Name:</strong> <br><br>
            <strong>Gross Weight (KG):</strong> 1285.40<br><br>
            <strong>Security Name:</strong> S. Nair<br><br>
            <strong>Remarks:</strong> All items verified as per Pre‑Alert<br><br>
            <strong>Total Pre‑Alert:</strong> 813 c/s<br><br>
            <strong>Total Received:</strong> 813 c/s<br>
        </td>
    </tr>
</table>

<!-- Items -->
<table class="print-list-table">
    <thead>
        <tr>
            <th>#</th>
            <th class="txt-left">Item Name</th>
            <th class="txt-left">UOM</th>
            <th class="txt-left">Date</th>
            <th class="txt-center">Pre‑Alert (c/s)</th>
            <th class="txt-center">Received (c/s)</th>
            <th class="txt-left">Remarks</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>1</td><td class="txt-left">Frozen Prawns</td><td class="txt-left">KG</td><td class="txt-left">06/03</td><td class="txt-center">73</td><td class="txt-center">73</td><td class="txt-left">OK</td></tr>
        <tr><td>2</td><td class="txt-left">Frozen Squid Rings</td><td class="txt-left">KG</td><td class="txt-left">23/06</td><td class="txt-center">225</td><td class="txt-center">225</td><td class="txt-left">OK</td></tr>
        <tr><td>3</td><td class="txt-left">Frozen Crab Meat</td><td class="txt-left">KG</td><td class="txt-left">06/10</td><td class="txt-center">267</td><td class="txt-center">267</td><td class="txt-left">OK</td></tr>
        <tr style="font-weight:bold;">
            <td colspan="3"></td>
            <td class="txt-left">Total</td>
            <td class="txt-center">565</td>
            <td class="txt-center">565</td>
            <td class="txt-left"></td>
        </tr>
    </tbody>
</table>

<!-- Signatures -->
<table class="print-sign-table" style="margin-top:40px;">
    <tr>
        <td style="height:80px; vertical-align:bottom;">
            <strong>Security Officer:</strong> ___________________________
        </td>
        <td style="height:80px; vertical-align:bottom;">
            <strong>Warehouse Supervisor:</strong> ___________________________
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
