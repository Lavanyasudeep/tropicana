@extends('adminlte::page')

@section('title', 'View Releasing Order')

@section('content_header')
    <h1>Releasing Order</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.releasing-order.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.releasing-order.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.releasing-order.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
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

<ul class="nav nav-tabs" role="tablist" id="releasingOrderTabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#details">Releasing Order</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#attachment">Attachment</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#status">Status</a>
    </li>
</ul>

<div class="tab-content">
    <!-- Details Tab -->
    <div class="tab-pane fade show active" id="details">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;">
                            <div class="pform-row"><div class="pform-label">Document #</div><div class="pform-value">RO‑25‑00001</div></div>
                            <div class="pform-row"><div class="pform-label">Document Date</div><div class="pform-value">25/08/2025</div></div>
                            <div class="pform-row"><div class="pform-label">Date of Releasing</div><div class="pform-value">25/10/2025</div></div>
                            <div class="pform-row"><div class="pform-label">Ref. No. #</div><div class="pform-value">PQ‑25‑00045</div></div>
                            <div class="pform-row"><div class="pform-label">Customer</div><div class="pform-value">ABC Cold Storage Ltd.</div></div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;">
                            <div class="pform-row"><div class="pform-label">Contact Name</div><div class="pform-value">John Mathew</div></div>
                            <div class="pform-row"><div class="pform-label">Contact Address</div><div class="pform-value">Warehouse Road, Kochi</div></div>
                            <div class="pform-row"><div class="pform-label">Remarks</div><div class="pform-value">Handle with care — perishable goods</div></div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;">
                            <div class="pform-row"><div class="pform-label">Vehicle No.</div><div class="pform-value">KL‑07‑AB‑1234</div></div>
                            <div class="pform-row"><div class="pform-label">Driver Name</div><div class="pform-value">Ramesh Kumar</div></div>
                            <div class="pform-row"><div class="pform-label">Transport Mode</div><div class="pform-value">Refrigerated Truck</div></div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="table table-striped page-list-table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Batch No.</th>
                            <th>Qty</th>
                            <th>UOM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Frozen Prawns</td><td>BATCH‑PR‑001</td><td>500</td><td>Boxes</td></tr>
                        <tr><td>Frozen Green Peas</td><td>BATCH‑GP‑002</td><td>300</td><td>Crates</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Attachment Tab -->
    <div class="tab-pane fade" id="attachment">
        <div class="card">
            <div class="card-header"><h5>Attachments</h5></div>
            <div class="card-body">
               @php
                    $attachments = [
                        [
                            'filename' => 'Delivery_Note_RO-25-00012.pdf',
                            'type' => 'PDF',
                            'size' => '312 KB',
                            'uploaded_by' => 'Dispatch Coordinator',
                            'date' => '29 Aug 2025 09:15'
                        ],
                        [
                            'filename' => 'Driver_ID_Verification.jpg',
                            'type' => 'Image',
                            'size' => '1.1 MB',
                            'uploaded_by' => 'Security Staff',
                            'date' => '29 Aug 2025 09:18'
                        ],
                        [
                            'filename' => 'Temperature_Log_ChamberC.xlsx',
                            'type' => 'Excel',
                            'size' => '78 KB',
                            'uploaded_by' => 'Warehouse Supervisor',
                            'date' => '29 Aug 2025 09:22'
                        ],
                        [
                            'filename' => 'Vehicle_RC_Scan.pdf',
                            'type' => 'PDF',
                            'size' => '198 KB',
                            'uploaded_by' => 'Security Staff',
                            'date' => '29 Aug 2025 09:25'
                        ],
                        [
                            'filename' => 'Pallet_Tag_Labels_RO-25-00012.png',
                            'type' => 'Image',
                            'size' => '640 KB',
                            'uploaded_by' => 'Inventory Clerk',
                            'date' => '29 Aug 2025 09:30'
                        ]
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
    <div class="tab-pane fade" id="status">
        @php
            $statusLogs = [
                [
                    'user' => 'Admin User',
                    'status' => 'Created',
                    'description' => 'Document initialized with customer and item details',
                    'date' => '29 Aug 2025 09:05'
                ],
                [
                    'user' => 'Inventory Clerk',
                    'status' => 'Item Verified',
                    'description' => 'Stock availability and batch numbers confirmed',
                    'date' => '29 Aug 2025 09:20'
                ],
                [
                    'user' => 'Warehouse Supervisor',
                    'status' => 'Temperature Checked',
                    'description' => 'Cold chamber temperature log verified',
                    'date' => '29 Aug 2025 09:35'
                ],
                [
                    'user' => 'Security Staff',
                    'status' => 'Gatepass Issued',
                    'description' => 'Vehicle and driver verified, gatepass printed',
                    'date' => '29 Aug 2025 09:50'
                ],
                [
                    'user' => 'Dispatch Coordinator',
                    'status' => 'Released',
                    'description' => 'Order dispatched and marked as released',
                    'date' => '29 Aug 2025 10:00'
                ]
            ];
            @endphp
        <div class="card">
            <div class="card-header"><h5>Status History</h5></div>
            <div class="card-body">
                @foreach($statusLogs as $log)
                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar">
                    <div class="status-details">
                        <strong>{{ $log['user'] }}</strong>
                        <span class="status">{{ $log['status'] }}</span>
                        <span class="description">{{ $log['description'] }}</span>
                        <span class="date">{{ $log['date'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    #releasingOrderTabs { border-bottom: 1px solid #000; }
    #releasingOrderTabs li.nav-item a { color:#000; }
    #releasingOrderTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    .status-log-entry { display: flex; align-items: center; margin-bottom: 15px; }
    .status-log-entry .avatar { width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; }
    .status-details { font-size: 14px; }
    .status-details .status { font-weight: bold; margin-left: 5px; }
    .status-details .date { display: block; font-size: 12px; color: #666; }
</style>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#change_status_select').on('change', function(){
        var status = $(this).val();
        var status_text = $(this).find('option:selected').text();
        if(confirm("Do you want to change the status to '" + status_text + "'?")) {
            alert("Status changed to: " + status_text + " (demo only)");
        } else {
            $(this).val('created');
        }
    });
});
</script>
@endsection