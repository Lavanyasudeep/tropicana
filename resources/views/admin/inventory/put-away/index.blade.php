@extends('adminlte::page')

@section('title', 'Putaway')

@section('content_header')
    <h1>Putaway</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.put-away.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="putawayAdvFilterPanel">
    <form id="putawayAdvFilterForm">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3 btn-group" role="group">
                <button type="submit" class="btn btn-success" id="applyAdvFilter">Filter</button>
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
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-calendar-alt fa-lg"></i></span>
                </div>
                <input type="text" id="fltrDateRangePicker" class="form-control pq-fltr-input" placeholder="Date Range" readonly style="background-color: white; cursor: pointer;" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-chevron-down"></i></span>
                </div>
                <select id="clientFlt" class="form-control pq-fltr-select">
                    <option value="">- All Customer -</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->client_id }}">{{ $client->client_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-chevron-down"></i></span>
                </div>
                <select id="fltrStatus" class="form-control pq-fltr-select">
                    <option value="">- All Status -</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->status_name }}">{{ $status->status_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-search fa-lg"></i></span>
                </div>
                <input type="text" id="fltrSearchBox" class="form-control pq-fltr-input" placeholder="Type here">
            </div>
        </div>
        <div class="col-md-1">
            <div class="input-group">
                <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" />
            </div>
        </div>
    </div>
</div>

<div class="card page-list">
    <div class="card-body">
        <table id="putawayTable" class="table table-bordered table-striped page-list-table">
            <thead>
                <tr>
                    <th>Doc No</th>
                    <th>Pallet No</th>
                    <th>Assigned Chamber</th>
                    <th>Assigned Rack</th>
                    <th>Assigned Location</th>
                    <th>Customer</th>
                    <th>Putaway By</th>
                    <th>Putaway Time</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Dummy / Prototype Data --}}
                <tr>
                    <td>PUT-25-00001</td>
                    <td>PLT-00001</td>
                    <td>CR-101</td>
                    <td>Rack R1</td>
                    <td>WU0001-R001-B1-R3-L2-D1</td>
                    <td>Chelur Foods</td>
                    <td>Ramesh Kumar</td>
                    <td>10:15 – 10:42 (00:27)</td>
                    <td class="text-center"><span class="badge badge-success">Completed</span></td>
                    <td>2025-08-26</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.put-away.view', 1) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.put-away.edit', 1) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.put-away.print', 1) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>PUT-25-00002</td>
                    <td>PLT-00002</td>
                    <td>CR-102</td>
                    <td>Rack R3</td>
                    <td>WU0001-R002-B2-R5-L1-D2</td>
                    <td>AAA International</td>
                    <td>Meena S</td>
                    <td>11:05 – 11:38 (00:33)</td>
                    <td class="text-center"><span class="badge badge-warning">Pending</span></td>
                    <td>2025-08-21</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.put-away.view', 2) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.put-away.edit', 2) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.put-away.print', 2) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>PUT-25-00003</td>
                    <td>PLT-00003</td>
                    <td>CR-101</td>
                    <td>Rack R2</td>
                    <td>WU0001-R003-B1-R1-L3-D4</td>
                    <td>Australian Foods India Pvt. Ltd.</td>
                    <td>Abdul Rahman</td>
                    <td>09:50 – 10:21 (00:31)</td>
                    <td class="text-center"><span class="badge badge-primary">In Progress</span></td>
                    <td>2025-08-22</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.put-away.view', 3) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.put-away.edit', 3) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.put-away.print', 3) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('js')
<script>
$(function () {
    $('#putawayTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        order: [[0, 'desc']]
    });
});

$(document).ready(function() {
    // Cancel Filter
    $(document).on("click", '#cancelFltrBtn', function () {
        const form = $('#putawayAdvFilterForm');
        form.find('input[type="text"], input[type="date"]').val('');
        form.find('select').val('');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Close Filter Panel
    $(document).on("click", "#closeFltrBtn", function () {
        const form = $('#putawayAdvFilterForm');
        form.find('input[type="text"], input[type="date"]').val('');
        form.find('select').val('');
        $('#putawayAdvFilterPanel').hide();
    });

    // Apply Filter (Demo)
    $(document).on("submit", '#putawayAdvFilterForm', function(e) {
        e.preventDefault();
        alert('Filter applied (demo only)');
    });

    // Toggle View (if needed)
    window.toggleView = function(view) {
        $('#putawayAdvFilterPanel').toggle();
    };
});
</script>
@endsection
