@extends('adminlte::page')

@section('title', 'View Vehcile Pre Cooling Inspection Check')

@section('content_header')
    <h1>Vehicle Pre Cooling Inspection Check</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.vpci-check.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.vpci-check.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.vpci-check.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status">
        <label>Change Status</label>
        <select id="change_status_select">
            <option value="created">Created</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs" role="tablist" id="vpciCheckTabs">
    <li class="nav-item">
        <a class="nav-link active" id="vpci-check-tab" data-toggle="tab" href="#vpciCheckDetails" role="tab">VPCI Check</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="vpci-check-status-tab" data-toggle="tab" href="#vpciCheckStatus" role="tab">Status</a>
    </li>
</ul>

<div class="tab-content">
    <!-- vpci Check Details Tab -->
    <div class="tab-pane fade show active" id="vpciCheckDetails" role="tabpanel">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;" >
                            <div class="pform-row"><div class="pform-label">Doc No</div><div class="pform-value">VCPI-2025-0829-001</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Date</div><div class="pform-value">16/10/2023</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Time</div><div class="pform-value">20:00</div></div>
                            <div class="pform-row"><div class="pform-label">Gate Pass No.</div><div class="pform-value">GP-25-0046</div></div>
                            <div class="pform-row"><div class="pform-label">Customer</div><div class="pform-value">Ocean Fresh Exports Pvt Ltd</div></div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;" >
                            <div class="pform-row"><div class="pform-label">Vehicle No.</div><div class="pform-value">KL-07-BD-1123</div></div>
                            <div class="pform-row"><div class="pform-label">Transporter Name</div><div class="pform-value">ABC Logistics</div></div>
                            <div class="pform-row"><div class="pform-label">Seal No.</div><div class="pform-value">SEAL-0829-A</div></div>
                            <div class="pform-row"><div class="pform-label">Arrival Time</div><div class="pform-value">14:45</div></div>
                            <div class="pform-row"><div class="pform-label">Status</div><div class="pform-value">Created</div></div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;" >
                            <div class="pform-row"><div class="pform-label">Body Condition</div><div class="pform-value">Good</div></div>
                            <div class="pform-row"><div class="pform-label">Insulation Status</div><div class="pform-value">Intact</div></div>
                            <div class="pform-row"><div class="pform-label">Cleanliness</div><div class="pform-value">Clean</div></div>
                            <div class="pform-row"><div class="pform-label">Pre-Cooling Temp (°C)</div><div class="pform-value">-16.5</div></div>
                            <div class="pform-row"><div class="pform-label">Required Temp (°C)</div><div class="pform-value">-18.0</div></div>
                        </div>
                    </div>
                </div>

                <!-- Multiple Checks Table -->
                <table class="table table-striped page-list-table">
                    <thead>
                        <tr>
                            <th>Check #</th>
                            <th>Time</th>
                            <th>Temp (°C)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>20:00</td>
                            <td>-13.6</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>20:05</td>
                            <td>-14.5</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>20:10</td>
                            <td>-14.0</td>
                        </tr>
                    </tbody>
                </table>

                <div class="row" >
                    <div class="col-md-6" ><br /><br />
                        <div class="remarks" >
                            <label>Remarks</label>
                            <div style="height:100px; width:100%; border:1px solid #CCC; padding:15px;" >Vehicle accepted. Temperature within range.</div>
                        </div>
                    </div>
                    <div class="col-md-6" ><br /><br />
                        <div class="pform-panel" style="min-height:135px;" >
                            <div class="pform-row"><div class="pform-label">Temperature Status</div><div class="pform-value">Pass</div></div>
                            <div class="pform-row"><div class="pform-label">Device Used</div><div class="pform-value">Infrared Gun</div></div>
                            <div class="pform-row"><div class="pform-label">Calibration Date</div><div class="pform-value">2025-07-01</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Tab -->
    <div class="tab-pane fade" id="vpciCheckStatus" role="tabpanel">
        @php
            $vcpiStatusLog = [
                [
                    'timestamp' => '29 Aug 2025 14:40',
                    'status' => 'Vehicle Arrived',
                    'updated_by' => 'Security Staff',
                    'remarks' => 'Vehicle KL-07-BD-1123 entered premises'
                ],
                [
                    'timestamp' => '29 Aug 2025 14:45',
                    'status' => 'Inspection Started',
                    'updated_by' => 'Operations Supervisor',
                    'remarks' => 'Checklist initiated for body, insulation, and temperature'
                ],
                [
                    'timestamp' => '29 Aug 2025 14:50',
                    'status' => 'Temperature Measured',
                    'updated_by' => 'Inspector',
                    'remarks' => 'Pre-cooling temp recorded as -16.5°C'
                ],
                [
                    'timestamp' => '29 Aug 2025 14:55',
                    'status' => 'Inspection Failed',
                    'updated_by' => 'Operations Supervisor',
                    'remarks' => 'Temperature above required threshold (-18.0°C)'
                ],
                [
                    'timestamp' => '29 Aug 2025 15:00',
                    'status' => 'Customer Notified',
                    'updated_by' => 'Dispatch Coordinator',
                    'remarks' => 'Customer informed of rejection and advised re-entry with pre-cooled vehicle'
                ]
            ];
        @endphp
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                @foreach($vcpiStatusLog as $log)
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
    #vpciCheckTabs { border-bottom: 1px solid #000; }
    #vpciCheckTabs li.nav-item a { color:#000; }
    #vpciCheckTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
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
