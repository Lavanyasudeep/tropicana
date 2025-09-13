<!DOCTYPE html>
<html>
<head>
    <title>Temperature Check - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

    <!-- Header -->
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
                <td colspan="2" class="print-page-title" ><strong>TEMPERATURE CHECK</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Details -->
    <table class="print-detail-table">
        <tr>
            <td>
                <strong>Doc No:</strong> TC-25-0001<br><br>
                <strong>Doc Date:</strong> 16/10/2023<br><br>
                <strong>Doc Time:</strong> 20:00<br><br>
                <strong>Gate Pass No.:</strong> GP-25-0045<br><br>
                <strong>Customer:</strong> Chelur Foods<br><br>
            </td>
            <td>
                <strong>Vehicle No.:</strong> HR 55 R 0057<br><br>
                <strong>Product:</strong> Frozen Peas 5kg<br><br>
                <strong>SKU:</strong> 150<br><br>
                <strong>Vehicle Set Temp (°C):</strong> 2<br><br>
            </td>
            <td>
                <strong>Status:</strong> Created<br><br>
                <strong>Remarks:</strong> OK<br><br>
                <strong>Received By:</strong> Tropicana<br><br>
                <strong>Checked By:</strong> John Smith<br><br>
            </td>
        </tr>
    </table>

    <!-- Multiple Checks Table -->
    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th class="txt-left">Product #</th>
                <th class="txt-center">Time</th>
                <th class="txt-center">Product Temp (°C)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="txt-left">Frozen Peas 5kg</td>
                <td class="txt-center">20:00</td>
                <td class="txt-center">-1.6</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="txt-left">Mixed Veg 1kg</td>
                <td class="txt-center">20:05</td>
                <td class="txt-center">-1.6</td>
            </tr>
            <tr>
                <td>3</td>
                <td class="txt-left">Paneer Blocks 5kg</td>
                <td class="txt-center">20:10</td>
                <td class="txt-center">-1.5</td>
            </tr>
        </tbody>
    </table>

    <!-- Signatures -->
    <table class="print-sign-table" style="margin-top: 40px;">
        <tr>
            <td style="height: 80px; vertical-align: bottom;">
                <strong>Driver Signature:</strong> ___________________________
            </td>
            <td style="height: 80px; vertical-align: bottom;">
                <strong>Operational Supervisor:</strong> ___________________________
            </td>
            <td style="height: 80px; vertical-align: bottom;">
                <strong>Technical Supervisor:</strong> ___________________________
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
