@extends('adminlte::page')

@section('title', 'Gatepass‑In')

@section('content_header')
    <h1>Gatepass‑In</h1>
@endsection

@section('content')


@php
    // Dummy header data
    $gatepassIn = [
        'doc_no' => 'GPI‑25‑00001',
        'date' => '25/08/2025',
        'time_in' => '14:30',
        'customer' => 'Blue Ocean Seafood Traders',
        'pre_alert_no' => 'PA‑25‑00001',
        'invoice_no' => 'INV‑25‑0010',
        'transporter_no' => 'STN‑BLUO‑250826',
        'vehicle_type' => 'Open Truck',
        'vehicle_no' => 'KL‑07‑AB‑1234',
        'driver_name' => 'Ramesh Kumar',
        'driver_contact' => '9876543210',
        'transport_mode' => 'Refrigerated Truck',
        'vehicle_temp' => '-18.5',
        'dock_in_time' => '09:55',
        'dock_in_name' => '',
        'gross_weight' => '1285.40',
        'security_name' => 'S. Nair',
        'remarks' => 'All items verified as per Pre‑Alert',
        'total_pre_alert' => '813 c/s',
        'total_received' => '813 c/s'
    ];

    // Dummy items
    $items = [
        ['name' => 'Frozen Prawns', 'uom' => 'KG', 'date' => '06/03', 'pre_alert_qty' => 73, 'received_qty' => 73, 'remarks' => 'OK'],
        ['name' => 'Frozen Squid Rings', 'uom' => 'KG', 'date' => '23/06', 'pre_alert_qty' => 225, 'received_qty' => 225, 'remarks' => 'OK'],
        ['name' => 'Frozen Crab Meat', 'uom' => 'KG', 'date' => '06/10', 'pre_alert_qty' => 267, 'received_qty' => 267, 'remarks' => 'OK'],
    ];

    // Dummy status logs
    $statusLogs = [
        ['user' => 'Admin User', 'status' => 'Created', 'description' => 'Gatepass‑In record created', 'date' => '25 Aug 2025 14:35'],
        ['user' => 'Warehouse Supervisor', 'status' => 'Approved', 'description' => 'Verified at gate', 'date' => '25 Aug 2025 14:50'],
    ];
@endphp

<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.gatepass-in.edit', 1) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.inventory.gatepass-in.print', 1) }}" target="_blank" class="btn btn-sm btn-print">
            <i class="fas fa-print"></i> Print
        </a>
        <a href="{{ route('admin.inventory.gatepass-in.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="action-status">
        <label>Change Status</label>
        <select id="change_status_select">
            <option value="created" selected>Created</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="gatepassInTabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#gpDetails">Gatepass‑In</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#gpAttachment">Attachments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#gpStatus">Status</a>
    </li>
</ul>

<div class="tab-content">
    <!-- Details Tab -->
    <div class="tab-pane fade show active" id="gpDetails">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 200px;">
                            <div class="pform-row"><div class="pform-label">Doc No #</div><div class="pform-value">{{ $gatepassIn['doc_no'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Date</div><div class="pform-value">{{ $gatepassIn['date'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Time In</div><div class="pform-value">{{ $gatepassIn['time_in'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Customer</div><div class="pform-value">{{ $gatepassIn['customer'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Pre‑Alert #</div><div class="pform-value">{{ $gatepassIn['pre_alert_no'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Invoice No #</div><div class="pform-value">{{ $gatepassIn['invoice_no'] }}</div></div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 200px;">
                            <div class="pform-row"><div class="pform-label">Transporter / STN No.</div><div class="pform-value">{{ $gatepassIn['transporter_no'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle Type</div><div class="pform-value">{{ $gatepassIn['vehicle_type'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle No.</div><div class="pform-value">{{ $gatepassIn['vehicle_no'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Driver Name</div><div class="pform-value">{{ $gatepassIn['driver_name'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Driver Contact</div><div class="pform-value">{{ $gatepassIn['driver_contact'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Transport Mode</div><div class="pform-value">{{ $gatepassIn['transport_mode'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle Temperature (°C)</div><div class="pform-value">{{ $gatepassIn['vehicle_temp'] }}</div></div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height: 200px;">
                            <div class="pform-row"><div class="pform-label">Dock In Time</div><div class="pform-value">{{ $gatepassIn['dock_in_time'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Dock In Name</div><div class="pform-value">{{ $gatepassIn['dock_in_name'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Gross Weight (KG)</div><div class="pform-value">{{ $gatepassIn['gross_weight'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Security Name</div><div class="pform-value">{{ $gatepassIn['security_name'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Remarks</div><div class="pform-value">{{ $gatepassIn['remarks'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Total Pre‑Alert</div><div class="pform-value">{{ $gatepassIn['total_pre_alert'] }}</div></div>
                            <div class="pform-row"><div class="pform-label">Total Received</div><div class="pform-value">{{ $gatepassIn['total_received'] }}</div></div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="table table-striped page-list-table">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Item Name</th>
                            <th>UOM</th>
                            <th>Date</th>
                            <th>Pre‑Alert Qty</th>
                            <th>Received Qty</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['uom'] }}</td>
                                <td>{{ $item['date'] }}</td>
                                <td>{{ $item['pre_alert_qty'] }}</td>
                                <td>{{ $item['received_qty'] }}</td>
                                <td>{{ $item['remarks'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td></td>
                            <td class="text-right">Total</td>
                            <td></td>
                            <td></td>
                            <td>{{ collect($items)->sum('pre_alert_qty') }}</td>
                            <td>{{ collect($items)->sum('received_qty') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Attachment Tab -->
    <div class="tab-pane fade" id="gpAttachment">
        <div class="card">
            <div class="card-header"><h5>Attachments</h5></div>
            <div class="card-body">
                @php
                    $attachments = [
                        ['filename' => 'Gatepass_Signed_Copy.pdf', 'type' => 'PDF', 'size' => '245 KB', 'uploaded_by' => 'Admin User', 'date' => '25 Aug 2025 14:40'],
                        ['filename' => 'Vehicle_Photo.jpg', 'type' => 'Image', 'size' => '1.2 MB', 'uploaded_by' => 'Security Staff', 'date' => '25 Aug 2025 14:32'],
                        ['filename' => 'Temperature_Log.xlsx', 'type' => 'Excel', 'size' => '56 KB', 'uploaded_by' => 'Warehouse Supervisor', 'date' => '25 Aug 2025 14:35'],
                    ];
                @endphp

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
                        @foreach($attachments as $i => $file)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $file['filename'] }}</td>
                                <td>{{ $file['type'] }}</td>
                                <td>{{ $file['size'] }}</td>
                                <td>{{ $file['uploaded_by'] }}</td>
                                <td>{{ $file['date'] }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs"><i class="fas fa-download"></i> Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Status Tab -->
    <div class="tab-pane fade" id="gpStatus">
        <div class="card">
            <div class="card-header"><h5>Status History</h5></div>
            <div class="card-body">
                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Admin">
                    <div class="status-details">
                        <strong>Admin User</strong>
                        <span class="status">Created</span>
                        <span class="description">Gatepass‑In record created</span>
                        <span class="date">25 Aug 2025 14:35</span>
                    </div>
                </div>
                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Supervisor">
                    <div class="status-details">
                        <strong>Warehouse Supervisor</strong>
                        <span class="status">Approved</span>
                        <span class="description">Verified at gate</span>
                        <span class="date">25 Aug 2025 14:50</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Optional: tab visuals consistent with your temp-check page */
    #gatepassInTabs { border-bottom: 1px solid #000; }
    #gatepassInTabs .nav-link { color:#000; }
    #gatepassInTabs .nav-link.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    .status-log-entry { display:flex; align-items:center; margin-bottom:15px; }
    .status-log-entry .avatar { width:40px; height:40px; border-radius:50%; margin-right:10px; }
    .status-details { font-size:14px; }
    .status-details .date { display:block; font-size:12px; color:#666; }
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
