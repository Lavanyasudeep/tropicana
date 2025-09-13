@extends('adminlte::page')

@section('title', 'Pre‑Alert List')

@section('content_header')
    <h1>Pre‑Alert Documents</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.pre-alert.create') }}" class="btn btn-create"><i class="fas fa-plus"></i> Create</a>
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

<div class="card page-list-panel">
    <div class="card-body">
        <table class="page-list-table table table-bordered">
            <thead>
                <tr>
                    <th>Doc. #</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Vehicle No.</th>
                    <th>Status</th>
                    <th style="width:120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PA‑25‑00001</td>
                    <td>25/08/2025</td>
                    <td>Australian Foods India Pvt. Ltd.</td>
                    <td>KL‑07‑AB‑1234</td>
                    <td>Created</td>
                    <td>
                        <a href="{{ route('admin.inventory.pre-alert.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.pre-alert.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>
                        <a href="{{ route('admin.inventory.pre-alert.view', 1) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>PA‑25‑00002</td>
                    <td>26/08/2025</td>
                    <td>AAA International</td>
                    <td>KL‑08‑CD‑5678</td>
                    <td>Approved</td>
                    <td>
                        <a href="{{ route('admin.inventory.pre-alert.edit', 2) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.pre-alert.print', 2) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>
                        <a href="{{ route('admin.inventory.pre-alert.view', 2) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
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

