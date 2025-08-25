@extends('adminlte::page')
@section('title', 'Pallets')

@section('content_header')
    <h1>Manage Pallets</h1>
@stop

@section('content')
<div class="row" id="palletCreateForm" style="display: none;">
    <!-- Pallet Form -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Add / Edit Form</h3>
            </div>
            <div class="card-body">
                <form id="palletForm" method="POST" action="{{ route('admin.master.inventory.pallets.store') }}">
                    @csrf
                    <input type="hidden" id="pallet_id" name="pallet_id">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="storage_room_id">Storage Room</label>
                            <select class="form-control" id="storage_room_id" name="storage_room_id" required>
                                <option value="">-- Select --</option>
                                @foreach($storageRooms as $room)
                                    <option value="{{ $room->room_id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="block_id">Block</label>
                            <select class="form-control" id="block_id" name="block_id" required>
                                <option value="">-- Select --</option>
                                @foreach($blocks as $block)
                                    <option value="{{ $block->block_id }}">{{ $block->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Rack</label>
                            <select id="rack_id" name="rack_id" class="form-control">
                                <option value="">-- Select Rack --</option>
                                <!-- @foreach($racks as $rack)
                                    <option value="{{ $rack->rack_id }}">{{ $rack->name }}</option>
                                @endforeach -->
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Slot</label>
                            <select id="slot_id" name="slot_id" class="form-control">
                                <option value="">-- Select Slot --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Pallet Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Pallet No</label>
                            <input type="text" id="pallet_no" name="pallet_no" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="pallet_type_id">Pallet Type</label>
                            <select class="form-control" id="pallet_type_id" name="pallet_type_id" required>
                                <option value="">-- Select --</option>
                                @foreach($palletTypes as $palletType)
                                    <option value="{{ $palletType->pallet_type_id }}">{{ $palletType->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Barcode</label>
                            <input type="text" id="barcode" name="barcode" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Max Weight (KG)</label>
                            <input type="number" step="0.1" id="max_weight" name="max_weight" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="capacity_unit_id">Capacity Unit</label>
                            <select class="form-control" name="capacity_unit_id" id="capacity_unit_id" required1>
                                <option value="">-- Select --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->unit_id }}">{{ $unit->conversion_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="capacity">Capacity </label>
                            <input type="number" class="form-control" name="capacity" id="capacity" required1>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="empty">Empty</option>
                                <option value="partial">Partial</option>
                                <option value="full">Full</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="pallet_position" >Pallet Position</label>
                            <input type="text" step="0.1" id="pallet_position" name="pallet_position" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4" style="margin-top:30px;" >
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                            <button type="button" class="btn btn-default" id="closeEditBtn">Close</button>  
                        </div>
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
        <button class="btn btn-create" onclick="toggleView('create')" title="Create New" ><i class="fas fa-plus" ></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')"><i class="fas fa-list" ></i> List View</button>
        <button class="btn btn-3dview" onclick="toggleView('3d')"><i class="fas fa-box" ></i> 3D View</button>
    </div>
</div>

<!-- Animated View Section -->
<div id="pallet-3d-view" class="card p-3" style="display: none;" >
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs roomTab mb-3" id="roomTabs" role="tablist">
        @foreach($storageRooms as $room)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                    data-room-id="{{ $room->room_id }}" 
                    id="room-tab-{{ $room->room_id }}" 
                    data-toggle="tab" 
                    href="#room-{{ $room->room_id }}" 
                    role="tab"
                    aria-controls="room-{{ $room->room_id }}" 
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $room->name }} 
                    <span class="badge bg-primary ms-2">{{ $room->racks_count ?? 0 }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="roomTabContent">
        @foreach($storageRooms as $room)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                    id="room-{{ $room->room_id }}" 
                    role="tabpanel" 
                    aria-labelledby="room-tab-{{ $room->room_id }}">
                    
                <div class="room-container" id="room-container-{{ $room->room_id }}">
                    <!-- Racks will be loaded here dynamically -->
                    <div class="text-center py-5 loading-spinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Yajra DataTable List View -->
<div id="pallet-list-view" class="card page-list-panel" >
    <div class="card-body">
        <table id="palletTable" class="page-list-table" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pallet No</th>
                    <th>Name</th>
                    <th>Room Name</th>
                    <th>Block Name</th>
                    <th>Rack Name</th>
                    <th>Slot Name</th>
                    <th>Pallet Position</th>
                    <th>Pallet Type</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('css')
<style>
    .room-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 20px;
        padding: 15px;
    }
    
    /* .rack-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    } */
    
    .rack-card {
        width: 100px;
        display: flex;
        flex-direction: column-reverse;
        justify-content: flex-start;
        align-items: center;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 5px;
        transition: all 0.3s ease;
        background-color: #eee;
    }

    .rack-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .rack-header {
        /* background-color: #f8f9fa; */
        /* padding: 10px 15px; */
        /* border-bottom: 1px solid #dee2e6; */
        font-weight: 600;
        text-align: center;
    }
    
    .rack-body {
        padding: 15px;
    }

    .pallet {
        width: auto;
        height: 20px;
        background-color: #b5651d; /* Brown for pallet */
        margin-top: 5px;
        position: relative;
    }
    
</style>
@stop 

@section('js')
<script>
$(document).ready(function () {
    // Yajra DataTable
    const table = $('#palletTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.master.inventory.pallets.index") }}',
        columns: [
            { data: 'pallet_id', name: 'pallet_id', defaultContent: '' },
            { data: 'pallet_no', name: 'pallet_no', defaultContent: '' },
            { data: 'name', name: 'name', defaultContent: '' },
            { data: 'storage_room_name', name: 'storage_room_name', defaultContent: '' },
            { data: 'block_name', name: 'block_name', defaultContent: '' },
            { data: 'rack_name', name: 'rack_name', defaultContent: '' },
            { data: 'slot_name', name: 'slot_name', defaultContent: '' },
            { data: 'pallet_position', name: 'pallet_position', defaultContent: '' },
            { data: 'pallet_type', name: 'pallet_type', defaultContent: '' },
            { data: 'active', name: 'Status', orderable: false, searchable: false },
            { data: 'actions', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            {
                targets: [6,7],
                className: 'text-center'
            }
        ],
        order: [[0, 'desc']]
    });

    $(document).on("click", ".edit-pallet-btn", function () {
        const id = $(this).data('id');

        // Fill form fields
        $('input[name="pallet_no"]').val($(this).data('no'));
        $('input[name="name"]').val($(this).data('name'));
        $('#storage_room_id').val($(this).data('roomid')).trigger('change'); // Trigger change if dependent dropdowns
        $('#block_id').val($(this).data('blockid'));
        $('input[name="barcode"]').val($(this).data('barcode'));
        $('input[name="max_weight"]').val($(this).data('max_weight'));
        $('input[name="pallet_position"]').val($(this).data('pallet-position'));
         $('input[name="pallet_type_id"]').val($(this).data('pallet-type-id'));
        $('#capacity_unit_id').val($(this).data('capacityunit'));
        $('input[name="capacity"]').val($(this).data('capacity'));
        // $('#status').val($(this).data('status'));
        targetRackId = $(this).data('rackid');
        targetSlotId = $(this).data('slotid');
        setTimeout(function () {
            $('#rack_id').val(targetRackId).trigger('change');
            $('#slot_id').val(targetSlotId).trigger('change');
        }, 500);

        // Change form action and method for update
        const form = $('form');
        form.attr('action', '/admin/pallets/update/' + id);
        if (form.find('input[name="_method"]').length === 0) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        } else {
            form.find('input[name="_method"]').val('PUT');
        }

        // Optionally scroll to form
        window.scrollTo({ top: 0, behavior: 'smooth' });
        document.getElementById('palletCreateForm').style.display = 'block';
    });

    $(document).on("click", "#cancelEditBtn", function () {
        const form = $('#palletForm');
        form.find('select').val('');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('input[name="_method"]').remove();
        form.attr('action', "{{ route('admin.master.inventory.pallets.store') }}");
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeEditBtn", function () {
        const form = $('#palletForm');
         form.find('select').val('');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('input[name="_method"]').remove();
        form.attr('action', "{{ route('admin.master.inventory.pallets.store') }}");
        document.getElementById('palletCreateForm').style.display = 'none';
    });

    $('#palletTable').on('click', '.toggle-status', function () {
        const button = $(this);
        const id = button.data('id');

        $.post('{{ route("admin.master.inventory.pallets.toggle-status") }}', {
            _token: '{{ csrf_token() }}',
            id: id
        }, function (res) {
            if (res.success) {
                button.toggleClass('btn-success btn-secondary')
                    .text(res.status ? 'Active' : 'Inactive');
            }
        });
    });

    $(document).on("change", "#storage_room_id", function () {
        const roomId = $(this).val();

        $.post('{{ route("admin.master.inventory.racks.get-racks") }}', {
            _token: '{{ csrf_token() }}',
            room_id: roomId
        }, function (res) {
            let options = '<option value="">Select Rack</option>';

            $.each(res.racks, function (key, rack) {
                options += `<option value="${rack.rack_id}" data-rack-no="${rack.rack_no}" >${rack.name}</option>`;
            });

            updatePalletPosition();
           
            $('#rack_id').html(options);
        });
    });

    $(document).on("change", "#rack_id", function () {
        const roomId = $('#storage_room_id').val();
        const rackId = $(this).val();

        $.post('{{ route("admin.master.inventory.slots.get-slots") }}', {
            _token: '{{ csrf_token() }}',
            room_id: roomId,
            rack_id: rackId
        }, function (res) {
            let options = '<option value="">Select Slot</option>';

            $.each(res.slots, function (key, slot) {
                options += `<option value="${slot.slot_id}">${slot.level_no}-${slot.depth_no}</option>`;
            });

            $('#slot_id').html(options);

            updatePalletPosition();
        });
    });

    $(document).on("change", "#slot_id", function () {
        updatePalletPosition();
    });

    const initialRoomId = $('#roomTabs .nav-link.active').data('room-id');
    loadRoomRacks(initialRoomId);

    // Tab click handler
    $('#roomTabs .nav-link').on('click', function(e) {
        e.preventDefault();
        const roomId = $(this).data('room-id');
        loadRoomRacks(roomId);
    });

    // Function to load racks for a room
    function loadRoomRacks(roomId) {
        const container = $(`#room-container-${roomId}`);
        
        // Show loading state
        container.html(`
            <div class="text-center py-5 loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);
        
        renderRacks(container, roomId);
    }
    
    // Function to render racks in the container
    function renderRacks(container, roomId) {
        const storageRooms = @json($storageRooms);
        const selectedRoom = storageRooms.find(room => room.room_id === roomId);

        if (!selectedRoom.racks || selectedRoom.racks.length === 0) {
            container.html(`
                <div class="alert alert-info">
                    No racks found in this storage room.
                </div>
            `);
            return;
        }
        
        let html = '';
        
        selectedRoom.racks.forEach(rack => {
            html += `
                <div class="rack-card" data-rack-id="${rack.rack_id}">
                    <div class="rack-header">
                        <span>${rack.name}</span>`;
                        rack.pallets.forEach(pallet => {
                            html += `<div class="pallet" title="Pallet: ${pallet.name}"> 
                                        <span>${pallet.name}</span>
                                    </div>`;
                        });

            html += `</div>
            </div>`;
        });
        
        container.html(html);
    }

    // Delete Handler
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        if (confirm("Are you sure you want to delete this pallet?")) {
            $.ajax({
                url: '/admin/pallets/delete/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function (response) {
                    $('#palletTable').DataTable().ajax.reload();
                }
            });
        }
    });

    $(document).on('change', '#capacity_unit_id', function() {
        var unitName = $(this).find('option:selected').text();
        
        var originalLabel = 'Capacity'; 
        $('label[for="capacity"]').text(`${originalLabel} (in ${unitName})`);
    });

    function updatePalletPosition() {
        const roomName = $('#storage_room_id option:selected').text().trim(); // get selected option text
        const rackNo = $('#rack_id option:selected').data('rack-no'); // get data-rack-no from selected option
        const slotNo = $('#slot_id option:selected').text().trim();   // get selected slot's display text

        // if (!roomName || !rackNo || !slotNo) {
        //     console.warn('Missing one or more position identifiers.');
        //     $('#pallet_position').val(''); // clear input
        //     return;
        // }

        const segments = [roomName, rackNo, slotNo].filter(Boolean); // removes empty or undefined
        const palletPosition = segments.join('-');

        $('#pallet_position').val(palletPosition);
    }
    
});

function toggleView(view) {
    if (view === '3d') {
        document.getElementById('pallet-3d-view').style.display = 'block';
        document.getElementById('pallet-list-view').style.display = 'none';
    } else if(view === 'list') {
        document.getElementById('pallet-3d-view').style.display = 'none';
        document.getElementById('pallet-list-view').style.display = 'block';
    } else if(view === 'create') {
        document.getElementById('palletCreateForm').style.display = 'block';
    }
}
</script>
@stop
