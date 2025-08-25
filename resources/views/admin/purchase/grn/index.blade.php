@extends('adminlte::page')

@section('title', 'Inward List')

@section('content_header')
    <h1>Inward</h1>
@stop

@section('content')

    @include('admin.purchase.grn.modal')

    <div class="page-sub-header" >
        <h3>List</h3>
        <div class="action-btns" >
            <a class="btn btn-adv-filter" href="#" title="Filter" id="hdrAdvFilterBtn" ><i class="fas fa-filter" ></i> Advance Filter</a> 
            <a class="btn btn-sync" href="#" title="Sync GRN From PJJ ERP" id="hdrGRNSyncBtn" ><i class="fas fa-sync" ></i> Sync</a>
            <a class="btn btn-import" href="#" title="import" id="hdrImportBtn" ><i class="fas fa-file-import" ></i> Import</a>
        </div>
    </div>

    <!-- Advance Filter -->
    <div class="page-advance-filter" id="grnAdvFilterPanel" >
        <form id="grnAdvFilterForm" >
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
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text pq-fltr-icon"><i class="fas fa-search fa-lg"></i></span>
                    </div>
                    <input type="text" id="fltrSearchBox" class="form-control pq-fltr-input" placeholder="Type supplier" >
                </div>
            </div>
            <div class="col-md-1">
                <div class="input-group">
                    <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" />
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card page-list-panel" >
        <div class="card-body">
            <table id="grnTable" class="page-list-table">
                <thead>
                    <tr>
                        <th>Ref. No</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Invoice #</th>
                        <th>Amount</th>
                        <th></th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <th><input type="text" class="form-control column-search" placeholder="Search"></th></th>
                        <th></th>
                        <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                        <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                        <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="syncGRNFromPJJERPModal" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-md" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sync GRN From PJJ ERP</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="justify-content-between" >
                        <div class="row" >
                            <div class="col-md-6" >
                                From : <input type="date" id="modalSyncFromDate" value="{{$defaultDate}}" style="padding:4px; width:70%; border:1px solid #CCC; border-radius:3px;" />
                            </div>
                            <div class="col-md-6" >
                                To : <input type="date" id="modalSyncToDate" value="{{$defaultDate}}" style="padding:4px; width:70%; border:1px solid #CCC; border-radius:3px;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-cancel" data-dismiss="modal" >Cancel</button>
                    <button type="button" id="modalGRNSyncBtn" class="btn btn-save" >Sync GRN</button>
                </div>
            </div>
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
            startDate: moment().subtract(15, 'days'),
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
            if($('#grnAdvFilterPanel').is(':visible'))
                $('#grnAdvFilterPanel').hide();
            else
                $('#grnAdvFilterPanel').show();
        });
        $(document).on("click", "#cancelFltrBtn", function () {
            const form = $('#grnAdvFilterForm');
            form.find('input[type="text"], input[type="number"]').val('');
            form.find('select').val('');
            table.ajax.reload();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $(document).on("click", "#closeFltrBtn", function () {
            const form = $('#grnAdvFilterForm');
            form.find('input[type="text"], input[type="number"]').val('');
            form.find('select').val('');
            form.find('input[name="_method"]').remove();
            document.getElementById('grnFilterDiv').style.display = 'none';
        });

        $(document).on("submit", '#grnAdvFilterForm', function(e) {
            e.preventDefault();
            table.ajax.reload();
        });
        /***** End : Advance Filter *****/

        /***** Start : Import *****/
        $(document).on("click", '#hdrImportBtn', function(e) {
            e.preventDefault();
        });
        /***** End : Import *****/

        /***** Start : Sync *****/
        $(document).on("click", '#hdrGRNSyncBtn', function(e) {
            e.preventDefault();
            $('#syncGRNFromPJJERPModal').modal();
        });

        $(document).on("click", '#hdrGRNSyncBtn', function(e) {
            e.preventDefault();
            $('#syncGRNFromPJJERPModal').modal();
        });
        
        $(document).on("click", '#modalGRNSyncBtn', function(e) {
            e.preventDefault();
            var fromDate = $('#modalSyncFromDate').val();
            var toDate = $('#modalSyncToDate').val();
            if($('#modalGRNSyncBtn').text() == 'Sync GRN') {
                $('#modalGRNSyncBtn').text('Please Wait...');
                $.ajax({
                    url: "{{ route('admin.purchase.grn.sync') }}",
                    type: "POST",
                    data : {fromDate : fromDate, toDate : toDate},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#modalGRNSyncBtn').text('Sync GRN');
                        $('#syncGRNFromPJJERPModal').modal('hide');
                        toastr.success(response.message || 'GRN Synced Successfully!');
                        console.log(response);
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        $('#modalGRNSyncBtn').text('Sync GRN');
                        console.error('Error:', xhr.responseText);
                        toastr.error(response.message || 'Error in GRN Syncing!');
                    }
                });
            }
        });
        /***** End : Sync *****/

        /***** Start : Data Table *****/
        let table = $('#grnTable').DataTable({
            lengthMenu: [10, 20, 50, 100],
            pageLength: 20,
            searching: true, 
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.purchase.grn.index') }}",
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

                    d.status = $('#fltrStatus').val();
                    d.quick_search = $('#fltrSearchBox').val();
                }
            },
            columns: [
                { data: 'GRNNo', name: 'GRNNo', width: '10%' },
                { data: 'GRNDate', name: 'GRNDate', width: '10%' },
                { data: 'supplier.supplier_name', name: 'supplier.supplier_name', width: '25%' },
                { data: 'InvoiceNumber', name: 'InvoiceNumber', width: '20%' },
                { data: 'Amount', name: 'Amount', width: '10%' },
                { data: 'assigned_progress', name: 'assigned_progress', width: '10%' },
                { data: 'status', name: 'status', width: '10%' },
                { data: 'actions', name: 'actions', width: '5%', orderable: false, searchable: false },
            ],
            columnDefs: [
                {
                    targets: 4,
                    className: 'text-right'
                },
                {
                    targets: 5,
                    className: 'text-center'
                },
                {
                    targets: 6,
                    className: 'text-center'
                },
                {
                    targets: 7,
                    className: 'text-center'
                }
            ],
            order: [[1, 'desc']],
        });
        /***** End : Data Table *****/

         $('#grnTable thead').on('keyup change', '.column-search', function () {
            let colIndex = $(this).parent().index();
            table.column(colIndex).search(this.value).draw();
        });
    });

</script>
@stop
