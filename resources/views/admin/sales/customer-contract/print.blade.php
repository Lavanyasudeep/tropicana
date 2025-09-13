<!DOCTYPE html>
<html>
<head>
    <title>Customer Contract - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()" style="padding: 0; margin:0;">

    <!-- Header -->
    <table class="print-detail-table">
        <tbody>
            <tr>
                <td style="text-align: left;">
                    <img src="{{ asset('images/logo.jpeg') }}" style="width:150px;" alt="Johnson Chill Logo">
                </td>
                <td style="text-align: left;">
                    @include('common.print-company-address')
                </td>
            </tr>
            <tr>
                <td colspan="2" class="print-page-title"><strong>CUSTOMER CONTRACT</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Contract Details -->
    <table class="print-detail-table">
        <tr>
            <td>
                <strong>Contract No:</strong> CT‑25‑00001<br><br>
                <strong>Start Date:</strong> 02/09/2025<br><br>
                <strong>End Date:</strong> 01/09/2026<br><br>
                <strong>Billing Cycle:</strong> Monthly<br><br>
                <strong>Billing Method:</strong> Per Pallet/Day
            </td>
            <td>
                <strong>Customer Name:</strong> Chelur Foods Pvt Ltd<br><br>
                <strong>Contact Number:</strong> +91 98765 43210<br><br>
                <strong>Contact Email:</strong> contracts@chelurfoods.in<br><br>
                <strong>Contract Type:</strong> Frozen Storage Agreement
            </td>
            <td>
                <strong>Temperature Variance Charge:</strong> ₹150/pallet<br><br>
                <strong>Power Out Escalation:</strong> Yes<br><br>
                <strong>Tariff Hike Escalation:</strong> Yes<br><br>
                <strong>Security Deposit:</strong> ₹50,000
            </td>
        </tr>
    </table>

    <!-- Product Items -->
    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th class="txt-left">Product Description</th>
                <th class="txt-center">Min. Guarantee (Pallets)</th>
                <th class="txt-center">Temperature</th>
                <th class="txt-center">Storage Charge</th>
                <th class="txt-center">Handling Charge</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="txt-left">Frozen Prawns 5kg</td>
                <td class="txt-center">50</td>
                <td class="txt-center">-18°C</td>
                <td class="txt-center">₹25/pallet/day</td>
                <td class="txt-center">₹10/pallet</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="txt-left">Paneer Blocks 10kg</td>
                <td class="txt-center">30</td>
                <td class="txt-center">-4°C</td>
                <td class="txt-center">₹20/pallet/day</td>
                <td class="txt-center">₹8/pallet</td>
            </tr>
            <tr>
                <td>3</td>
                <td class="txt-left">Frozen Momos 2kg</td>
                <td class="txt-center">20</td>
                <td class="txt-center">-18°C</td>
                <td class="txt-center">₹22/pallet/day</td>
                <td class="txt-center">₹9/pallet</td>
            </tr>
        </tbody>
    </table>

    <!-- Remarks -->
    <table class="print-detail-table">
        <tr>
            <td colspan="3">
                <strong>Remarks:</strong><br>
                Contract includes refrigerated vehicle docking, real-time temperature monitoring, and escalation clauses for power outages and tariff hikes. All deviations beyond ±2°C will incur variance charges. Subject to annual review.
            </td>
        </tr>
    </table>

    <table class="print-detail-table" style="margin-top: 20px;">
        <thead>
            <tr>
            <th colspan="2" style="text-align: left; background-color: #f2f2f2;">Power & Temperature Surcharge Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td style="width: 50%; vertical-align: top;">
                <strong>Power Tariff Hike Adjustment</strong><br>
                In case of government-notified power tariff hikes, an additional charge of ₹2.50 per kWh will be levied on top of the base rate. This adjustment will be reflected in the monthly invoice.
            </td>
            <td style="width: 50%; vertical-align: top;">
                <strong>Power Outage Backup Charge</strong><br>
                During power cuts, generator backup usage will incur a surcharge of ₹500/hour. This ensures uninterrupted temperature control and product safety.
            </td>
            </tr>
            <tr>
            <td colspan="2" style="vertical-align: top;">
                <strong>Temperature Variance Penalty</strong><br>
                If internal chamber temperature deviates beyond ±2°C from the agreed setpoint for more than 30 consecutive minutes, a penalty of ₹1,000 per incident will be applied. This ensures compliance with cold chain integrity.
            </td>
            </tr>
        </tbody>
        </table>

    <!-- Signatures -->
    <table class="print-sign-table">
        <tr>
            <td style="height: 60px; vertical-align: bottom;">
                <br /><br /><br />
                <strong>Authorized Signatory (Customer):</strong> ___________________________
            </td>
            <td style="height: 60px; vertical-align: bottom;">
                <br /><br /><br />
                <strong>Authorized Signatory (Warehouse):</strong> ___________________________
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
