@extends('adminlte::page')

@section('title', 'Vehicle & Pre-Cooling Inspection')

@section('content_header')
    <h1>Vehicle & Pre-Cooling Inspection</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter"><i class="fas fa-filter"></i> Advance Filter</button>
        <a href="{{ route('admin.inventory.vpci-check.create') }}" class="btn btn-create" title="Create"><i class="fas fa-plus"></i> Create</a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="vcpiAdvFilterPanel" style="display:none;">
    <form id="vcpiAdvFilterForm">
        <div class="row">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Vehicle Number">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" placeholder="Inspection Date">
            </div>
            <div class="col-md-3 btn-group" role="group">
                <button type="submit" class="btn btn-success">Filter</button>
                <button type="button" class="btn btn-secondary" id="cancelFltrBtn">Cancel</button>
                <button type="button" class="btn btn-light" id="closeFltrBtn">Close</button>
            </div>
        </div>
    </form>
</div>

<!-- Quick Filter -->
<div class="page-quick-filter">
    <div class="row">
        <div class="col-md-1 fltr-title">
            <span>FILTER BY</span>
        </div>
        <div class="col-md-3">
            <input type="date" class="form-control pq-fltr-input" placeholder="Date">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control pq-fltr-input" placeholder="Vehicle Number">
        </div>
        <div class="col-md-2">
            <select class="form-control pq-fltr-select">
                <option value="">- All Status -</option>
                <option value="Pass">Pass</option>
                <option value="Fail">Fail</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control pq-fltr-input" placeholder="Search">
        </div>
        <div class="col-md-1">
            <input type="button" value="Search" class="btn btn-quick-filter-search" />
        </div>
    </div>
</div>

<!-- List View -->
<div class="card page-list-panel">
    <div class="card-body">
        <table id="vcpiListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>Document No.</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Vehicle No.</th>
                    <th>Measured Temp (°C)</th>
                    <th>Required Temp (°C)</th>
                    <th>Status</th>
                    <th>Inspector</th>
                    <th style="width:120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>VCPI-2025-0829-001</td>
                    <td>29/08/2025</td>
                    <td>14:45</td>
                    <td>KL-07-BD-1123</td>
                    <td>-16.5</td>
                    <td>-18.0</td>
                    <td>Fail</td>
                    <td>Ravi Kumar</td>
                    <td>
                        <a href="{{ route('admin.inventory.vpci-check.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.vpci-check.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>
                        <a href="{{ route('admin.inventory.vpci-check.view', 1) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>VCPI-2025-0829-002</td>
                    <td>29/08/2025</td>
                    <td>15:10</td>
                    <td>TN-22-CX-9087</td>
                    <td>-18.3</td>
                    <td>-18.0</td>
                    <td>Pass</td>
                    <td>Ravi Kumar</td>
                    <td>
                        <a href="{{ route('admin.inventory.vpci-check.edit', 2) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.vpci-check.print', 2) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>
                        <a href="{{ route('admin.inventory.vpci-check.view', 2) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Toggle Advance Filter
    $(document).on("click", '#cancelFltrBtn', function () {
        const form = $('#vcpiAdvFilterForm');
        form.find('input[type="text"], input[type="date"]').val('');
        form.find('select').val('');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeFltrBtn", function () {
        const form = $('#vcpiAdvFilterForm');
        form.find('input[type="text"], input[type="date"]').val('');
        form.find('select').val('');
        $('#vcpiAdvFilterPanel').hide();
    });

    $(document).on("submit", '#vcpiAdvFilterForm', function(e) {
        e.preventDefault();
        alert('Filter applied (demo only)');
    });

    window.toggleView = function(view) {
        $('#vcpiAdvFilterPanel').toggle();
    };
});
</script>
@endsection
