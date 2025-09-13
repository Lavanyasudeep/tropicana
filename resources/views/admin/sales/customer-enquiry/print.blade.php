<!DOCTYPE html>
<html>
<head>
    <title>Customer Enquiry - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body onload="printAndClose()">

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
                <td colspan="2" class="print-page-title" ><strong>CUSTOMER ENQUIRY</strong></td>
            </tr>
        </tbody>
    </table>

    <table class="print-detail-table">
        <tr>
            <td>
                <label>Doc. #</label>: {{ $enquiry->doc_no }}<br><br>
                <label>Doc. Date</label>: {{ $enquiry->doc_date }}<br><br>
                <label>Status</label>: {{ $enquiry->status }}<br><br>
            </td>
            <td>
                <label>Customer Name</label>: {{ $enquiry->customer->customer_name }}<br><br>
                <label>Mobile No.</label>: {{ $enquiry->customer->phone_number }}<br><br>
                <label>Address</label>: {{ $enquiry->customer?->main_address }}<br><br>
            </td>
            <td>
                <label>Service Type</label>: {{ ucwords(str_replace(',',', ',$enquiry->service_type)) }}<br><br>
                <label>Item Type</label>: {{ ucwords(str_replace(',',', ',$enquiry->item_type)) }}<br><br>
            </td>
        </tr>
    </table>

    <table class="print-detail-table">
        <tr>
            <td><label>Description:</label></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $enquiry->description }}</td>
        </tr>
        <tr>
            <td><br /><br /><label>Remarks:</label></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $enquiry->remarks }}</td>
        </tr>
    </table>

    <style type="text/css" >
        .print-detail-table { }
        .print-detail-table tr td label { width:120px; font-weight:bold; display:inline-block; }
    </style>

    <script>
        function printAndClose() {
            window.print();
            setTimeout(() => window.close(), 1000);
        }
    </script>

</body>
</html>