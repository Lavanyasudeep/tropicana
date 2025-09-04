@extends('adminlte::page')

@section('title', 'Customer Contracts')

@section('content_header')
    <h1>Customer Contracts</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <a href="{{ route('admin.sales.customer-contract.create') }}" class="btn btn-primary">
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

<!-- Contract List -->
<div class="card page-list">
    <div class="card-body">
        <table id="contractListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>Doc. No</th>
                    <th>Doc. Date</th>
                    <th>Client</th>
                    <th>Period</th>
                    <th>Product</th>
                    <th>Billing Cycle</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>CT-2025-001</td>
                    <td>01/01/2025</td>
                    <td>Acme Cold Storage</td>
                    <td>01/01/2025 - 31/12/2025</td>
                    <td>Fruits</td>
                    <td>Monthly</td>
                    <td class="text-center">Active</td>
                    <td class="text-center">
                        <a href="{{ route('admin.sales.customer-contract.print',1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>
                        <a href="#" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>CT-2025-002</td>
                    <td>01/01/2025</td>
                    <td>Polar Freight</td>
                    <td>01/01/2024 - 31/12/2024</td>
                    <td>Meat</td>
                    <td>Quarterly</td>
                    <td class="text-center">Pending</td>
                    <td class="text-center">
                        <a href="#" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>CT-2024-003</td>
                    <td>01/01/2025</td>
                    <td>Frostline Storage</td>
                    <td>01/01/2024 - 31/12/2024</td>
                    <td>Vegetables</td>
                    <td>Monthly</td>
                    <td class="text-center">Expired</td>
                    <td class="text-center">
                        <a href="#" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-sm btn-view"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-sm btn-delete"><i class="fas fa-trash"></i></a>
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
    $('#contractDateRangePicker').daterangepicker({
        opens: 'right',
        locale: { format: 'DD/MM/YYYY' },
        startDate: moment().subtract(1, 'year'),
        endDate: moment()
    });

    // let table = $('#contractListTable').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: {
    //         url: '{{ route("admin.sales.customer-contract.index") }}',
    //         data: function (d) {
    //             let range = $('#contractDateRangePicker').val().split(' - ');
    //             d.from_date = moment(range[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
    //             d.to_date = moment(range[1], 'DD/MM/YYYY').format('YYYY-MM-DD');
    //             d.product_type = $('#productTypeFlt').val();
    //             d.status = $('#statusFlt').val();
    //             d.search_term = $('#contractSearchBox').val();
    //         }
    //     },
    //     columns: [
    //         { data: 'contract_no' },
    //         { data: 'period' },
    //         { data: 'client' },
    //         { data: 'product_type' },
    //         { data: 'billing_cycle' },
    //         { data: 'storage_charge' },
    //         { data: 'status', className: 'text-center' },
    //         { data: 'clauses', render: function(data) {
    //             return `<span title="${data}">${data.slice(0, 30)}...</span>`;
    //         }},
    //         { data: 'actions', className: 'text-center' }
    //     ]
    // });

    $('#contractSearchBox, #productTypeFlt, #statusFlt').on('change keyup', function() {
        table.ajax.reload();
    });

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
