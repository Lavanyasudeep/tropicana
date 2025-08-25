<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Voucher</title>
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 30px;
    }

    .voucher {
      background: #fff;
      max-width: 800px;
      margin: auto;
      border: 1px solid #ccc;
      padding: 30px 40px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
      text-align: center;
      border-bottom: 2px solid #1a5f76;
      padding-bottom: 10px;
      margin-bottom: 30px;
    }

    .header h1 {
      margin: 0;
      font-size: 28px;
      color: #1a5f76;
    }

    .company-info {
      font-size: 14px;
      color: #555;
    }

    .section {
      margin-bottom: 25px;
    }

    .section-title {
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
      border-bottom: 1px solid #eee;
      padding-bottom: 5px;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
    }

    .info-table td {
      padding: 8px 6px;
      vertical-align: top;
    }

    .info-table td.label {
      font-weight: 600;
      width: 180px;
      color: #333;
    }

    .amount {
      font-size: 20px;
      font-weight: bold;
      color: #000;
    }

    .footer {
      font-size: 12px;
      color: #999;
      text-align: center;
      margin-top: 40px;
      border-top: 1px solid #ccc;
      padding-top: 10px;
    }

    .signature-block {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
      text-align: center;
    }

    .signature {
      width: 30%;
    }

    .signature .line {
      border-top: 1px solid #000;
      margin-top: 50px;
    }
  </style>
</head>
<body onload="printAndClose()" >

<div class="voucher">
  <div class="header">
    <h1>PAYMENT VOUCHER</h1>
    <div class="company-info">
      <strong>JOHNSON CHILL PRIVATE LIMITED</strong><br>
      No.314/1A2, Pala, Kottayam District, Kerala - 602105.<br>
      GSTIN: 32XXXXXXXXX6Z5
    </div>
  </div>

  <div class="section">
    <table class="info-table">
      <tr>
        <td class="label">Voucher No.</td>
        <td>: {{$payment->doc_no}}</td>
        <td class="label">Date</td>
        <td>: {{$payment->doc_date}}</td>
      </tr>
      <tr>
        <td class="label">Payee Name</td>
        <td colspan="3">: {{ $payment->payee?->supplier_name?? 'Nil' }}</td>
      </tr>
      <tr>
        <td class="label">Payment Purpose</td>
        <td colspan="3">: {{ $payment->purpose?->purpose_name?? 'Nil' }}</td>
      </tr>
      <tr>
        <td class="label">Payment Mode</td>
        <td colspan="3">: {{ $payment->transaction_type }}</td>
      </tr>
      <tr>
        <td colspan="4"><br /></td>
      </tr>
      <tr>
        <td class="label">Amount Paid</td>
        <td colspan="3" class="amount">: ₹ {{$payment->paid_amount}}</td>
      </tr>
      <tr>
        <td class="label">Amount in Words</td>
        <td colspan="3">: Twenty-Five Thousand Rupees Only</td>
      </tr>
    </table>
  </div>

  <div class="signature-block">
    <div class="signature">
      <div>Prepared By</div>
      <div class="line"></div>
    </div>
    <div class="signature">
      <div>Approved By</div>
      <div class="line"></div>
    </div>
    <div class="signature">
      <div>Received By</div>
      <div class="line"></div>
    </div>
  </div>

  <div class="footer">
    This is a computer-generated document and does not require a physical signature.
  </div>
</div>

</body>
</html>

<script>
    function printAndClose() {
        window.print();
        setTimeout(() => window.close(), 1000);
    }
</script>