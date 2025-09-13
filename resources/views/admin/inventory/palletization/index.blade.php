@extends('adminlte::page')

@section('title', 'Palletization')

@section('content_header')
    <h1>Palletization</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.palletization.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>
</div>


<!-- Advance Filter -->
<div class="page-advance-filter" id="gatePassAdvFilterPanel" >
    <form id="gatePassAdvFilterForm" >
        <div class="row">
            <div class="col-md-3" >

            </div>
            <div class="col-md-3 btn-group" role="group" >
                <button type="submit" class="btn btn-success" id="applyAdvFilter" >Filter</button>
                <button type="button" class="btn btn-secondary" id="cancelFltrBtn" >Cancel</button>
                <button type="button" class="btn btn-light" id="closeFltrBtn" >Close</button>
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
                    <span class="input-group-text pq-fltr-icon" ><i class="fas fa-chevron-down"></i></span>
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
                    <span class="input-group-text pq-fltr-icon" ><i class="fas fa-chevron-down"></i></span>
                </div>
                <select id="fltrStatus" class="form-control pq-fltr-select" >
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
                <input type="text" id="fltrSearchBox" class="form-control pq-fltr-input" placeholder="Type here" >
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
        <table id="palletizationTable" class="table table-bordered table-striped page-list-table">
            <thead>
                <tr>
                    <th>Doc No</th>
                    <th>Pallet No</th>
                    <th>Doc Date</th>
                    <th>Gatepass No</th>
                    <th>Packing List No</th>
                    <th>Customer</th>
                    <th>Vehicle No</th>
                    <th>Qty Per Pallet</th>
                    <th>Palletized By</th>
                    <th>Palletized Time</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Dummy / Prototype Data --}}
                <tr>
                    <td>PAL-25-00001</td>
                    <td>PLT-00001</td>
                    <td>26/08/2025</td>
                    <td>GP-1001</td>
                    <td>PL-25-00001</td>
                    <td>Chelur Foods</td>
                    <td>KL-07-CD-4521</td>
                    <td class="text-center">100</td>
                    <td>Ramesh Kumar</td>
                    <td>09:15 – 09:42 (00:27)</td>
                    <td class="text-center"><span class="badge badge-success">Completed</span></td>
                    <td>2025-08-20</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.palletization.view', 1) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.palletization.edit', 1) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.palletization.print', 1) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>PAL-25-00002</td>
                    <td>PLT-00002</td>
                    <td>21/08/2025</td>
                    <td>GP-1002</td>
                    <td>PL-25-00002</td>
                    <td>AAA International</td>
                    <td>KL-07-AB-7890</td>
                    <td class="text-center">80</td>
                    <td>Meena S</td>
                    <td>10:05 – 10:38 (00:33)</td>
                    <td class="text-center"><span class="badge badge-warning">Draft</span></td>
                    <td>2025-08-21</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.palletization.view', 2) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.palletization.edit', 2) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.palletization.print', 2) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>PAL-25-00003</td>
                    <td>PLT-00003</td>
                    <td>22/08/2025</td>
                    <td>GP-1003</td>
                    <td>PL-25-00003</td>
                    <td>Australian Foods India Pvt. Ltd.</td>
                    <td>KL-07-EF-9012</td>
                    <td class="text-center">120</td>
                    <td>Abdul Rahman</td>
                    <td>08:50 – 09:21 (00:31)</td>
                    <td class="text-center"><span class="badge badge-primary">Dispatched</span></td>
                    <td>2025-08-22</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.palletization.view', 3) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.palletization.edit', 3) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.palletization.print', 3) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
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
    $('#palletizationTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        order: [[0, 'desc']]
    });
});

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
