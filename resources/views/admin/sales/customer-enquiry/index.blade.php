@extends('adminlte::page')

@section('title', 'Customer Enquiry')

@section('content_header')
    <h1>Customer Enquiries</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter">
            <i class="fas fa-filter"></i> Advance Filter
        </button>
        <a href="{{ route('admin.sales.customer-enquiry.create') }}" class="btn btn-primary btn-sm" title="create">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="enquiryAdvFilterPanel">
    <form id="enquiryAdvFilterForm">
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
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-calendar-alt fa-lg"></i></span>
                </div>
                <input type="text" id="fltrDateRangePicker" class="form-control pq-fltr-input" placeholder="Date Range" readonly style="background-color: white; cursor: pointer;" />
            </div>
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
        <table id="enquiryListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>Doc. No.</th>
                    <th>Doc. Date</th>
                    <th>Customer</th>
                    <th>Item Description</th>
                    <th>Service Type</th>
                    <th>Item Type</th>
                    <th>Status</th>
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
    /***** Quick Filter *****/
    $('#fltrDateRangePicker').daterangepicker({
        opens: 'right',
        autoUpdateInput: true,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        },
        startDate: moment().subtract(2, 'months'),
        endDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

    $('#fltrSearchBtn').on('click', function () {
        table.ajax.reload();
    });

    /***** Advance Filter *****/
    $('#hdrAdvFilterBtn').on("click", function(e) {
        e.preventDefault();
        $('#enquiryAdvFilterPanel').toggle();
    });

    $('#cancelFltrBtn').on("click", function () {
        const form = $('#enquiryAdvFilterForm');
        form.find('input, select').val('');
        table.ajax.reload();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $('#closeFltrBtn').on("click", function () {
        const form = $('#enquiryAdvFilterForm');
        form.find('input, select').val('');
        $('#enquiryAdvFilterPanel').hide();
    });

    $('#enquiryAdvFilterForm').on("submit", function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    let table = $('#enquiryListTable').DataTable({
        lengthMenu: [10, 20, 50, 100],
        pageLength: 20,
        searching: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.sales.customer-enquiry.index") }}',
            data: function (d) {
                let range = $('#fltrDateRangePicker').val();
                if (range) {
                    let dates = range.split(' - ');
                    function formatDate(dateStr) {
                        let parts = dateStr.split('/');
                        return `${parts[2]}-${parts[1]}-${parts[0]}`;
                    }
                    d.from_date = formatDate(dates[0]);
                    d.to_date = formatDate(dates[1]);
                }
                d.quick_search = $('#fltrSearchBox').val();
            }
        },
        columns: [
            { data: 'doc_no', name: 'doc_no', width: '8%' },
            { data: 'doc_date', name: 'doc_date', width: '8%' },
            { data: 'customer_name', name: 'customer_name', width: '15%' },
            { data: 'description', name: 'description', width: '20%' },
            { data: 'type_of_service', name: 'type_of_service', width: '10%' },
            { data: 'type_of_item', name: 'type_of_item', width: '8%' },
            { data: 'status', name: 'status', width: '8%' },
            { data: 'action', name: 'action', orderable: false, searchable: false, width: '13%' },
        ],
        columnDefs: [
            {
                targets: [6],
                className: 'text-center'
            },
            {
                targets: [7],
                className: 'text-center'
            }
        ]
    });

    $('#enquiryListTable').on("submit", function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    $('#fltrDateRangePicker').on('apply.daterangepicker', function(ev, picker) {
        table.draw();
    });
});
</script>
@endsection
