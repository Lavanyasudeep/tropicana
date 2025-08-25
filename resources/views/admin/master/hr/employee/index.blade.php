@extends('adminlte::page')

@section('title', 'Employee')

@section('content_header')
    <h1>Employee</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter">
            <i class="fas fa-filter"></i> Advance Filter
        </button>
        <a href="{{ route('admin.master.hr.employee.create') }}" class="btn btn-primary btn-sm" title="create">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="employeeAdvFilterPanel">
    <form id="employeeAdvFilterForm">
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
        <table id="employeeListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Payroll</th>
                    <th>Employee</th>
                    <th>Designation</th>
                    <th>Branch</th>
                    <th>Phone Number</th>
                    <th>Email Id</th>
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
        $('#employeeAdvFilterPanel').toggle();
    });

    $('#cancelFltrBtn').on("click", function () {
        const form = $('#employeeAdvFilterForm');
        form.find('input, select').val('');
        table.ajax.reload();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $('#closeFltrBtn').on("click", function () {
        const form = $('#employeeAdvFilterForm');
        form.find('input, select').val('');
        $('#employeeAdvFilterPanel').hide();
    });

    $('#employeeAdvFilterForm').on("submit", function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    let table = $('#employeeListTable').DataTable({
        lengthMenu: [10, 20, 50, 100],
        pageLength: 20,
        searching: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.master.hr.employee.index") }}',
            data: function (d) {
                d.quick_search = $('#fltrSearchBox').val();
            }
        },
        columns: [
            { data: 'employee_id', name: 'employee_id', width: '8%' },
            { data: 'payroll_number', name: 'payroll_number', width: '8%' },
            { data: 'employee', name: 'employee', width: '10%' },
            { data: 'designation.designation_name', name: 'designation.designation_name', width: '15%', defaultContent: '' },
            { data: 'branch.branch_name', name: 'branch.branch_name', width: '15%' },
            { data: 'mobile_number', name: 'mobile_number', width: '20%' },
            { data: 'email_id', name: 'email_id', width: '10%' },
            { data: 'Status', name: 'Status', width: '8%' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, width: '13%' },
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

    $('#employeeListTable').on("submit", function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    $('#fltrDateRangePicker').on('apply.daterangepicker', function(ev, picker) {
        table.draw();
    });

    $('#employeeListTable').on('click', '.toggle-status', function () {
        const button = $(this);
        const id = button.data('id');

        $.post('{{ route('admin.master.hr.employee.toggle-status') }}', {
            _token: '{{ csrf_token() }}',
            id: id
        }, function (res) {
            if (res.success) {
                button.toggleClass('btn-success btn-secondary')
                    .text(res.status ? 'Active' : 'Inactive');
            }
        });
    });
});
</script>
@endsection
