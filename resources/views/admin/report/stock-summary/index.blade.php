@extends('adminlte::page')

@section('title', 'Report : Stock Summary Report')

@section('content_header')
    <h1>Report : Stock Summary Report</h1>
@stop

@section('content')

    <!-- Toggle between Views -->
    <div class="page-sub-header">
        <h3>List</h3>
        <div class="action-btns" >
            <button class="btn btn-print" onclick="printPDF()" title="Print PDF"><i class="fas fa-print" ></i> Print</button>        
        </div>
    </div>

    <!-- Quick Filter -->
    <div class="page-quick-filter">
        <div class="row">
            <div class="col-md-1 fltr-title">
                <span>FILTER BY</span>
            </div>
            <div class="col-md-3 d-none">
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

    <div class="card page-list-panel" >
        <div class="card-body">
            <table id="stockSummaryTable" class="report-list-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Varity</th>
                        <th>Lot No.</th>
                        <th>Rate Type</th>
                        <th>UOM</th>
                        <th>SubUom</th>
                        <!-- <th>Rooms</th>
                        <th>Racks</th> -->
                        <th>Slots</th>
                        <th>Pallets</th>
                        <th>No of Pallets</th>
                        <th>In Qty</th>
                        <th>Out Qty</th>
                        <th>Closing Qty</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="total-row" >
                        <th colspan="8" class="text-center" >Page Total:</th>
                        <th id="pallet_count_page_total" ></th>
                        <th id="in_quantity_page_total" ></th>
                        <th id="out_quantity_page_total" ></th>
                        <th id="total_quantity_page_total" ></th>
                    </tr>
                    <tr class="total-row" >
                        <th colspan="8" class="text-center" >Grand Total:</th>
                        <th id="pallet_count_grand_total" class="text-center" ></th>
                        <th id="in_quantity_grand_total" class="text-center" ></th>
                        <th id="out_quantity_grand_total" class="text-center" ></th>
                        <th id="total_quantity_grand_total" class="text-center" ></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop

@section('js')    
<script>
    $(document).ready(function() {

        /***** Start : Quick Filter *****/
        // $('#fltrDateRangePicker').daterangepicker({
        //     opens: 'right',
        //     autoUpdateInput: true,
        //     locale: {
        //         format: 'DD/MM/YYYY',
        //         cancelLabel: 'Clear'
        //     },
        //     startDate: moment().subtract(2, 'months'),
        //     endDate: moment(),
        //     ranges: {
        //         'Today': [moment(), moment()],
        //         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //         'This Month': [moment().startOf('month'), moment().endOf('month')],
        //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //     }
        // });

        $(document).on('click', '#fltrSearchBtn', function () {
            table.ajax.reload();
        });
        /***** End : Quick Filter *****/

        /***** Start : Data Table *****/
        const table = $('#stockSummaryTable').DataTable({
            lengthMenu: [10, 20, 50, 100],
            pageLength: 20,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.report.stock-summary.index') }}",
                data: function (d) {
                    let range = $('#fltrDateRangePicker').val();
                    if (range) {
                        // let dates = range.split(' - ');

                        // // Function to convert dd/mm/yyyy to yyyy-mm-dd
                        // function formatDate(dateStr) {
                        //     let parts = dateStr.split('/');
                        //     return `${parts[2]}-${parts[1]}-${parts[0]}`; // yyyy-mm-dd
                        // }

                        // d.from_date = formatDate(dates[0]);
                        // d.to_date = formatDate(dates[1]);
                    }
                    d.search_term = $('#fltrSearchBox').val();
                }
            },
            columns: [
                { data: 'product_name', name: 'product_name' },
                { data: 'category_name', name: 'category_name', defaultContent: ' '},
                { data: 'batch_no', name: 'batch_no' },
                { data: 'RateType', name: 'RateType', defaultContent: 'Monthly' },
                { data: 'UOM', name: 'UOM' },
                { data: 'SubUOM', name: 'SubUOM' },
                // { data: 'rooms', name: 'rooms', defaultContent: 'No Room' },
                // { data: 'racks', name: 'racks', defaultContent: ' ' },
                { data: 'slot_positions', name: 'slot_positions', defaultContent: ' ' },
                { data: 'pallets', name: 'pallets', defaultContent: '' },
                { data: 'pallet_count', name: 'pallet_count', defaultContent: '' },
                { data: 'in_quantity', name: 'in_quantity' },
                { data: 'out_quantity', name: 'out_quantity' },
                { data: 'total_quantity', name: 'total_quantity' },
            ],
            columnDefs: [
                {
                    targets: [3, 4, 5, 6, 7, 8, 9, 10, 11], 
                    className: 'text-center' 
                }
            ],
            // order: [[1, 'desc']],
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                function intVal(i) {
                    return typeof i === 'string'
                        ? parseFloat(i.replace(/[^0-9.-]+/g, ''))
                        : typeof i === 'number'
                            ? i
                            : 0;
                }

                const palletCountCol = 8;
                const inQtyCol = 9;
                const outQtyCol = 10;
                const totalQtyCol = 11;

                // Page Totals
                let pagePallet = api.column(palletCountCol, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let pageIn = api.column(inQtyCol, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let pageOut = api.column(outQtyCol, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let pageTotal = api.column(totalQtyCol, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

                // Grand Totals (all pages)
                let grandPallet = api.column(palletCountCol).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let grandIn = api.column(inQtyCol).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let grandOut = api.column(outQtyCol).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let grandTotal = api.column(totalQtyCol).data().reduce((a, b) => intVal(a) + intVal(b), 0);

                // Set page total values
                $('#pallet_count_page_total').html(pagePallet.toLocaleString());
                $('#in_quantity_page_total').html(pageIn.toLocaleString());
                $('#out_quantity_page_total').html(pageOut.toLocaleString());
                $('#total_quantity_page_total').html(pageTotal.toLocaleString());

                // Set grand total values
                $('#pallet_count_grand_total').html(grandPallet.toLocaleString());
                $('#in_quantity_grand_total').html(grandIn.toLocaleString());
                $('#out_quantity_grand_total').html(grandOut.toLocaleString());
                $('#total_quantity_grand_total').html(grandTotal.toLocaleString());
            }

        });
        /***** End : Data Table *****/
    });

    // function printPDF() {
    //     var html = '';
        
    //     html += "<html><head><title>Stock Summary</title></head><body>";

    //     // Header
    //     html += "<table border='0' style='width:100%;' >";
    //         html += "<tr>";
    //             html += "<th style='font-size:28px; width:50%; text-align:left;' >PJJ Fruits</th>";
    //             html += "<th style='font-size:18px; width:50%; text-align:center;' >PJJ INTERNATIONAL<br />P.J.J BUILDING<br />NEAR RIVER VIEW ROAD<br />PALA, KOTTAYAM - 686575</th>";
    //         html += "</tr>";
    //         html += "<tr>";
    //             html += "<th colspan='2' style='font-size:18px; padding:6px 0; width:100%; text-align:center; font-weight:bold; background-color:#CCC !important; color:#000;' >STOCK SUMMARY</th>";
    //         html += "</tr>";
    //         html += "<tr>";
    //             html += "<th colspan='2' style='font-size:16px; padding:8px 0; width:100%; text-align:left;' >Party : Supplier Name</th>";
    //         html += "</tr>";
    //     html += "</table>";

    //     // Data
    //     html += "<table border='0' class='print-tbl-items' >";
    //     $('#stockSummaryTable thead tr').each(function(){
    //         html += "<tr>";
    //             $(this).find('th').each(function(){
    //                 html += "<th class='" + $(this).attr('class') + "' >" + $(this).text() + "</th>";
    //             }); 
    //         html += "</tr>";
    //     });
    //     $('#stockSummaryTable tbody tr').each(function(){
    //         html += "<tr>";
    //             $(this).find('td').each(function(){
    //                 html += "<td class='" + $(this).attr('class') + "' >" + $(this).text() + "</td>";
    //             }); 
    //         html += "</tr>";
    //     });
    //     html += "</table>";

    //     html += "</body></html>";

    //     html += "<style>";
    //     html += " .print-tbl-items { width:100%; font-size:12px; } ";
    //     html += " .print-tbl-items th { font-size:12px; text-align:left; font-weight:bold; border-top:1px solid #000; padding:8px 2px; } ";
    //     html += " .print-tbl-items td { font-size:12px; text-align:left; border-top:1px solid #000; padding:6px 2px; } ";
    //     html += " .text-center { text-align:center !important; }";
    //     html += "</style>";

    //     console.log(html);

    //     // Open new window
    //     var printWindow = window.open('', '', 'height=600,width=800');
    //     printWindow.document.write(html);
    //     printWindow.document.close();
    //     printWindow.focus();
    //     printWindow.print();
    //     printWindow.close();
    // }

    function printPDF() {
        window.open("{{ route('admin.report.stock-summary.print') }}", '_blank');
    }

</script>
@stop
