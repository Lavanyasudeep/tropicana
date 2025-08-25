<!DOCTYPE html>
<html>
<head>
    <title>Gate Pass - Print</title>
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
                <td colspan="2" class="print-page-title" ><strong>GATE PASS</strong></td>
            </tr>
        </tbody>
    </table>

    <table class="print-detail-table">
        <tr>
            <td>
                <strong>Doc. #:</strong> {{ $gatepass->doc_no }}<br><br>
                <strong>Doc. Date:</strong> {{ $gatepass->doc_date }}<br><br>
                <strong>Status:</strong> {{ $gatepass->status }}<br><br>
                <strong>Client:</strong> {{ $gatepass->client->client_name }}<br><br>
            </td>
            <td>
                <strong>Contact:</strong> {{ $gatepass->contact_name }}<br><br>
                <strong>Address:</strong> {{ $gatepass->contact_address }}<br><br>
                <strong>Remarks:</strong> {{ $gatepass->remarks }}<br><br>
            </td>
            <td>
                <strong>Movement Type:</strong> {{ $gatepass->movement_type }}<br><br>
                <strong>Vehicle No:</strong> {{ $gatepass->vehicle_no }}<br><br>
                <strong>Driver:</strong> {{ $gatepass->driver_name }}<br><br>
                <strong>Transport Mode:</strong> {{ $gatepass->transport_mode }}<br><br>
            </td>
        </tr>
    </table>

    <table class="print-list-table">
        <thead>
            <tr>
                <th>#</th>
                <th class="txt-left" >Item Name</th>
                <th class="txt-left" >UOM</th>
                <th class="txt-center" >Qty</th>
                <th class="txt-center" >Returnable?</th>
                <th class="txt-center" >Expected Return Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gatepass->gatePassDetails as $k => $v)
                <tr>
                    <td>{{ $k + 1 }}</td>
                    <td class="txt-left">{{ $v->item_name }}</td>
                    <td class="txt-left">{{ $v->uom }}</td>
                    <td class="txt-center">{{ $v->quantity }}</td>
                    <td class="txt-center">{{ $v->is_returnable? 'Yes':'No' }}</td>
                    <td class="txt-center">{{ $v->expected_return_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <table class="print-sign-table">
        <tr>
            <td style="height: 60px; vertical-align: bottom;">
                <br /><br /><br />
                <strong>Verified By:</strong> ___________________________
            </td>
            <td style="height: 60px; vertical-align: bottom;">
                <br /><br /><br />
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
