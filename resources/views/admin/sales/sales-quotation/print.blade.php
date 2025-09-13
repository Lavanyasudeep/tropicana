<!DOCTYPE html>
<html>
<head>
    <title>Sales Quotation - Print</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px;
        }

        h1, h3 {
            margin: 0;
            padding: 0;
        }

        .header-table, .details-table, .items-table, .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header-table td {
            vertical-align: top;
        }

        .header-logo img {
            width: 140px;
        }

        .company-info p {
            margin: 2px 0;
        }

        .page-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 8px 0;
        }

        .details-table td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .items-table th, .items-table td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }

        .items-table th {
            background-color: #f2f2f2;
        }

        .summary-table { width:35%; float:right; }

        .summary-table td {
            padding: 6px 8px;
        }

        .txt-right {
            text-align: right;
        }

        .txt-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body onload="printAndClose()">

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Company Logo">
            </td>
            <td class="company-info">
                @include('common.print-company-address')
            </td>
        </tr>
    </table>

    {{-- Title --}}
    <div class="page-title">Sales Quotation</div>

    {{-- Quotation Info --}}
    <table class="details-table">
        <tr>
            <td width="33%">
                <strong>Doc. #:</strong> {{ $quotation->doc_no }}<br>
                <strong>Doc. Date:</strong> {{ $quotation->doc_date }}<br>
                <strong>Status:</strong> {{ ucfirst($quotation->status) }}
            </td>
            <td width="33%">
                <strong>Customer Name:</strong> {{ optional($quotation->customer)->customer_name }}<br>
                <strong>Contact No.:</strong> {{ $quotation->quotation?->phone_number }}<br>
                <strong>Address:</strong> {{ $quotation->quotation?->main_address }}
            </td>
            <td width="33%">
                <strong>Remarks:</strong><br />{{ $quotation->remarks }}
            </td>
        </tr>
    </table>

    {{-- Quotation Items --}}
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:3%;" class="txt-center" >#</th>
                <th style="width:10%;" class="txt-left" >Item Type</th>
                <th style="width:20%;" class="txt-left" >Description</th>
                <th style="width:8%;" class="txt-left" >Unit</th>
                <th style="width:8%;" class="txt-center" >Unit Qty</th>
                <th style="width:8%;" class="txt-right" >Rate</th>
                <th style="width:5%;" class="txt-center" >Qty</th>
                <th style="width:8%;" class="txt-right" >Value</th>
                <th style="width:5%;" class="txt-right" >Tax %</th>
                <th style="width:8%;" class="txt-right" >Tax Value</th>
                <th style="width:8%;" class="txt-right" >Net Value</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tot_pallet_qty = 0;
                $tot_rate = 0;
                $tot_value = 0;
                $tot_tax_value = 0;
                $tot_net_value = 0;
            @endphp
            @foreach ($quotation->quotationDetails as $v)
            <tr>
                <td class="txt-center" >{{ $loop->iteration }}</td>
                <td class="txt-left" >{{ $v->productType->type_name }}</td>
                <td class="txt-left" >{{ $v->product->product_description }}</td>
                <td class="txt-left" >{{ $v->unit->unit }}</td>
                <td class="txt-center" >{{ $v->unit_qty }}</td>
                <td class="txt-right" >{{ number_format($v->rate, 2) }}</td>
                <td class="txt-center" >{{ $v->pallet_qty }}</td>
                <td class="txt-right" >{{ number_format($v->value, 2) }}</td>
                <td class="txt-right" >{{ $v->tax_per }}%</td>
                <td class="txt-right" >{{ number_format($v->tax_value, 2) }}</td>
                <td class="txt-right" >{{ number_format($v->net_value, 2) }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="10" class="txt-left">{!! nl2br($v->description) !!}</td>
            </tr>
            @php
                $tot_pallet_qty += $v->pallet_qty;
                $tot_rate += $v->rate;
                $tot_value += $v->value;
                $tot_tax_value += $v->tax_value;
                $tot_net_value += $v->net_value;
            @endphp
            @endforeach
            <tr class="bold">
                <td colspan="5">Total</td>
                <td class="txt-right">{{ number_format($tot_rate, 2) }}</td>
                <td class="txt-center">{{ $tot_pallet_qty }}</td>
                <td class="txt-right">{{ number_format($tot_value, 2) }}</td>
                <td></td>
                <td class="txt-right">{{ number_format($tot_tax_value, 2) }}</td>
                <td class="txt-right">{{ number_format($tot_net_value, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Summary --}}
    <table class="summary-table">
        <tr>
            <td><strong>Total Amount:</strong></td>
            <td class="txt-right">{{ number_format($quotation->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>CGST:</strong></td>
            <td class="txt-right">{{ number_format($quotation->cgst_amount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>SGST:</strong></td>
            <td class="txt-right">{{ number_format($quotation->sgst_amount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>IGST:</strong></td>
            <td class="txt-right">{{ number_format($quotation->igst_amount, 2) }}</td>
        </tr>
        <tr class="bold" style="border-top:1px solid #000;" >
            <td><strong>Grand Total:</strong></td>
            <td class="txt-right">{{ number_format($quotation->grand_amount, 2) }}</td>
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
