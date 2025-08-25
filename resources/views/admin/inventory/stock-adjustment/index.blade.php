@extends('adminlte::page')

@section('title', 'Stock Adjustment')

@section('content_header')
    <h1>Stock Adjustment</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns" >
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter" ><i class="fas fa-filter" ></i> Advance Filter</button>
        <a href="{{ route('admin.inventory.stock-adjustment.create') }}" class="btn btn-primary btn-sm" title="create"><i class="fas fa-plus" ></i> Create</a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="stockAdjAdvFilterPanel" >
    <form id="stockAdjAdvFilterForm" >
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
                    <option value="">- Select -</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->client_id }}">{{ $client->client_name }}</option>
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
        <div class="col-md-1" >
            <div class="input-dgroup">
                <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" />
            </div>
        </div>
    </div>
</div>

<!-- List View with Filters -->
<div class="card page-list-panel" >
    <div class="card-body">
        <table id="stockAdjListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>Doc. No.</th>
                    <th>Doc. Date</th>
                    <th>Client</th>
                    <th>Nos of Items</th>
                    <th>Total Qty</th>
                    <th>Status</th>
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
        if($('#stockAdjAdvFilterPanel').is(':visible'))
            $('#stockAdjAdvFilterPanel').hide();
        else
            $('#stockAdjAdvFilterPanel').show();
    });

    $(document).on("click", "#cancelFltrBtn", function () {
        const form = $('#stockAdjAdvFilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        table.ajax.reload();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeFltrBtn", function () {
        const form = $('#stockAdjAdvFilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        form.find('input[name="_method"]').remove();
        document.getElementById('stockAdjAdvFilterPanel').style.display = 'none';
    });

    $(document).on("submit", '#stockAdjAdvFilterForm', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
    /***** End : Advance Filter *****/

    let table =  $('#stockAdjListTable').DataTable({
        pageLength: 20,
        searching: false, 
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.inventory.stock-adjustment.index") }}',
            data: function (d) {
                let range = $('#fltrDateRangePicker').val();
                if (range) {
                    let dates = range.split(' - ');

                    // Function to convert dd/mm/yyyy to yyyy-mm-dd
                    function formatDate(dateStr) {
                        let parts = dateStr.split('/');
                        return `${parts[2]}-${parts[1]}-${parts[0]}`; // yyyy-mm-dd
                    }

                    d.from_date = formatDate(dates[0]);
                    d.to_date = formatDate(dates[1]);
                }
                d.client_flt = $('#clientFlt').val();
                d.quick_search = $('#fltrSearchBox').val();
            }
        },
        
        columns: [
            { data: 'doc_no', name: 'doc_no', width: '15%', orderable: false, searchable: true },
            { data: 'doc_date', name: 'doc_date', width: '15%', orderable: false, searchable: true },
            { data: 'client.client_name', name: 'client.client_name', width: '25%', orderable: false, searchable: true },
            { data: 'no_of_items', name: 'no_of_items', width: '10%', orderable: false, searchable: false },
            { data: 'total_package_qty', name: 'tot_package_qty', width: '10%', orderable: false, searchable: false },
            { data: 'status', name: 'status', width: '10%', orderable: false, searchable: false },
            { data: 'action', name: 'action', width: '15%', orderable: false, searchable: false },
        ],
        columnDefs: [
            {
                targets: [3,4,5],
                className: 'text-center'
            }
        ]
    });

    $(document).on("submit", '#stockAdjListTable', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    $(document).on('apply.daterangepicker', '#fltrDateRangePicker', function(ev, picker) {
        table.draw();
    });
});
</script>
@endsection
