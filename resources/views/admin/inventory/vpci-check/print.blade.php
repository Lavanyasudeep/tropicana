<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Pre Cooling Inspection Check - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

    <!-- Header -->
    <table class="print-detail-table">
        <tbody>
            <tr>
                <td style="text-align: left;">
                    <img src="{{ asset('images/logo.jpeg') }}" style="width:150px;" alt="Johnson Chill Logo">
                </td>
                <td style="text-align: left;">
                    <h3>JOHNSON CHILL PRIVATE LIMITED</h3>
                    <p>No.314/1A2, Pala, Kottayam District, Kerala - 602105.</p>
                    <p>Contact : 9994218509 | Email: coldstore@johnsonchill.com / johnsonchillstore@gmail.com</p>
                    <p>Website: www.johnsonchill.com</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="print-page-title"><strong>VEHICLE PRE COOLING INSPECTION CHECK</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Details -->
    <table class="print-detail-table">
        <tr>
            <td>
                <strong>Doc No:</strong> VCPI-2025-0829-001<br><br>
                <strong>Doc Date:</strong> 16/10/2023<br><br>
                <strong>Doc Time:</strong> 20:00<br><br>
                <strong>Gate Pass No.:</strong> GP-25-0046<br><br>
                <strong>Customer:</strong> Ocean Fresh Exports Pvt Ltd<br><br>
            </td>
            <td>
                <strong>Vehicle No.:</strong> KL-07-BD-1123<br><br>
                <strong>Transporter Name:</strong> ABC Logistics<br><br>
                <strong>Seal No.:</strong> SEAL-0829-A<br><br>
                <strong>Arrival Time:</strong> 14:45<br><br>
            </td>
            <td>
                <strong>Status:</strong> Created<br><br>
                <strong>Body Condition:</strong> Good<br><br>
                <strong>Insulation Status:</strong> Intact<br><br>
                <strong>Cleanliness:</strong> Clean<br><br>
                <strong>Pre-Cooling Temp (°C):</strong> -16.5<br><br>
                <strong>Required Temp (°C):</strong> -18.0<br><br>
            </td>
        </tr>
    </table>

    <!-- Multiple Checks Table -->
    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th class="txt-center">Time</th>
                <th class="txt-center">Temp (°C)</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>1</td><td class="txt-center">20:00</td><td class="txt-center">-13.6</td></tr>
            <tr><td>2</td><td class="txt-center">20:05</td><td class="txt-center">-14.5</td></tr>
            <tr><td>3</td><td class="txt-center">20:10</td><td class="txt-center">-14.0</td></tr>
        </tbody>
    </table>

    <!-- Temperature Panel -->
    <table class="print-detail-table">
        <tr>
            <td>
                <strong>Temperature Status:</strong> Pass<br><br>
                <strong>Device Used:</strong> Infrared Gun<br><br>
                <strong>Calibration Date:</strong> 2025-07-01<br><br>
            </td>
            <td>
                <strong>Remarks:</strong><br>
                <div style="border:1px solid #CCC; padding:10px; min-height:60px;">
                    Vehicle accepted. Temperature within range.
                </div>
            </td>
        </tr>
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
