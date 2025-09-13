@extends('adminlte::page')

@section('title', 'Putaway')

@section('content_header')
    <h1>Putaway</h1>
@endsection

@section('content')
@php
$putawayItems = [
    [
        'product_code' => 'FRZ-001',
        'product'      => 'Ice Cream Tubs - 35cmx35cmx20cm',
        'lot'          => 'LOT-PR-001',
        'expiry_date'  => '2026-02-15',
        'uom'          => 'Boxes',
        'qty'          => 60,
        'volume'       => 8
    ],
    [
        'product_code' => 'FRZ-002',
        'product'      => 'Paneer Blocks 5kg - 40cmx30cmx25cm',
        'lot'          => 'LOT-SQ-002',
        'expiry_date'  => '2026-03-20',
        'uom'          => 'Boxes',
        'qty'          => 40,
        'volume'       => 2
    ]
];
@endphp

<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.put-away.edit', 1) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.inventory.put-away.print', 1) }}" target="_blank" class="btn btn-sm btn-print">
            <i class="fas fa-print"></i> Print
        </a>
        <a href="{{ route('admin.inventory.put-away.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="action-status">
        <label>Change Status</label>
        <select id="change_status_select">
            <option value="created" selected>Created</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="putawayTabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#putDetails">Putaway</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#putAttachment">Attachments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#putStatus">Status</a>
    </li>
</ul>

<div class="tab-content">
    <!-- Details Tab -->
    <div class="tab-pane fade show active" id="putDetails">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 220px;">
                            <div class="pform-row"><div class="pform-label">Doc No.</div><div class="pform-value">PUT-25-00004</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Date</div><div class="pform-value">26/08/2025</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Time</div><div class="pform-value">09:42</div></div>
                            <div class="pform-row"><div class="pform-label">Gatepass No.</div><div class="pform-value">GP-1001</div></div>
                            <div class="pform-row"><div class="pform-label">Packing List No.</div><div class="pform-value">PL-25-00001</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle No.</div><div class="pform-value">KL-07-CD-4521</div></div>
                            <div class="pform-row"><div class="pform-label">Customer</div><div class="pform-value">Chelur Foods</div></div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 220px;">
                            <div class="pform-row"><div class="pform-label">Warehouse Unit</div><div class="pform-value">WU-0001</div></div>
                            <div class="pform-row"><div class="pform-label">Dock-In No.</div><div class="pform-value">D-07</div></div>
                            <div class="pform-row"><div class="pform-label">Chamber No.</div><div class="pform-value">CR-102</div></div>
                            <div class="pform-row"><div class="pform-label">Pallet No.</div><div class="pform-value">PLT-00001</div></div>
                            <div class="pform-row"><div class="pform-label">Pallet Location</div><div class="pform-value">WU0001-CR002-B2-R5-L1-D2</div></div>
                            <div class="pform-row"><div class="pform-label">Status</div><div class="pform-value"><span class="badge badge-success">Completed</span></div></div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 220px;">
                            <div class="pform-row"><div class="pform-label">Putaway By</div><div class="pform-value">Ramesh Kumar</div></div>
                            <div class="pform-row"><div class="pform-label">Start Time</div><div class="pform-value">09:15 AM</div></div>
                            <div class="pform-row"><div class="pform-label">End Time</div><div class="pform-value">09:42 AM</div></div>
                            <div class="pform-row"><div class="pform-label">Duration</div><div class="pform-value">00:27 Hr</div></div>
                            <div class="pform-row"><div class="pform-label">Team</div><div class="pform-value">Cold Ops Team A</div></div>
                            <div class="pform-row"><div class="pform-label">Remarks</div><div class="pform-value">All items placed correctly, no discrepancies</div></div>
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
                            <th>Lot No.</th>
                            <th>Expiry Date</th>
                            <th>Putaway Qty</th>
                            <th>UOM</th>
                            <th>Volume (m3)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($putawayItems as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="text-left">{{ $item['product_code'] }}</td>
                            <td class="text-left">{{ $item['product'] }}</td>
                            <td>{{ $item['lot'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['expiry_date'])->format('d/m/Y') }}</td>
                            <td class="text-right">{{ $item['qty'] }}</td>
                            <td>{{ $item['uom'] }}</td>
                            <td class="text-right">{{ $item['volume'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td></td>
                            <td colspan="4" class="text-right">Total</td>
                            <td class="text-right">{{ collect($putawayItems)->sum('qty') }}</td>
                            <td></td>
                            <td class="text-right">{{ collect($putawayItems)->sum('volume') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

     <!-- Attachment Tab -->
    <div class="tab-pane fade" id="putAttachment">
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
                            <td>Putaway_Confirmation_PLT-00001.pdf</td>
                            <td>PDF</td>
                            <td>95 KB</td>
                            <td>Ramesh Kumar</td>
                            <td>26/08/2025 10:00</td>
                            <td><a href="#" class="btn btn-primary btn-xs"><i class="fas fa-download"></i> Download</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Chamber_Entry_Log_PLT-00001.jpg</td>
                            <td>Image</td>
                            <td>430 KB</td>
                            <td>Vijay Nair</td>
                            <td>26/08/2025 10:05</td>
                            <td><a href="#" class="btn btn-primary btn-xs"><i class="fas fa-download"></i> Download</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <!-- Status Tab -->
    <div class="tab-pane fade" id="putStatus">
        <div class="card">
            <div class="card-header"><h5>Status History</h5></div>
            <div class="card-body">

                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Admin">
                    <div class="status-details">
                        <strong>Admin User</strong>
                        <span class="status">Created</span>
                        <span class="description">Putaway record initialized</span>
                        <span class="date">26 Aug 2025 09:00</span>
                    </div>
                </div>

                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Operator">
                    <div class="status-details">
                        <strong>Ramesh Kumar</strong>
                        <span class="status">In Progress</span>
                        <span class="description">Putaway started for pallet PLT-00001</span>
                        <span class="date">26 Aug 2025 09:15</span>
                    </div>
                </div>

                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Operator">
                    <div class="status-details">
                        <strong>Ramesh Kumar</strong>
                        <span class="status">Completed</span>
                        <span class="description">Putaway completed and location confirmed</span>
                        <span class="date">26 Aug 2025 09:42</span>
                    </div>
                </div>

                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Supervisor">
                    <div class="status-details">
                        <strong>Vijay Nair</strong>
                        <span class="status">Verified</span>
                        <span class="description">Supervisor confirmed chamber entry and bin placement</span>
                        <span class="date">26 Aug 2025 10:00</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('css')
<style>
    /* Optional: tab visuals consistent with your temp-check page */
    #putawayTabs { border-bottom: 1px solid #000; }
    #putawayTabs .nav-link { color:#000; }
    #putawayTabs .nav-link.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
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

</script>
@endsection
