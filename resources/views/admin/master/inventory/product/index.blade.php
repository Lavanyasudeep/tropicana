@extends('adminlte::page')

@section('title', 'Product Master')

@section('content_header')
    <h1>Product Master</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter">
            <i class="fas fa-filter"></i> Advance Filter
        </button>
        <a href="{{ route('admin.master.inventory.product.create') }}" class="btn btn-create" title="create">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="productAdvFilterPanel">
    <form id="productAdvFilterForm">
        <div class="row">
            <div class="col-md-3">
                <label>Category</label>
                <select name="product_category_id" class="form-control">
                    <option value="">- All Categories -</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->product_category_id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Brand</label>
                <select name="brand_id" class="form-control">
                    <option value="">- All Brands -</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 btn-group align-self-end" role="group">
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
        <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-chevron-down"></i></span>
                </div>
                <select id="fltrStatus" class="form-control pq-fltr-select">
                    <option value="">- All Status -</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
         <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-chevron-down"></i></span>
                </div>
                <select id="fltrCustomer" class="form-control pq-fltr-select">
                    <option value="">- All Customer -</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-search fa-lg"></i></span>
                </div>
                <input type="text" id="fltrSearchBox" class="form-control pq-fltr-input" placeholder="Search by name/code">
            </div>
        </div>
        <div class="col-md-1">
            <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" />
        </div>
    </div>
</div>

<!-- List View -->
<div class="card page-list-panel">
    <div class="card-body">
        <table id="productListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Tax</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Action</th>
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

    // Dummy data array
    const dummyProducts = [
        {
            product_id: 1,
            product_name: "Frozen Peas 500g",
            product_code: "FP500",
            category_name: "Frozen Vegetables",
            brand_name: "GreenFarm",
            tax: "5%",
            active: 1,
            customer: "Customer A",
            actions: '<button class="btn btn-sm btn-primary">Edit</button>'
        },
        {
            product_id: 2,
            product_name: "Ice Cream Vanilla 1L",
            product_code: "ICV1L",
            category_name: "Desserts",
            brand_name: "CoolTreats",
            tax: "12%",
            active: 0,
            customer: "Customer B",
            actions: '<button class="btn btn-sm btn-primary">Edit</button>'
        },
        {
            product_id: 3,
            product_name: "Chicken Nuggets 1kg",
            product_code: "CN1KG",
            category_name: "Frozen Meat",
            brand_name: "FarmFresh",
            tax: "5%",
            active: 1,
            customer: "Customer C",
            actions: '<button class="btn btn-sm btn-primary">Edit</button>'
        }
    ];

    // Date range picker
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

    // Advanced filter toggle
    $(document).on("click", '#hdrAdvFilterBtn', function(e) {
        e.preventDefault();
        $('#productAdvFilterPanel').toggle();
    });

    $('#cancelFltrBtn').on("click", function () {
        const form = $('#productAdvFilterForm');
        form.find('input, select').val('');
        table.ajax.reload();
    });

    $('#closeFltrBtn').on("click", function () {
        $('#productAdvFilterPanel').hide();
    });

    $('#productAdvFilterForm').on("submit", function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // DataTable
    // let table = $('#productListTable').DataTable({
    //     lengthMenu: [10, 20, 50, 100],
    //     pageLength: 20,
    //     searching: false,
    //     processing: true,
    //     serverSide: true,
    //     ajax: {
    //         url: '{{ route("admin.master.inventory.product.index") }}',
    //         data: function (d) {
    //             let range = $('#fltrDateRangePicker').val();
    //             if (range) {
    //                 let dates = range.split(' - ');
    //                 function formatDate(dateStr) {
    //                     let parts = dateStr.split('/');
    //                     return `${parts[2]}-${parts[1]}-${parts[0]}`;
    //                 }
    //                 d.from_date = formatDate(dates[0]);
    //                 d.to_date = formatDate(dates[1]);
    //             }
    //             d.category_id = $('select[name="product_category_id"]').val();
    //             d.brand_id = $('select[name="brand_id"]').val();
    //             d.status = $('#fltrStatus').val();
    //             d.quick_search = $('#fltrSearchBox').val();
    //         }
    //     },
    //     columns: [
    //         { data: 'product_id', width: '8%' },
    //         { data: 'product_name', width: '20%' },
    //         { data: 'product_code', width: '15%' },
    //         { data: 'category_name', width: '15%', defaultContent: '-' },
    //         { data: 'brand_name', width: '15%', defaultContent: '-' },
    //         { data: 'tax', width: '10%', defaultContent: '-' },
    //         { data: 'active', width: '8%', render: d => d == 1 ? 'Active' : 'Inactive' },
    //         { data: 'actions', width: '9%', orderable: false, searchable: false }
    //     ],
    //     columnDefs: [
    //         { targets: [6, 7], className: 'text-center' }
    //     ]
    // });

     // Initialize DataTable with dummy data
    let table = $('#productListTable').DataTable({
        data: dummyProducts,
        columns: [
            { data: 'product_id' },
            { data: 'product_name' },
            { data: 'product_code' },
            { data: 'category_name' },
            { data: 'brand_name' },
            { data: 'tax' },
            { data: 'active', render: d => d == 1 ? 'Active' : 'Inactive' },
            { data: 'customer' },
            { data: 'actions', orderable: false, searchable: false }
        ]
    });

    $('#productListTable').on("submit", function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    $('#fltrDateRangePicker').on('apply.daterangepicker', function() {
        table.draw();
    });
});
</script>
@endsection
