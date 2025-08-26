<!DOCTYPE html>
<html>
<head>
    <title>Packing List - Print</title>
     <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

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
            <td colspan="2" class="print-page-title" ><strong>PACKING LIST</strong></td>
        </tr>
    </tbody>
</table>

<table class="print-detail-table">
    <tr>
        <td>
            <strong>Doc. #:</strong> PL‑25‑00012<br><br>
            <strong>Doc. Date:</strong> 26/08/2025<br><br>
            <strong>Gate Pass No.:</strong> GP-25-0045<br><br>
            <strong>Invoice No.:</strong> INV-25-0010<br>
        </td>

        <!-- Column 2 -->
        <td>
            <strong>Status:</strong> Created<br><br>
            <strong>Customer Name:</strong> Ocean Fresh Exports Pvt Ltd<br><br>
            <strong>Contact Number:</strong> +91 98470 12345<br><br>
            <strong>Address:</strong> Plot No. 45, Seafood Industrial Estate, Aroor, Kerala, India<br>
        </td>

        <!-- Column 3 -->
        <td>
            <strong>Vehicle No.:</strong> KL-07-CD-4521<br><br>
            <strong>Container No.:</strong> CONT-SEA-00987<br><br>
            <strong>Port of Loading:</strong> Cochin Port<br><br>
            <strong>Port of Discharge:</strong> Port of Rotterdam<br><br>
        </td>
    </tr>
</table>

<table class="print-list-table">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>UOM</th>
            <th>Quantity</th>
            <th>Net Weight (KG)</th>
            <th>Gross Weight (KG)</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Frozen Prawns</td>
            <td>KG</td>
            <td class="text-right">500</td>
            <td class="text-right">500.00</td>
            <td class="text-right">520.00</td>
            <td>Packed in 20kg cartons</td>
        </tr>
        <tr>
            <td>Frozen Squid Rings</td>
            <td>KG</td>
            <td class="text-right">300</td>
            <td class="text-right">300.00</td>
            <td class="text-right">315.00</td>
            <td>Packed in 15kg cartons</td>
        </tr>
        <tr>
            <td>Frozen Crab Meat</td>
            <td>KG</td>
            <td class="text-right">200</td>
            <td class="text-right">200.00</td>
            <td class="text-right">210.00</td>
            <td>Packed in 10kg cartons</td>
        </tr>
        <tr style="font-weight: bold;">
            <td colspan="2" class="text-right">Total</td>
            <td class="text-right">1000</td>
            <td class="text-right">{{ number_format(1000, 2) }}</td>
            <td class="text-right">{{ number_format(1045, 2) }}</td>
            <td></td>
        </tr>
    </tbody>
</table>

<table class="print-sign-table">
    <tr>
        <td style="height: 60px; vertical-align: bottom;">
            <strong>Assigned By:</strong> ___________________________
        </td>
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
