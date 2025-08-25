@extends('adminlte::page')

@section('title', 'Analytical')

@section('content_header')
    <h1>Analytical</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter">
            <i class="fas fa-filter"></i> Advance Filter
        </button>
        <a href="{{ route('admin.master.accounting.analytical.create') }}" class="btn btn-primary btn-sm" title="create">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="analyticalAdvFilterPanel">
    <form id="analyticalAdvFilterForm">
        <div class="row">
            <div class="col-md-3">
                {{-- Add optional advanced filters like service type or item type here --}}
            </div>
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
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-search fa-lg"></i></span>
                </div>
                <input type="text" id="fltrSearchBox" class="form-control pq-fltr-input" placeholder="Search..." />
            </div>
        </div>
        <div class="col-md-1">
            <div class="input-group">
                <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" />
            </div>
        </div>
    </div>
</div>

<!-- List View -->
<div class="card page-list-panel">
    <div class="card-body">
        <table id="analyticalListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Analytical Code</th>
                    <th>Account Name</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@stop

@section('js')
<script>
$(document).ready(function() {

    $('#fltrSearchBtn').on('click', function () {
        table.ajax.reload();
    });

    /***** Advance Filter *****/
    $('#hdrAdvFilterBtn').on("click", function(e) {
        e.preventDefault();
        $('#analyticalAdvFilterPanel').toggle();
    });

    $('#cancelFltrBtn').on("click", function () {
        const form = $('#analyticalAdvFilterForm');
        form.find('input, select').val('');
        table.ajax.reload();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $('#closeFltrBtn').on("click", function () {
        const form = $('#analyticalAdvFilterForm');
        form.find('input, select').val('');
        $('#analyticalAdvFilterPanel').hide();
    });

    $('#analyticalAdvFilterForm').on("submit", function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    let table = $('#analyticalListTable').DataTable({
        lengthMenu: [10, 20, 50, 100],
        pageLength: 20,
        searching: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route($FPATH.".index") }}',
            data: function (d) {
                d.quick_search = $('#fltrSearchBox').val();
            }
        },
        columns: [
            { data: 'analytical_id', name: 'analytical_id', width: '10%' },
            { data: 'analytical_code', name: 'analytical_code', width: '30%' },
            { data: 'account_name', name: 'account_name', width: '30%' },
            { data: 'active', name: 'active', width: '15%' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, width: '15%' },
        ],
        columnDefs: [
            {
                targets: [0,3],
                className: 'text-center'
            }
        ]
    });

    $('#analyticalListTable').on("submit", function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
});
</script>
@endsection
