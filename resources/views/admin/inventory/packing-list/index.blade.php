@extends('adminlte::page')

@section('title', 'Packing List')

@section('content_header')
    <h1>Packing List</h1>
@stop

@section('content')
    <div class="page-sub-header" >
        <h3>List</h3>
        <div class="action-btns" >
            <a class="btn btn-adv-filter" href="#" title="Filter" id="hdrAdvFilterBtn" ><i class="fas fa-filter" ></i> Advance Filter</a> 
            <a class="btn btn-import" href="#" title="import" id="hdrImportBtn" ><i class="fas fa-file-import" ></i> Import</a>
            <a href="{{ route('admin.inventory.packing-list.create') }}" class="btn btn-create"><i class="fas fa-plus"></i> Create</a>
        </div>
    </div>

    <!-- Advance Filter -->
    <div class="page-advance-filter" id="packAdvFilterPanel" >
        <form id="packAdvFilterForm" >
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
                    <select id="fltrStatus" class="form-control pq-fltr-select" >
                        <option value="">- All Status -</option>
                        <option value="1">Assigned</option>
                        <option value="0">Not Assigned</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text pq-fltr-icon"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <select id="clientFlt" class="form-control pq-fltr-select">
                        <option value="">- Select Client-</option>
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
                    <input type="text" id="fltrSearchBox" class="form-control pq-fltr-input" placeholder="Type" >
                </div>
            </div>
            <div class="col-md-1">
                <div class="input-group">
                    <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" />
                </div>
            </div>
        </div>
    </div>

    <div class="card page-list-panel" >
        <div class="card-body">
            <table id="packingListTable" class="page-list-table">
                <thead>
                    <tr>
                        <th>Doc. #</th>
                        <th>Doc. Date</th>
                        <th>Inv. #</th>
                        <th>Inv. Date</th>
                        <th>Client</th>
                        <th>Palletization Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
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
        if($('#packAdvFilterPanel').is(':visible'))
            $('#packAdvFilterPanel').hide();
        else
            $('#packAdvFilterPanel').show();
    });

    $(document).on("submit", '#packAdvFilterForm', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
    /***** End : Advance Filter *****/

    let table = $('#packingListTable').DataTable({
        lengthMenu: [10, 20, 50, 100],
        pageLength: 20,
        searching: false,
        processing: false,
        serverSide: false,
        data: [
            {
                doc_no: 'PL‑25‑00012',
                doc_date: '26/08/2025',
                invoice_no: 'INV‑25‑0010',
                invoice_date: '25/08/2025',
                client: { client_name: 'Ocean Fresh Exports Pvt Ltd' },
                palletization: 33,
                status: 'Assigned',
                actions: `
                    <a href="{{ route('admin.inventory.packing-list.edit', 1) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.inventory.packing-list.print', 1) }}" target="_blank" class="btn btn-sm btn-print">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="{{ route('admin.inventory.packing-list.view', 1) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                `
            },
            {
                doc_no: 'PL‑25‑00011',
                doc_date: '20/08/2025',
                invoice_no: 'INV‑25‑0009',
                invoice_date: '19/08/2025',
                client: { client_name: 'Blue Ocean Seafood Traders' },
                palletization: 0,
                status: 'Not Assigned',
                actions: `
                    <a href="{{ route('admin.inventory.gatepass-in.edit', 2) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.inventory.gatepass-in.print', 2) }}" target="_blank" class="btn btn-sm btn-print">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="{{ route('admin.inventory.gatepass-in.view', 2) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                `
            },
            {
                doc_no: 'PL‑25‑00010',
                doc_date: '18/08/2025',
                invoice_no: 'INV‑25‑0008',
                invoice_date: '17/08/2025',
                client: { client_name: 'Southern Catch Logistics' },
                palletization: 100,
                status: 'Completed',
                actions: `
                    <a href="{{ route('admin.inventory.packing-list.edit', 3) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.inventory.packing-list.print', 3) }}" target="_blank" class="btn btn-sm btn-print">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="{{ route('admin.inventory.packing-list.view', 3) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                `
            }
        ],
        columns: [
            { data: 'doc_no', name: 'doc_no' },
            { data: 'doc_date', name: 'doc_date' },
            { data: 'invoice_no', name: 'invoice_no' },
            { data: 'invoice_date', name: 'invoice_date' },
            { data: 'client.client_name', name: 'client.client_name' },
            {
                data: 'palletization',
                name: 'palletization',
                render: function(data, type, row) {
                    const percent = parseInt(data);
                    let color = '#ccc';
                    if (percent >= 75) color = '#4caf50';
                    else if (percent >= 50) color = '#ffeb3b';
                    else if (percent > 0) color = '#ff9800';
                    return `
                        <div style="width: 60px; height: 14px; border: 1px solid #999; border-radius: 3px; background: #f1f1f1; position: relative;">
                            <div style="width: ${percent}%; height: 100%; background: ${color}; border-radius: 2px;"></div>
                        </div>
                        <small style="display:block; text-align:center; font-size:10px;">${percent}%</small>
                    `;
                }
            },
            { data: 'status', name: 'status' },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    let html = data;

                    if (parseInt(row.palletization) === 100) {
                        html += `
                            <a href="/admin/purchase/grn/create?ref=${row.doc_no}" class="btn btn-success btn-sm mt-1">
                                <i class="fas fa-file-invoice"></i> Create GRN
                            </a>
                        `;
                    }

                    return html;
                }
            }
        ],
        columnDefs: [
            { targets: 5, className: 'text-center' },
            { targets: 6, className: 'text-center' }
        ],
        order: [[0, 'desc']]
    });

    $(document).on("click", "#cancelFltrBtn", function () {
        const form = $('#packAdvFilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        table.ajax.reload();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeFltrBtn", function () {
        const form = $('#packAdvFilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        form.find('input[name="_method"]').remove();
        document.getElementById('packAdvFilterPanel').style.display = 'none';
    });

});
</script>
@stop
