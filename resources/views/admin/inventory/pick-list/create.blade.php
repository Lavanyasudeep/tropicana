@extends('adminlte::page')

@section('title', 'Create Pick List')

@section('content_header')
    <h1>Pick List</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Create</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.pick-list.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.pick-list.store') }}">
         @csrf
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:195px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" name="doc_no" value="" readonly>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. Date</div>
                            <div class="pform-value" >
                                <input type="date" id="doc_date" name="doc_date" value="@php echo date('Y-m-d') @endphp" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Dispatch Date</div>
                            <div class="pform-value" >
                                <input type="date" id="dispatch_date" name="dispatch_date" value="@php echo date('Y-m-d') @endphp" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Dispatch Location</div>
                            <div class="pform-value" >
                                <textarea name="dispatch_location" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:195px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Client</div>
                            <div class="pform-value" >
                                <select name="client_id" id="client_id">
                                    <option value="">- Select -</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->client_id }}" selected >{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Name</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_name" name="contact_name" value="" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Address</div>
                            <div class="pform-value" >
                                <textarea name="contact_address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="pform-row d-none" >
                            <div class="pform-label" >Total Quantity to Pick</div>
                            <div class="pform-value" >
                                <input type="number" id="total_qty" name="total_qty" value="" >
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <!-- <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Product</div>
                            <div class="pform-value" >
                                <select name="package_type_id" id="package_type_id">
                                    <option value="">- Select -</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->product_master_id }}">{{ $product->product_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Variety</div>
                            <div class="pform-value" >
                                <select name="variety_id" id="variety_id">
                                    <option value="">- Select -</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->ProductCategoryID }}">
                                            {{ $category->ProductCategoryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Brand</div>
                            <div class="pform-value" >
                                <select name="brand_id" id="brand_id">
                                    <option value="">- Select -</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_id }}">
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div> -->
            </div>

            <div class="row" >
                <div class="col-md-12" >
                    <div class="page-list-panel" >
                        <table class="page-list-table" id="pickListCreateTable" >
                            <thead>
                                <tr>
                                    <th>Pick</th>
                                    <!-- <th>Room</th>
                                    <th>Rack</th> -->
                                    <th>Slot</th>
                                    <th>Pallet</th>
                                    <th>Product</th>
                                    <th>Lot No.</th>
                                    <!-- <th>Client Name</th> -->
                                    <th>No. of Packages</th>
                                    <th>Selected Qty</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <!-- <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th> -->
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <!-- <th><input type="text" class="form-control column-search" placeholder="Search Client"></th> -->
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <th colspan="6" class="text-right" >Total Selected :</th>
                                    <th id="total_picked_qty" class="text-center"></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-save btn-sm float-right" id="submitPickList" disabled >Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('css')
<style>
</style>
@stop

@section('js')
<script>
    $(document).ready(function () {
        let pickedTotal = 0;
        let totalAllowed = 0;

        let table = $('#pickListCreateTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [10, 20, 50, 100],
            pageLength: 20,
            ajax: {
                url: '{{ route("admin.inventory.pick-list.create") }}',
                data: function (d) {
                    d.client_id = $('#client_id').val(); // pass client_id to server
                }
            },
            language: {
                emptyTable: "Please select a client to display data."
            },
            columns: [
                { data: 'pick', name: 'pick', width: '5%', orderable: false, searchable: false },
                // { data: 'room.name', name: 'room.name', width: '10%' },
                // { data: 'rack.name', name: 'rack.name', width: '10%' },
                // { data: 'slot.name', name: 'slot.name', width: '10%' },
                { data: 'slot_position', name: 'slot_position', width: '10%' },
                { data: 'pallet.pallet_no', name: 'pallet.pallet_no', width: '10%' },
                { data: 'product_name', name: 'product_name', width: '25%' },
                { data: 'batch_no', name: 'batch_no', width: '30%' },
                { data: 'available_qty', name: 'available_qty', width: '10%' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    defaultContent: '',
                    className: 'pick-qty',
                    render: function () {
                        return '<input type="text" class="form-control text-center selected-qty" min="0" value="0" data-prev="0" readonly >';
                    }
                }
            ],
            columnDefs: [
                {
                    targets: [0, 1, 2, 4, 5],
                    className: 'text-center'
                }
            ],
            order: [[0, 'desc']],
            initComplete: function () {
                // optional: only clear on initial load
                // table.clear().draw();
            }
        });

        $('#pickListCreateTable thead').on('keyup change', '.column-search', function () {
            let colIndex = $(this).parent().index();
            table.column(colIndex).search(this.value).draw();
        });

        $(document).on('input', '#total_qty', function () {
            totalAllowed = parseInt($(this).val()) || 0;
            pickedTotal = 0;
            $('.pick-check').prop('checked', false).prop('disabled', false);
            $('.selected-qty').val(0).prop('disabled', true);
            $('#submitPickList').prop('disabled', true);
        });

        $(document).on('change', '.pick-check', function () {
            const row = $(this).closest('tr');
            const packageQty = parseInt($(this).data('package-qty')) || 0;

            // if ($(this).is(':checked')) {
            //     const remaining = totalAllowed - pickedTotal;
            //     const assignQty = Math.min(remaining, packageQty);
            //     row.find('.selected-qty').val(assignQty).prop('disabled', false).data('prev', assignQty);
            //     pickedTotal += assignQty;
            // } else {
            //     const prevQty = parseInt(row.find('.selected-qty').val()) || 0;
            //     pickedTotal -= prevQty;
            //     row.find('.selected-qty').val(0).prop('disabled', true).data('prev', 0);
            // }
            if($(this).is(':checked'))
                row.find('.selected-qty').val(packageQty);
            else
                row.find('.selected-qty').val('0');

            //updateCheckboxStates();
            checkSubmitEnabled();
        });

        // $(document).on('input', '.selected-qty', function () {
        //     const input = $(this);
        //     const newVal = parseInt(input.val()) || 0;
        //     const prevVal = parseInt(input.data('prev')) || 0;
        //     const row = input.closest('tr');
        //     const maxVal = parseInt(row.find('.pick-check').data('package-qty')) || 0;

        //     // Limit to max available per pallet
        //     if (newVal > maxVal) {
        //         input.val(maxVal);
        //         pickedTotal += (maxVal - prevVal);
        //     } else {
        //         pickedTotal += (newVal - prevVal);
        //     }

        //     input.data('prev', newVal);
        //     //updateCheckboxStates();
        //     checkSubmitEnabled();
        // });

        $('#submitPickList').on('click', function (e) {
            // Remove previous hidden fields
            $('form').find('.dynamic-hidden').remove();

            let index = 0;

            $('#pickListCreateTable tbody tr').each(function () {
                const checkbox = $(this).find('.pick-check');
                const qtyInput = $(this).find('.selected-qty');

                if (checkbox.is(':checked')) {
                    const packingListDtlId = checkbox.data('packing-list-detail-id');
                    const palletId = checkbox.data('pallet-id');
                    const qty = qtyInput.val();

                    $('form').append(`<input type="hidden" name="selected_items[${index}][pallet_id]" value="${palletId}" class="dynamic-hidden">`);
                    $('form').append(`<input type="hidden" name="selected_items[${index}][packing_list_detail_id]" value="${packingListDtlId}" class="dynamic-hidden">`);
                    $('form').append(`<input type="hidden" name="selected_items[${index}][pick_qty]" value="${qty}" class="dynamic-hidden">`);
                    index++;
                }
            });
        });

        function updateCheckboxStates() {
            $('.pick-check').each(function () {
                const row = $(this).closest('tr');
                const packageQty = parseInt($(this).data('package-qty')) || 0;
                const input = row.find('.selected-qty');
                const remaining = totalAllowed - pickedTotal;

                if (!$(this).is(':checked')) {
                    if (remaining <= 0) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                } else {
                    input.prop('disabled', false);
                }
            });
        }

        function checkSubmitEnabled() {
            var totQty = 0;
            $('.pick-check').each(function () {
                if ($(this).is(':checked')) {
                    totQty += parseFloat($(this).data('package-qty'));
                }
            });
            $('#total_qty').val(totQty);
            $('#total_picked_qty').text(totQty);

            if(totQty>0)
                $('#submitPickList').prop('disabled', false);
            else
                $('#submitPickList').prop('disabled', true);
            //$('#submitPickList').prop('disabled', pickedTotal <= 0 || pickedTotal > totalAllowed || pickedTotal < totalAllowed);
            //$('#submitPickList').prop('disabled', pickedTotal <= 0);
        }

        // On client change, reload table
        $('#client_id').on('change', function () {
            table.ajax.reload();
        });

    });
</script>
@stop