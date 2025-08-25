@extends('adminlte::page')

@section('title', 'Temperature Check')

@section('content_header')
    <h1>Temperature Check</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter"><i class="fas fa-filter"></i> Advance Filter</button>
        <a href="{{ route('admin.inventory.temperature-check.create') }}" class="btn btn-create" title="create"><i class="fas fa-plus"></i> Create</a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="tempAdvFilterPanel" style="display:none;">
    <form id="tempAdvFilterForm">
        <div class="row">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Name">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" placeholder="Date">
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
            <input type="text" class="form-control pq-fltr-input" placeholder="Name">
        </div>
        <div class="col-md-2">
            <select class="form-control pq-fltr-select">
                <option value="">- All Status -</option>
                <option value="Normal">Normal</option>
                <option value="High">High</option>
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
        <table id="tempListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Temperature (°C)</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th style="width:120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td>25/08/2025</td>
                    <td>09:00 AM</td>
                    <td>36.5</td>
                    <td>Normal</td>
                    <td>-</td>
                    <td>
                        <a href="{{ route('admin.inventory.temperature-check.edit', 1) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.temperature-check.print', 1) }}" target="_blank" class="btn btn-sm btn-print" title="Print"><i class="fas fa-print"></i></a>
                        <a href="{{ route('admin.inventory.temperature-check.view', 1) }}" class="btn btn-primary btn-sm" title="View"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>25/08/2025</td>
                    <td>09:15 AM</td>
                    <td>38.2</td>
                    <td>High</td>
                    <td>Referred to nurse</td>
                    <td>
                        <a href="{{ route('admin.inventory.temperature-check.edit', 2) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.temperature-check.print', 2) }}" target="_blank" class="btn btn-sm btn-print" title="Print"><i class="fas fa-print"></i></a>
                        <a href="{{ route('admin.inventory.temperature-check.view', 2) }}" class="btn btn-primary btn-sm" title="View"><i class="fas fa-eye"></i></a>
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
        const form = $('#tempAdvFilterForm');
        form.find('input[type="text"], input[type="date"]').val('');
        form.find('select').val('');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeFltrBtn", function () {
        const form = $('#tempAdvFilterForm');
        form.find('input[type="text"], input[type="date"]').val('');
        form.find('select').val('');
        $('#tempAdvFilterPanel').hide();
    });

    $(document).on("submit", '#tempAdvFilterForm', function(e) {
        e.preventDefault();
        alert('Filter applied (demo only)');
    });

    window.toggleView = function(view) {
        $('#tempAdvFilterPanel').toggle();
    };
});
</script>
@endsection
