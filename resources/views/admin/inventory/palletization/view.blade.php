@extends('adminlte::page')

@section('title', 'Palletization')

@section('content_header')
    <h1>Palletization</h1>
@endsection

@section('content')
@php
$pallet = [
    [
        'pallet_no'         => 'PLT-00001',
        'warehouse_unit_no' => 'WU-0005',
        'room_no'           => 'R-102',
        'dock_no'           => 'D-07',
        'product_code'      => 'FRZ-001',
        'product'           => 'Frozen Prawns 500g',
        'lot'               => 'BCH-25-001',
        'size'              => '500g',
        'package_type'      => 'Carton',
        'no_of_packages'    => 60,
        'total_gw'          => 750,
        'total_nw'          => 720,
        'expiry_date'       => '2026-02-15',
        'uom'               => 'Boxes',
        'palletized_by'     => 'Ramesh Kumar',
        'palletized_time'   => '09:15 – 09:42 (00:27)',
        'supervisor'        => 'Vijay Nair',
        'remarks'           => 'No damage, all boxes sealed',
    ],
    [
        'pallet_no'         => 'PLT-00001',
        'warehouse_unit_no' => 'WU-0005',
        'room_no'           => 'R-102',
        'dock_no'           => 'D-07',
        'product_code'      => 'FRZ-002',
        'product'           => 'Frozen Squid Rings 1kg',
        'lot'               => 'BCH-25-002',
        'size'              => '1kg',
        'package_type'      => 'Carton',
        'no_of_packages'    => 40,
        'total_gw'          => 500,
        'total_nw'          => 480,
        'expiry_date'       => '2026-03-20',
        'uom'               => 'Boxes',
        'palletized_by'     => 'Ramesh Kumar',
        'palletized_time'   => '09:15 – 09:42 (00:27)',
        'supervisor'        => 'Vijay Nair',
        'remarks'           => 'No damage, all boxes sealed',
    ]
];
@endphp

<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.palletization.edit', 1) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.inventory.palletization.print', 1) }}" target="_blank" class="btn btn-sm btn-print">
            <i class="fas fa-print"></i> Print
        </a>
        <a href="{{ route('admin.inventory.palletization.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="action-status">
        <label>Change Status</label>
        <select id="change_status_select">
            <option value="created" selected>Created</option>
            <option value="approved">Approved</option>
            <option value="dispatched">Dispatched</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="palletizationTabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#palDetails">Palletization</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#palPallets">Pallet</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#palAttachment">Attachments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#palStatus">Status</a>
    </li>
</ul>

<div class="tab-content">
    <!-- Details Tab -->
    <div class="tab-pane fade show active" id="palDetails">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 220px;">
                            <div class="pform-row"><div class="pform-label">Doc No.</div><div class="pform-value">PAL-25-00001</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Date</div><div class="pform-value">26/08/2025</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Time</div><div class="pform-value">09:42</div></div>
                            <div class="pform-row"><div class="pform-label">Gatepass No.</div><div class="pform-value">GP-1001</div></div>
                            <div class="pform-row"><div class="pform-label">Packing List No.</div><div class="pform-value">PL-25-00001</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle No.</div><div class="pform-value">KL-07-CD-4521</div></div>
                            <div class="pform-row"><div class="pform-label">Customer</div><div class="pform-value">Ocean Fresh Exports Pvt Ltd</div></div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 220px;">
                            <div class="pform-row"><div class="pform-label">Warehouse Unit</div><div class="pform-value">WU-0005</div></div>
                            <div class="pform-row"><div class="pform-label">Dock-In No.</div><div class="pform-value">D-07</div></div>
                            <div class="pform-row"><div class="pform-label">Room No.</div><div class="pform-value">R-102</div></div>
                            <div class="pform-row" style="color:red;" ><div class="pform-label">Pallet No.</div><div class="pform-value">PLT-00001</div></div>
                            <div class="pform-row"><div class="pform-label">Qty Per Pallet</div><div class="pform-value">100</div></div>
                            <div class="pform-row"><div class="pform-label">Total Weight (KG)</div><div class="pform-value">1250</div></div>
                            <div class="pform-row"><div class="pform-label">Status</div><div class="pform-value"><span class="badge badge-success">Completed</span></div></div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 220px;">
                            <div class="pform-row"><div class="pform-label">Palletized By</div><div class="pform-value">Ramesh Kumar</div></div>
                            <div class="pform-row"><div class="pform-label">Palletized Time</div><div class="pform-value">09:15 AM - 09:42 AM</div></div>
                            <div class="pform-row"><div class="pform-label">Duration</div><div class="pform-value">00:27 Hr</div></div>
                            <div class="pform-row"><div class="pform-label">Supervisor</div><div class="pform-value">Vijay Nair</div></div>
                            <div class="pform-row"><div class="pform-label">Remarks</div><div class="pform-value">No damage, all boxes sealed</div></div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="table table-striped page-list-table mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Batch No.</th>
                            <th>Expiry Date</th>
                            <th>Quantity</th>
                            <th>UOM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>FRZ-001</td>
                            <td>Frozen Prawns 500g</td>
                            <td>BCH-25-001</td>
                            <td>15/02/2026</td>
                            <td class="text-right">60</td>
                            <td>Boxes</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>FRZ-002</td>
                            <td>Frozen Squid Rings 1kg</td>
                            <td>BCH-25-002</td>
                            <td>20/03/2026</td>
                            <td class="text-right">40</td>
                            <td>Boxes</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td></td>
                            <td colspan="4" class="text-right">Total</td>
                            <td class="text-right">100</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Pallets Tab -->
    <div class="tab-pane fade" id="palPallets">
        @php
            use Endroid\QrCode\Builder\Builder;
            use Endroid\QrCode\Writer\PngWriter;

            // Build QR payload with all items for this pallet
            $qrPayload = [
                'pallet_no' => $pallet[0]['pallet_no'],
                'items'     => $pallet
            ];

            $builder = new Builder(
                writer: new PngWriter(),
                data: json_encode($qrPayload),
                size: 150,
                margin: 5
            );

            $result = $builder->build();
            $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());
        @endphp

        <div class="card page-form" id="pallet-print">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Pallet Details</h5>
                <button type="button" class="btn btn-sm btn-print float-right" onclick="printPalletDetails()" title="Print / Download">
                    <i class="fas fa-download"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div style="padding:15px; border:1px solid #CCC;" >
                            <!-- Header Section -->
                            <table class="header-section">
                                <tr class="header-left">
                                    <!-- Left Column -->
                                    <td class="txt-left">
                                        <div class="header-row"><span class="header-label">Warehouse Unit</span> <span class="header-value">: {{ $pallet[0]['warehouse_unit_no'] }}</span></div>
                                        <div class="header-row"><span class="header-label">Room No.</span> <span class="header-value">: {{ $pallet[0]['room_no'] }}</span></div>
                                        <div class="header-row"><span class="header-label">Pallet No. </span> <span class="header-value">: {{ $pallet[0]['pallet_no'] }}</span></div>
                                    </td>
                                    <!-- Right Column (QR Code) -->
                                    <td class="txt-right">
                                        <div class="header-right text-center">
                                            <div class="header-label mb-1">QR Code</div>
                                            <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-img">
                                        </div>
                                    </td>
                                </div>                    
                            </table>
                        </div>

                    </div>

                </div>
                
                <!-- Items Table -->
                <h6 class="mt-4">Items on this Pallet</h6>
                <table class="table table-bordered table-striped page-list-table print-list-table">
                    <thead>
                        <tr>
                            <th style="width:5%;">#</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Batch No.</th>
                            <th>Expiry Date</th>
                            <th class="text-right">Quantity</th>
                            <th>UOM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pallet as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item['product_code'] }}</td>
                                <td>{{ $item['product'] }}</td>
                                <td>{{ $item['lot'] }}</td>
                                <td>{{ $item['expiry_date'] }}</td>
                                <td class="text-right">{{ $item['no_of_packages'] }}</td>
                                <td>{{ $item['uom'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td></td>
                            <td colspan="4" class="text-right">Total</td>
                            <td class="text-right">{{ collect($pallet)->sum('no_of_packages') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

     <!-- Attachment Tab -->
    <div class="tab-pane fade" id="palAttachment">
        <div class="card">
            <div class="card-header"><h5>Attachments</h5></div>
            <div class="card-body">
                <table class="table table-bordered page-list-table">
                    <thead>
                        <tr>
                            <th style="width:5%;">#</th>
                            <th>File Name</th>
                            <th style="width:10%;">Type</th>
                            <th style="width:10%;">Size</th>
                            <th style="width:20%;">Uploaded By</th>
                            <th style="width:20%;">Date</th>
                            <th style="width:10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pallet_Label_PLT-00001.pdf</td>
                            <td>PDF</td>
                            <td>120 KB</td>
                            <td>Ramesh Kumar</td>
                            <td>26/08/2025 09:45</td>
                            <td><a href="#" class="btn btn-primary btn-xs"><i class="fas fa-download"></i> Download</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>QC_Report_PLT-00001.jpg</td>
                            <td>Image</td>
                            <td>540 KB</td>
                            <td>Vijay Nair</td>
                            <td>26/08/2025 09:50</td>
                            <td><a href="#" class="btn btn-primary btn-xs"><i class="fas fa-download"></i> Download</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <!-- Status Tab -->
    <div class="tab-pane fade" id="palStatus">
        <div class="card">
            <div class="card-header"><h5>Status History</h5></div>
            <div class="card-body">

                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Admin">
                    <div class="status-details">
                        <strong>Admin User</strong>
                        <span class="status">Created</span>
                        <span class="description">Palletization record created</span>
                        <span class="date">26 Aug 2025 09:00</span>
                    </div>
                </div>

                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Operator">
                    <div class="status-details">
                        <strong>Ramesh Kumar</strong>
                        <span class="status">In Progress</span>
                        <span class="description">Palletizing started</span>
                        <span class="date">26 Aug 2025 09:15</span>
                    </div>
                </div>

                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Operator">
                    <div class="status-details">
                        <strong>Ramesh Kumar</strong>
                        <span class="status">Completed</span>
                        <span class="description">Palletizing finished — pallet ready for dispatch</span>
                        <span class="date">26 Aug 2025 09:42</span>
                    </div>
                </div>

                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Supervisor">
                    <div class="status-details">
                        <strong>Vijay Nair</strong>
                        <span class="status">Approved</span>
                        <span class="description">Supervisor verification and seal check passed</span>
                        <span class="date">26 Aug 2025 09:50</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('css')
<style>
    /* Optional: tab visuals consistent with your temp-check page */
    #palletizationTabs { border-bottom: 1px solid #000; }
    #palletizationTabs .nav-link { color:#000; }
    #palletizationTabs .nav-link.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    .status-log-entry { display:flex; align-items:center; margin-bottom:15px; }
    .status-log-entry .avatar { width:40px; height:40px; border-radius:50%; margin-right:10px; }
    .status-details { font-size:14px; }
    .status-details .date { display:block; font-size:12px; color:#666; }
    .header-section {
        background-color: #f8f9fa;
        border: none !important;
    }
    .header-left, .header-right {
        flex: 1 1 45%;
    }
    .header-row {
        margin-bottom: 6px;
    }
    .header-label {
        font-weight: 600;
        min-width: 140px;
        display: inline-block;
        color: #333;
    }
    .header-value {
        font-weight: 500;
        color: #000;
    }
    .qr-img {
        width: 120px;
        height: 120px;
        border: 2px solid #ccc;
        padding: 4px;
        background: #fff;
    }
    @media print {
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
        .btn, .card-header button { display: none !important; }
        .card { border: none; box-shadow: none; }
        /* .header-section {
            border: 1px solid #000;
            padding: 6px;
            margin-bottom: 10px;
        } */
        .table th, .table td {
            border: 1px solid #000 !important;
        }
    }
</style>
@endsection

@section('js')
<script>
    document.getElementById('change_status_select').addEventListener('change', function(){
        const statusText = this.options[this.selectedIndex].text;
        if(confirm("Do you want to change the status to '" + statusText + "'?")) {
            alert("Status changed to: " + statusText + " (demo)");
        } else {
            this.value = 'created';
        }
    });

function printPalletDetails() {
    const content = document.getElementById('pallet-print').innerHTML;
    const win = window.open('', '', 'width=900,height=650');
    win.document.write('<html><head><title>Pallet Details</title>');
    win.document.write('<link rel="stylesheet" href="{{ asset('css/custom.css') }}">'); // or Bootstrap
    win.document.write('<style>@media print {.table th, .table td {border:1px solid #000;}}}</style>');
    win.document.write('</head><body>');
    win.document.write(content);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}
</script>
@endsection
