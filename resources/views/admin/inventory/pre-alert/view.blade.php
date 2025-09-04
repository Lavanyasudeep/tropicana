@extends('adminlte::page')

@section('title', 'View Pre‑Alert')

@section('content_header')
    <h1>Pre‑Alert Document</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.pre-alert.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.pre-alert.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.pre-alert.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
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

<ul class="nav nav-tabs" role="tablist" id="preAlertTabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#details">Pre‑Alert</a>
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
                            <div class="pform-row"><div class="pform-label">Document #</div><div class="pform-value">PA‑25‑00001</div></div>
                            <div class="pform-row"><div class="pform-label">Document Date</div><div class="pform-value">25/08/2025</div></div>
                            <div class="pform-row"><div class="pform-label">Arriving Date</div><div class="pform-value">25/10/2025</div></div>
                            <div class="pform-row"><div class="pform-label">Ref No. #</div><div class="pform-value">SQ‑25‑00045</div></div>
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
                            <th>Manufacturing Date</th>
                            <th>Expriy Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Frozen Prawns</td><td>BATCH‑PR‑001</td><td>500</td><td>Boxes</td><td>12/06/2020</td><td>12/06/2030</td></tr>
                        <tr><td>Frozen Green Peas</td><td>BATCH‑GP‑002</td><td>300</td><td>Crates</td><td>09/07/2020</td><td>02/04/2030</td></tr>
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
                $prealetAttachments = [
                    [
                        'filename' => 'Prealet_Request_RO-25-00012.pdf',
                        'type' => 'PDF',
                        'size' => '284 KB',
                        'uploaded_by' => 'Customer: Frozen Foods Inc.',
                        'date' => '28 Aug 2025 16:45'
                    ],
                    [
                        'filename' => 'Packing_List_Batch_2025A.xlsx',
                        'type' => 'Excel',
                        'size' => '92 KB',
                        'uploaded_by' => 'Customer: Frozen Foods Inc.',
                        'date' => '28 Aug 2025 16:47'
                    ],
                    [
                        'filename' => 'Product_Label_Samples.jpg',
                        'type' => 'Image',
                        'size' => '1.4 MB',
                        'uploaded_by' => 'Customer: Frozen Foods Inc.',
                        'date' => '28 Aug 2025 16:50'
                    ],
                    [
                        'filename' => 'Transport_Confirmation.pdf',
                        'type' => 'PDF',
                        'size' => '198 KB',
                        'uploaded_by' => 'Customer: Frozen Foods Inc.',
                        'date' => '28 Aug 2025 17:00'
                    ],
                    [
                        'filename' => 'Temperature_Certificate_Batch_2025A.pdf',
                        'type' => 'PDF',
                        'size' => '312 KB',
                        'uploaded_by' => 'Customer: Frozen Foods Inc.',
                        'date' => '28 Aug 2025 17:05'
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
                        @foreach($prealetAttachments as $i => $file)
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
        <div class="card">
            @php
                $prealetStatusLog = [
                    [
                        'timestamp' => '28 Aug 2025 16:45',
                        'status' => 'Prealet Received',
                        'updated_by' => 'System',
                        'remarks' => 'Document received via customer email'
                    ],
                    [
                        'timestamp' => '28 Aug 2025 17:10',
                        'status' => 'Document Verified',
                        'updated_by' => 'Inbound Officer',
                        'remarks' => 'Packing list and temperature certificate verified'
                    ],
                    [
                        'timestamp' => '28 Aug 2025 17:30',
                        'status' => 'Storage Slot Assigned',
                        'updated_by' => 'Warehouse Supervisor',
                        'remarks' => 'Assigned to Chamber C2, Rack R5'
                    ],
                    [
                        'timestamp' => '28 Aug 2025 18:00',
                        'status' => 'Goods Inward Scheduled',
                        'updated_by' => 'Operations Team',
                        'remarks' => 'Expected arrival: 29 Aug 2025, 09:00'
                    ],
                    [
                        'timestamp' => '29 Aug 2025 09:15',
                        'status' => 'Goods Received',
                        'updated_by' => 'Inbound Officer',
                        'remarks' => 'Physical verification completed, GRN generated'
                    ],
                    [
                        'timestamp' => '29 Aug 2025 09:30',
                        'status' => 'Storage Confirmed',
                        'updated_by' => 'System',
                        'remarks' => 'Inventory updated, cold storage active'
                    ]
                ];
            @endphp
            <div class="card-header"><h5>Status History</h5></div>
            <div class="card-body">
                @foreach($prealetStatusLog as $log)
                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar">
                    <div class="status-details">
                        <strong>{{ $log['updated_by'] }}</strong>
                        <span class="status">{{ $log['status'] }}</span>
                        <span class="description">{{ $log['remarks'] }}</span>
                        <span class="date">{{ $log['timestamp'] }}</span>
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
    #preAlertTabs { border-bottom: 1px solid #000; }
    #preAlertTabs li.nav-item a { color:#000; }
    #preAlertTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
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