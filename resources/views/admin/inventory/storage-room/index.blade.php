@extends('adminlte::page')

@section('title', 'Storage Room')

@section('content_header')
    <h1>Manage Storage Room</h1>
@stop

@section('content')
<div class="row " id="roomFilterDiv" style="display:none;">
    <!-- Storage Room Filter Form -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">Filter</h3>
            </div>
            <div class="card-body">
                <form id="roomfilterForm" class="mb-3 row">
                    <div class="col-md-2">
                        <input type="date" name="date" class="form-control" placeholder="Date">
                    </div>
                    <!-- <div class="col-md-2">
                        <select name="in_out" class="form-control">
                            <option value="">In/Out</option>
                            <option value="in">In</option>
                            <option value="out">Out</option>
                        </select>
                    </div> -->
                    <div class="col-md-3">
                        <input type="text" name="product" class="form-control" placeholder="Product">
                    </div>
                    <!-- <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">Status</option>
                            <option value="available">Available</option>
                            <option value="filled">Filled</option>
                        </select>
                    </div> -->
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success">Filter</button>
                        <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                        <button type="button" class="btn btn-default" id="closeEditBtn">Close</button>                            
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toggle between Views -->
<div class="page-sub-header" >
    <h3>List</h3>
    <div class="action-btns" >
        <!-- <a class="btn btn-secondary" href="{{ route('admin.bulk-import.new') }}" title="import" ><i class="fas fa-file-import" ></i></a> -->
        <button id="pickModeBtn" class="btn btn-secondary d-none"><i class="fas fa-dolly"></i> Start Picking</button>
        <button class="btn btn-adv-filter" onclick="toggleView('filter')" title="Filter" ><i class="fas fa-filter" ></i> Advance Filter</button>
        <button class="btn btn-view" onclick="toggleView('list')" title="List View" ><i class="fas fa-list" ></i> List View</button>
        <button class="btn btn-3dview" onclick="toggleView('3d')" title="3d View"><i class="fas fa-box" ></i> 3D View</button>        
    </div>
</div>

<!-- List View with Filters -->
<div id="storage-room-list-view" class="card page-list-panel"  style="display: none;">
    <div class="card-body">
        <div id="pickControls" class="mb-2 d-none">
            <label>Total Quantity to Pick:</label>
            <input type="number" id="totalQuantity" class="form-control d-inline w-25" min="1">
        </div>
        <table class="report-list-table" id="storageRoomTable" >
            <thead>
                <tr>
                    <th>Pick</th>
                    <th>Room</th>
                    <th>Rack</th>
                    <th>Slot</th>
                    <th>Pallet</th>
                    <th>Product</th>
                    <th>Batch No.</th>
                    <th>Client</th>
                    <th>In Qty</th>
                    <th>Out Qty</th>
                    <th>Available Qty</th>
                    <th>Selected Qty</th>
                </tr>
            </thead>
        </table>
        <button id="submitPickList" class="btn btn-success ml-2 d-none" disabled>Submit Pick List</button>
        <button id="cancelPickBtn" class="btn btn-secondary d-none">Cancel</button>
    </div>
</div>

<!-- 2D View -->    
<div id="view2D" class="card">
    <div class="card-body">
        <ul id="roomTabs" class="nav nav-tabs" >
            @foreach($rooms as $room)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-room-id="{{ $room->room_id }}" href="#">
                        {{ $room->name }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- 2D Rack View -->
        <div id="listRacks" >
            <p>Loading racks...</p>
        </div>

        <!-- Expanded Rack View -->
        <!-- <div id="rackDetailView" class="mt-3" >
            {{-- Filled when clicking a rack --}}
        </div> -->
        <div class="modal fade" id="rackDetailModal" tabindex="-1" aria-labelledby="rackDetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Rack Detail View</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="rackDetailView">
                        {{-- Content will be injected here dynamically --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop

@section('css')
<style>   
    #roomTabs { border-bottom: 1px solid #000; }
    #roomTabs li.nav-item {  }
    #roomTabs li.nav-item a { color:#000; }
    #roomTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #roomTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }
    
    #listRacks { padding:15px 0; background-color:#FFF; width: 100%; }

    .rackColumn { width:19.8%; height:auto; float:left; border:1px solid #555; padding:5px 5px 5px 5px; margin:0 0 10px 2px; overflow: auto; min-height: 318px;}
    .rackColumn .rackColumnName { font-size:14px; margin-bottom:5px; background-color: #9d0f0f; color: white; padding: 5px; text-align: center; }
    .rackColumn .slotRows { margin:0; padding:0; list-style-type: none; }
    .rackColumn .slotRows li { margin:0 0 -1px 0; padding:0; border:1px solid #CCC; float:left; width:20%; height:50px; position:relative; }
    .rackColumn .slotRows li:first-child { width:100%; height:25px; padding:5px; }
    .rackColumn .slotRows li:first-child span { font-size:12px; }
    .rackColumn .slotRows li label { font-weight:normal; font-size:9px; margin:0; width:100%; display: block; cursor:pointer; height: 100%;}
    .rackColumn .slotRows li label input { float:left; }
    .rackColumn .slotRows li label input[type="checkbox"] { display:none; }
    .rackColumn .slotRows li label span { float:left; display:inline-block; margin:-2px 0 0 5px; }
    .rackColumn .slotRows li.out-of-stock { background-color:#ef7676; }
    .rackColumn .slotRows li.out-of-stock label { color:#FFF; }
    .rackColumn .slotRows li.out-of-stock input { display:none; }
    .rackColumn .slotRows li:first-child label input[type="checkbox"] { display:block; }
    .rackColumn .slotRows li.out-of-stock label span { margin-left:18px; }

    .rackColumn .slotRows li.available { background-color: #EEE; }
    .rackColumn .slotRows li.selected { background-color: #32a616; }
    .rackColumn .slotRows li.picked { background-color: #36abe3; }
    .rackColumn .slotRows li.partial-stock { background-color:#f0b36b; }

    .rackColumn .slotRows li.partial-stock label { color:#FFF; }
    .rackColumn .slotRows li .rack-level-no { width: 100%; height: 94%; border-radius: 2px; margin: 0px 0px 0 0px; text-align: center; font-size: 14px; padding-top: 6px; }
    .rackColumn .slotRows li .rack-depth-no { width: 100%; height: 94%; border-radius: 2px; margin: 0px 0px 0 0px; text-align: center; font-size: 14px; padding-top: 6px; }

    .product-images {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-bottom: 6px;
        flex-wrap: wrap;
    }
    .product-icon{
        position: relative;
    }

    .product-icon svg {
        width: 40px;
        height: 34px;
    }

    .product-images.empty {
        width: 100%;
        height: 25px;
        border-radius: 2px;
    }
    .product-count {
        position: absolute;
        top: -4px;
        right: -7px;
        background-color: #0e0f0f;
        color: #fff;
        font-size: 9px;
        font-weight: bold;
        padding: 1px 3px;
        border-radius: 10px;
        z-index: 2;
    }

    .empty-slot {
        background-color: #f7f7f7;
    }

    .pallet-label {
        font-size: 11px;
        font-weight: bold;
        color: #555;
        margin-bottom: 4px;
        text-align: center;
        display: none;
    }

    .empty-slot-label {
        font-size: 11px;
        color: #aaa;
        display: block;
        text-align: center;
        padding-top: 8px;
    }

    .pallet-wrapper {
        position: absolute;
        display: inline-block;
        width:100%;
        height:100%;
        bottom:0;
    }

    .pallet-wrapper .pallet-label {
        position: absolute;
        bottom: 2px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(255, 255, 255, 0.85);
        padding: 2px 4px;
        font-size: 12px;
        font-weight: bold;
        color: #000;
        border-radius: 4px;
    }
    .pallet-wrapper .pallet-img { width:100%; height:100%; }
</style>
@stop

@section('js')
<script>

$(document).ready(function () {
    const firstRoomId = $('#roomTabs .nav-link.active').data('room-id');
    
    let pickedTotal = 0;
    let totalAllowed = 0;
 
    // Yajra DataTable
    const table = $('#storageRoomTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url: '{{ route("admin.inventory.storage-room.index") }}',
                data: function (d) {
                    d.date = $('input[name="date"]').val();
                    // d.in_out = $('select[name="in_out"]').val();
                    d.product = $('input[name="product"]').val();
                }
            },
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                defaultContent: '',
                className: 'pick-checkbox d-none',
                // render: function () {
                //     return '<input type="checkbox" class="pick-check">';
                // }
                render: function (data, type, row) {
                    return `
                        <input type="checkbox" class="pick-check" data-box="${row.quantity}">
                    `;
                }
            },
            { data: 'storage_room_name', name: 'storage_room_name', width:'8%', defaultContent: 'No Room' },
            { data: 'rack.name', name: 'rack.name', width:'8%', defaultContent: ' ' },
            { data: 'slot.name', name: 'slot.name', width:'8%', defaultContent: '' },
            { data: 'pallet.name', name: 'pallet.name', width:'8%', defaultContent: '' },
            { data: 'product.product_description', name: 'product.product_description', width:'20%', defaultContent: '' },
            { data: 'batch_no', name: 'batch_no', width:'20%', defaultContent: '' },
            { data: 'client_name', name: 'client_name', width:'10%', defaultContent: '' },
            { data: 'in_qty', className:'in_qty', width:'8%', name: 'in_qty', defaultContent: 0 },
            { data: 'out_qty', className:'out_qty', width:'8%', name: 'out_qty', defaultContent: 0 },
            { data: 'available_qty', className:'quantity', width:'8%', name: 'available_qty', defaultContent: '' },
            {
                data: null,
                orderable: false,
                searchable: false,
                defaultContent: '',
                className: 'pick-qty d-none',
                render: function () {
                    return '<input type="number" class="form-control selected-qty" min="0" value="0" data-prev="0">';
                }
            }
        ],
        columnDefs: [
            {
                targets: [0,1,2,3,4,8,9,10],
                className: 'text-center'
            }
        ],
        order: [[0, 'desc']],
        rowCallback: function (row, data) {
            $(row).attr('data-packing-list-detail-id', data.packing_list_detail_id);
            $(row).attr('data-room-id', data.room_id);
            $(row).attr('data-rack-id', data.rack_id);
            $(row).attr('data-slot-id', data.slot_id);
            $(row).attr('data-pallet-id', data.pallet_id);
        },
        drawCallback: function(settings) {
            showPickListItem();
        }
    });

    $(document).on('submit', '#roomfilterForm', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    $(document).on('input', 'input[type="search"]', function(e) {
        e.preventDefault();
    });

    $(document).on('click', '#roomTabs .nav-link', function (e) {
        e.preventDefault();
        $('#roomTabs .nav-link').removeClass('active');
        $(this).addClass('active');

        const roomId = $(this).data('room-id');
        $('#rackTabs').hide().empty();
        $('#rackDetailView').html('');

        loadRacks(roomId);
    });

    $(document).on('click', '#rackTabs .nav-link', function (e) {
        e.preventDefault();
        $('#rackTabs .nav-link').removeClass('active');
        $(this).addClass('active');

        const roomId = $('#roomTabs .nav-link.active').data('room-id');
        const rackId = $(this).data('rack-id');

        loadRackDetail(roomId, rackId);
    });

    $(document).on("click", "#cancelEditBtn", function () {
        const form = $('#roomfilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        table.ajax.reload();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeEditBtn", function () {
        const form = $('#roomfilterForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('select').val('');
        form.find('input[name="_method"]').remove();
        document.getElementById('roomFilterDiv').style.display = 'none';
    });

    $(document).on('click', '#pickModeBtn', function () {
        if(!$(this).hasClass('btn-primary')) {
            $(this).removeClass('btn-secondary').addClass('btn-primary');
        } else {
            $(this).removeClass('btn-primary').addClass('btn-secondary');
        }
        showPickListItem();
    });

    function showPickListItem() {
        if($('#pickModeBtn').hasClass('btn-primary')) {
            $('.pick-checkbox, .pick-qty').removeClass('d-none');
            $('#pickControls').removeClass('d-none');
            $('#submitPickList').removeClass('d-none');
            $('#cancelPickBtn').removeClass('d-none');
        } else {
            $('.pick-checkbox, .pick-qty').addClass('d-none');
            $('#pickControls').addClass('d-none');
            $('#submitPickList').addClass('d-none');
            $('#cancelPickBtn').addClass('d-none');
        }
    }

    $(document).on('click', '#cancelPickBtn', function () {
        pickedTotal = 0;
        $('.pick-checkbox, .pick-qty').addClass('d-none');
        $('#pickControls').addClass('d-none');
        $('#submitPickList').addClass('d-none');
        $('#cancelPickBtn').addClass('d-none');
        table.ajax.reload();
    });

    $(document).on('input', '#totalQuantity', function () {
        totalAllowed = parseInt($(this).val()) || 0;
        pickedTotal = 0;
        $('.pick-check').prop('checked', false).prop('disabled', false);
        $('.selected-qty').val(0).prop('disabled', true);
        $('#submitPickList').prop('disabled', true);
    });

    $(document).on('change', '.pick-check', function () {
        const row = $(this).closest('tr');
        const boxPerPallet = parseInt($(this).data('box')) || 0;

        if ($(this).is(':checked')) {
            const remaining = totalAllowed - pickedTotal;
            const assignQty = Math.min(remaining, boxPerPallet);
            row.find('.selected-qty').val(assignQty).prop('disabled', false).data('prev', assignQty);
            pickedTotal += assignQty;
        } else {
            const prevQty = parseInt(row.find('.selected-qty').val()) || 0;
            pickedTotal -= prevQty;
            row.find('.selected-qty').val(0).prop('disabled', true).data('prev', 0);
        }

        updateCheckboxStates();
        checkSubmitEnabled();
    });

    $(document).on('input', '.selected-qty', function () {
        const row = $(this).closest('tr');
        const prevQty = parseInt($(this).data('prev')) || 0;
        const newQty = parseInt($(this).val()) || 0;

        pickedTotal = pickedTotal - prevQty + newQty;
        $(this).data('prev', newQty);

        updateCheckboxStates();
        checkSubmitEnabled();
    });

    $(document).on('click', '#submitPickList', function () {
        let pickedItems = [];

        $('#storageRoomTable tbody tr').each(function () {
            const row = $(this);
            const isChecked = row.find('.pick-check').is(':checked');

            if (isChecked) {
                const item = {
                    packing_list_detail_id: row.data('packing-list-detail-id'),
                    room_id: row.data('room-id'),
                    rack_id: row.data('rack-id'),
                    slot_id: row.data('slot-id'),
                    pallet_id: row.data('pallet-id'),
                    selected_qty: parseInt(row.find('.selected-qty').val()) || 0,
                };
                pickedItems.push(item);
            }
        });

        if (pickedItems.length === 0) {
            alert('Please select at least one item to pick.');
            return;
        }

        // Send AJAX request
        $.ajax({
            url: '{{ route("admin.inventory.pick-list.store") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                picked_items: pickedItems
            },
            success: function (response) {
                alert('Pick list submitted!\nDocument No: ' + response.document_no);
                location.reload();
            },
            error: function (xhr) {
                alert('Error occurred while submitting pick list.');
            }
        });
    });

    function loadRacks(roomId) {
        $.get(`/admin/inventory/storage-room/room/${roomId}`, function (html) {
            $('#listRacks').html(html);
            $('#rackTabs').show();

            const $firstRack = $('#rackTabs .nav-link').first();
            if ($firstRack.length) {
                $firstRack.addClass('active');
                const rackId = $firstRack.data('rack-id');
                // loadRackDetail(roomId, rackId);
            }
        });
    }
    
    // function loadRackDetail(roomId, rackId) {
    //     $.get(`/admin/inventory/storage-room/room/${roomId}/rack/${rackId}`, function (data) {
    //         $('#rackDetailView').html(data);
    //     });
    // };
    
    function updateCheckboxStates() {
        $('.pick-check').each(function () {
            const row = $(this).closest('tr');
            if (!$(this).is(':checked')) {
                $(this).prop('disabled', pickedTotal >= totalAllowed);
            }
        });
    }

    function checkSubmitEnabled() {
        $('#submitPickList').prop('disabled', pickedTotal !== totalAllowed);
    }
    
    loadRacks(firstRoomId);

    $(document).on('click', '.view-rack-details', function (e) {
        e.preventDefault();

        const rackId = $(this).data('rack-id');
        const roomId = $(this).data('room-id');
        $.get(`/admin/inventory/storage-room/room/${roomId}/rack/${rackId}`, function(response) {
            $('#rackDetailView').html(response);

            // Show the modal after content is loaded
            const modal = new bootstrap.Modal(document.getElementById('rackDetailModal'));
            modal.show();
        });
    });
    
});

function toggleView(view) {
    if (view === '3d') {
        document.getElementById('view2D').style.display = 'block';
        document.getElementById('storage-room-list-view').style.display = 'none';
    } else if(view === 'list') {
        document.getElementById('view2D').style.display = 'none';
        document.getElementById('storage-room-list-view').style.display = 'block';
    } else if(view === 'filter') {
        document.getElementById('roomFilterDiv').style.display = 'block';
    }
}

</script>
@stop
