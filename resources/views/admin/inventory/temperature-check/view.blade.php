@extends('adminlte::page')

@section('title', 'View Temperature Check')

@section('content_header')
    <h1>Temperature Check</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.temperature-check.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.temperature-check.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.temperature-check.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
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
<ul class="nav nav-tabs" role="tablist" id="temperatureTabs">
    <li class="nav-item">
        <a class="nav-link active" id="temperature-tab" data-toggle="tab" href="#temperatureDetails" role="tab">Temperature Check</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="temperature-status-tab" data-toggle="tab" href="#temperatureStatus" role="tab">Status</a>
    </li>
</ul>

<div class="tab-content">
    <!-- Temperature Details Tab -->
    <div class="tab-pane fade show active" id="temperatureDetails" role="tabpanel">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;" >
                            <div class="pform-row"><div class="pform-label">Doc No</div><div class="pform-value">TC-25-0001</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Date</div><div class="pform-value">16/10/2023</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Time</div><div class="pform-value">20:00</div></div>
                            <div class="pform-row"><div class="pform-label">Gate Pass No.</div><div class="pform-value">7508</div></div>
                            <div class="pform-row"><div class="pform-label">Customer</div><div class="pform-value">TRDP</div></div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;" >
                            <div class="pform-row"><div class="pform-label">Vehicle No.</div><div class="pform-value">HR 55 R 0057</div></div>
                            <div class="pform-row"><div class="pform-label">Product</div><div class="pform-value">Frozen Prawns</div></div>
                            <div class="pform-row"><div class="pform-label">Total Qty</div><div class="pform-value">150</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle Set Temp (°C)</div><div class="pform-value">2</div></div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:135px;" >
                            <div class="pform-row"><div class="pform-label">Status</div><div class="pform-value">Created</div></div>
                            <div class="pform-row"><div class="pform-label">Remarks</div><div class="pform-value">OK</div></div>
                            <div class="pform-row"><div class="pform-label">Received By</div><div class="pform-value">Tropicana</div></div>
                            <div class="pform-row"><div class="pform-label">Checked By</div><div class="pform-value">John Smith</div></div>
                        </div>
                    </div>
                </div>

                <!-- Multiple Checks Table -->
                <table class="table table-striped page-list-table">
                    <thead>
                        <tr>
                            <th>Check #</th>
                            <th>Product #</th>
                            <th>Time</th>
                            <th>Product Temp (°C)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Frozen Prawns</td>
                            <td>20:00</td>
                            <td>-1.6</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Frozen Squid Rings</td>
                            <td>20:05</td>
                            <td>-1.6</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Frozen Crab Meat</td>
                            <td>20:10</td>
                            <td>Frozen Crab Meat</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Status Tab -->
    <div class="tab-pane fade" id="temperatureStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="John Smith">
                    <div class="status-details">
                        <strong>John Smith</strong>
                        <span class="status">Created</span>
                        <span class="description">Record created</span>
                        <span class="date">16 Oct 2023 20:05</span>
                    </div>
                </div>
                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Jane Doe">
                    <div class="status-details">
                        <strong>Jane Doe</strong>
                        <span class="status">Approved</span>
                        <span class="description">Verified by supervisor</span>
                        <span class="date">16 Oct 2023 20:15</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    #temperatureTabs { border-bottom: 1px solid #000; }
    #temperatureTabs li.nav-item a { color:#000; }
    #temperatureTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
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
