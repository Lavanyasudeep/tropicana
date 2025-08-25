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
                    <h3>JOHNSON CHILL PRIVATE LIMITED</h3>
                    <p>No.314/1A2, Pala, Kottayam District, Kerala - 602105.</p>
                    <p>Contact : 9994218509 | Email: coldstore@johnsonchill.com / johnsonchillstore@gmail.com</p>
                    <p>Website: www.johnsonchill.com</p>
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
                <strong>Date:</strong> 16/10/2023<br><br>
                <strong>Time:</strong> 20:00<br><br>
                <strong>Gate Pass No.:</strong> 7508<br><br>
                <strong>Customer:</strong> TRDP<br><br>
            </td>
            <td>
                <strong>Vehicle No.:</strong> HR 55 R 0057<br><br>
                <strong>Product:</strong> Tropicana<br><br>
                <strong>SKU:</strong> 1L PET<br><br>
                <strong>Vehicle Set Temp (°C):</strong> 2<br><br>
            </td>
            <td>
                <strong>Remarks:</strong> OK<br><br>
                <strong>Received By:</strong> Tropicana<br><br>
            </td>
        </tr>
    </table>

    <!-- Multiple Checks Table -->
    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th class="txt-center">Time</th>
                <th class="txt-center">Product Temp (°C)</th>
                <th class="txt-left">Name</th>
                <th class="txt-left">Driver</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="txt-center">20:00</td>
                <td class="txt-center">-1.6</td>
                <td class="txt-left">Jatin</td>
                <td class="txt-left">Driver A</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="txt-center">20:05</td>
                <td class="txt-center">-1.6</td>
                <td class="txt-left">Operational Supervisor</td>
                <td class="txt-left">Driver A</td>
            </tr>
            <tr>
                <td>3</td>
                <td class="txt-center">20:10</td>
                <td class="txt-center">-1.5</td>
                <td class="txt-left">Technical Supervisor</td>
                <td class="txt-left">Driver A</td>
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
