@extends('adminlte::page')

@section('title', 'Sales Invoice')

@section('content_header')
    <h1>Sales Invoice</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns" >
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter" ><i class="fas fa-filter" ></i> Advance Filter</button>
        <a href="{{ route('admin.sales.sales-invoice.create') }}" class="btn btn-create" title="create"><i class="fas fa-plus" ></i> Create</a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="quotAdvFilterPanel" >
    <form id="quotAdvFilterForm" >
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
                <select id="customerFlt" class="form-control pq-fltr-select">
                    <option value="">- Select Customer-</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
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

<div class="card page-list-panel">
    <div class="card-body">
        <table class="page-list-table" id="invoiceTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Doc. No.</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function () {
     /***** Start : Quick Filter *****/
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

    $(document).on('click', '#fltrSearchBtn', function () {
        table.ajax.reload();
    });
    /***** End : Quick Filter *****/

    /***** Start : Advance Filter *****/
    $(document).on("click", '#hdrAdvFilterBtn', function(e) {
        e.preventDefault();
        if($('#quotAdvFilterPanel').is(':visible'))
            $('#quotAdvFilterPanel').hide();
        else
            $('#quotAdvFilterPanel').show();
    });

    $(document).on("click", "#cancelFltrBtn", function () {
        const form = $('#quotAdvFilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        table.ajax.reload();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeFltrBtn", function () {
        const form = $('#quotAdvFilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        form.find('input[name="_method"]').remove();
        document.getElementById('quotAdvFilterPanel').style.display = 'none';
    });

    $(document).on("submit", '#quotAdvFilterForm', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
    /***** End : Advance Filter *****/

    let table = $('#invoiceTable').DataTable({
        processing: false,
        serverSide: false,
        data: [
            {
            "DT_RowIndex": 1,
            "doc_no": "INV-2025-001",
            "doc_date": "02/08/2025",
            "customer": { "customer_name": "Frozen Foods Ltd." },
            "amount": "₹12,450.00",
            "status": "Approved",
            "action": `
                    <a href="/admin/sales/sales-invoice/1/edit" class="btn btn-warning btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="/admin/sales/sales-invoice/1/print" target="_blank" class="btn btn-sm btn-print" title="Print">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="/admin/sales/sales-invoice/view/1" class="btn btn-primary btn-sm" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                `
            },
            {
            "DT_RowIndex": 2,
            "doc_no": "INV-2025-002",
            "doc_date": "03/08/2025",
            "customer": { "customer_name": "Arctic Warehousing Co." },
            "amount": "₹8,720.00",
            "status": "Pending",
            "action": `
                    <a href="/admin/sales/sales-invoice/1/edit" class="btn btn-warning btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="/admin/sales/sales-invoice/1/print" target="_blank" class="btn btn-sm btn-print" title="Print">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="/admin/sales/sales-invoice/view/1" class="btn btn-primary btn-sm" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                `
            },
            {
            "DT_RowIndex": 3,
            "doc_no": "INV-2025-003",
            "doc_date": "04/08/2025",
            "customer": { "customer_name": "ChillZone Logistics" },
            "amount": "₹15,300.00",
            "status": "Rejected",
            "action": `
                    <a href="/admin/sales/sales-invoice/1/edit" class="btn btn-warning btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="/admin/sales/sales-invoice/1/print" target="_blank" class="btn btn-sm btn-print" title="Print">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="/admin/sales/sales-invoice/view/1" class="btn btn-primary btn-sm" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                `
            },
            {
            "DT_RowIndex": 4,
            "doc_no": "INV-2025-004",
            "doc_date": "05/08/2025",
            "customer": { "customer_name": "Polar Ice Pvt. Ltd." },
            "amount": "₹9,980.00",
            "status": "Approved",
            "action":  `
                    <a href="/admin/inventory/sales-invoice/1/edit" class="btn btn-warning btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="/admin/inventory/sales-invoice/1/print" target="_blank" class="btn btn-sm btn-print" title="Print">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="/admin/inventory/sales-invoice/1/view" class="btn btn-primary btn-sm" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                `
            },
            {
            "DT_RowIndex": 5,
            "doc_no": "INV-2025-005",
            "doc_date": "06/08/2025",
            "customer": { "customer_name": "Glacier Goods Inc." },
            "amount": "₹11,200.00",
            "status": "Pending",
            "action": `
                    <a href="/admin/sales/sales-invoice/1/edit" class="btn btn-warning btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="/admin/sales/sales-invoice/1/print" target="_blank" class="btn btn-sm btn-print" title="Print">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="/admin/sales/sales-invoice/view/1" class="btn btn-primary btn-sm" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                `
            }
        ],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'doc_no', name: 'doc_no' },
            { data: 'doc_date', name: 'doc_date' },
            { data: 'customer.customer_name', name: 'customer.customer_name' },
            { data: 'amount', name: 'amount', searchable: false },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        columnDefs: [
            {
                targets: [3,4,5],
                className: 'text-left'
            },
            {
                targets: [4],
                className: 'text-right'
            },
            {
                targets: [5,6],
                className: 'text-center'
            }
        ],
        "order": [[1, "asc"]] 
    });

    $(document).on("submit", '#quotListTable', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    $(document).on('apply.daterangepicker', '#fltrDateRangePicker', function(ev, picker) {
        table.draw();
    });

    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        let invoiceId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to cancel this invoice. This cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/sales/sales-invoice/' + invoiceId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire('Cancelled!', 'Invoice has been cancelled.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to cancel. Please try again.', 'error');
                    }
                });
            }
        });
    });

});
</script>
@stop
