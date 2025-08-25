@extends('adminlte::page')

@section('title', 'Journal')

@section('content_header')
    <h1>Journal</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns" >
        <button class="btn btn-secondary" onclick="toggleView('filter')" title="Filter" ><i class="fas fa-filter" ></i> Advance Filter</button>
        <a href="{{ route('admin.accounting.journal.create') }}" class="btn btn-primary btn-sm" title="create"><i class="fas fa-plus" ></i> Create</a>
    </div>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="journalAdvFilterPanel" >
    <form id="journalAdvFilterForm" >
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
        <div class="col-md-2">
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
                <select id="fltrBranch" class="form-control pq-fltr-select" >
                    <option value="">- All Branches -</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon" ><i class="fas fa-chevron-down"></i></span>
                </div>
                <select id="fltrDepartment" class="form-control pq-fltr-select" >
                    <option value="">- All Department -</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
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
        <div class="col-md-2">
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

<!-- List View with Filters -->
<div class="card page-list-panel" >
    <div class="card-body">
        <table id="journalListTable" class="page-list-table">
            <thead>
                <tr>
                    <th>Doc. No.</th>
                    <th>Doc. Date</th>
                    <th>Created Date</th>
                    <th>Branch</th>
                    <th>Department</th>
                    <th>Account</th>
                    <th>Narration</th>
                    <th>Amount</th>
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
        if($('#journalAdvFilterPanel').is(':visible'))
            $('#journalAdvFilterPanel').hide();
        else
            $('#journalAdvFilterPanel').show();
    });

    $(document).on("click", "#cancelFltrBtn", function () {
        const form = $('#journalAdvFilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        table.ajax.reload();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeFltrBtn", function () {
        const form = $('#journalAdvFilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        form.find('input[name="_method"]').remove();
        document.getElementById('journalAdvFilterPanel').style.display = 'none';
    });

    $(document).on("submit", '#journalAdvFilterForm', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
    /***** End : Advance Filter *****/

    let table =  $('#journalListTable').DataTable({
        lengthMenu: [10, 20, 50, 100],
        pageLength: 20,
        searching: false, 
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.accounting.journal.index") }}',
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
                d.quick_search = $('#fltrSearchBox').val();
                d.branch_id = $('#fltrBranch').val();
                d.department_id = $('#fltrDepartment').val();
                d.status = $('#fltrStatus').val();
            }
        },
        
        columns: [
            { data: 'doc_no', name: 'doc_no', width: '8%'},
            { data: 'doc_date', name: 'doc_date', width: '8%'},
            { data: 'created_at', name: 'created_at', width: '8%'},
            { data: 'branch.branch_name', name: 'branch.branch_name', width: '5%'},
            { data: 'department.department_name', name: 'department.department_name', width: '15%'},
            { data: 'accounts', name: 'accounts', width: '15%'},
            { data: 'narrations', name: 'narrations', width: '10%'},
            { data: 'amount', name: 'amount', width: '10%'},
            { data: 'status', name: 'status', width: '10%'},
            { data: 'action', name: 'action', width: '14%'},
        ],
        columnDefs: [
            {
                targets: [7],
                className: 'text-right'
            }
        ]
    });

    $(document).on("submit", '#journalListTable', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    $(document).on('apply.daterangepicker', '#fltrDateRangePicker', function(ev, picker) {
        table.draw();
    });
});
</script>
@endsection
