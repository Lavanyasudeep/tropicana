@extends('adminlte::page')

@section('title', 'Manage Slots')

@section('content_header')
    <h1>Manage Slots</h1>
@stop

@section('content')
<!-- Rack Form at Top -->
<div class="card mb-3" id="slotCreateForm" style="display: none;">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Add / Edit Form</h3>
    </div>
    <div class="card-body">
        <form id="slotForm" action="{{ route('admin.master.inventory.slots.store') }}" method="POST" >
            @csrf
            <input type="hidden" id="slot-id" name="shelf_id">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="room_id">Storage Room</label>
                    <select class="form-control" name="room_id" id="room_id" required>
                        <option value="">-- Select --</option>
                        @foreach($storageRooms as $room)
                            <option value="{{ $room->room_id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="rack_id">Rack</label>
                    <select class="form-control" name="rack_id" id="rack_id" required>
                        <option value="">-- Select --</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">Slot Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="slot_no">Slot No</label>
                    <input type="text" class="form-control" name="slot_no" id="slot_no" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="pallet_type_id">Pallet Type</label>
                    <select class="form-control" id="pallet_type_id" name="pallet_type_id" required>
                        <option value="">-- Select --</option>
                        @foreach($palletTypes as $palletType)
                            <option value="{{ $palletType->pallet_type_id }}">{{ $palletType->type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="capacity">Capacity (tons)</label>
                    <input type="number" class="form-control" name="capacity" id="capacity" required1>
                </div>
                <div class="form-group col-md-3">
                    <label for="level_no">Level No</label>
                    <select class="form-control" name="level_no" id="level_no" required>
                        <option value="">-- Select --</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="depth_no">Depth No</label>
                    <select class="form-control" name="depth_no" id="depth_no" required>
                        <option value="">-- Select --</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="empty">Empty</option>
                        <option value="partial">Partial</option>
                        <option value="full">Full</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
            <button type="button" class="btn btn-default" id="closeEditBtn">Close</button>
        </form>
    </div>
</div>

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns" >
        <button class="btn btn-create" onclick="toggleView('create')" title="Create New" ><i class="fas fa-plus" ></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')" title="List View"><i class="fas fa-list" ></i> List View</button>
        <button class="btn btn-3dview" onclick="toggleView('3d')" title="3d View"><i class="fas fa-box" ></i> 3D View</button>
    </div>
</div>

<!-- Animated View Section -->
<div id="slot-3d-view" class="card p-3" style="display: none;">
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
</div>

<!-- Yajra DataTable List View -->
<div id="slot-list-view" class="card page-list-panel" >
    <div class="card-body">
        <table id="slotTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Slot Name</th>
                    <th>Slot No</th>
                    <th>Storage Room</th>
                    <th>Rack Name</th>
                    <th>Pallet Type</th>
                    <th>level_no</th>
                    <th>depth_no</th>
                    <th>Status</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@stop

@section('css')
<style>
    .room-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
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
    
</style>
@stop 

@section('js')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script> -->
<script>
    $(document).ready(function () {
        // Yajra DataTable
        const table = $('#slotTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("admin.master.inventory.slots.index") }}',
                    columns: [
                        { data: 'slot_id', name: 'slot_id', defaultContent: '' },
                        { data: 'slot_no', name: 'slot_no', defaultContent: ' ' },
                        { data: 'name', name: 'name', defaultContent: '' },
                        { data: 'storage_room_name', name: 'storage_room_name', defaultContent: 'No Room' },
                        { data: 'rack_name', name: 'rack_name', defaultContent: 'No Rack' },
                        { data: 'pallet_type', name: 'pallet_type', defaultContent: '' },
                        { data: 'level_no', name: 'level_no', defaultContent: '' },
                        { data: 'depth_no', name: 'depth_no', defaultContent: '' },
                        { data: 'slot_status', name: 'Status', orderable: false, searchable: false },
                        { data: 'active', name: 'Status', orderable: false, searchable: false },
                        { data: 'actions', orderable: false, searchable: false }
                    ],
                    order: [[0, 'desc']]
                });

        $(document).on("click", ".edit-slot-btn", function () {
            const id = $(this).data('id');
            const roomId = $(this).data('roomid');
            const rackId = $(this).data('rackid');
            const levelNo = $(this).data('level_no');
            const depthNo = $(this).data('depth_no');

            // Fill form fields
            $('input[name="slot_no"]').val($(this).data('no'));
            $('input[name="name"]').val($(this).data('name'));
            $('#room_id').val($(this).data('roomid')).trigger('change');
            $('input[name="capacity"]').val($(this).data('capacity'));

            // Wait for the level/depth dropdowns to be populated
            setTimeout(function () {
                $('#rack_id').val(rackId).trigger('change');
            }, 500);

            setTimeout(function () {
                $('#level_no').val(levelNo);
                $('#depth_no').val(depthNo);
            }, 800);

            // Change form action and method for update
            const form = $('form');
            form.attr('action', '/admin/master/inventory/slots/update/' + id);
            if (form.find('input[name="_method"]').length === 0) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            } else {
                form.find('input[name="_method"]').val('PUT');
            }

            // Optionally scroll to form
            window.scrollTo({ top: 0, behavior: 'smooth' });
            document.getElementById('slotCreateForm').style.display = 'block';
        });

        $(document).on("click", "#cancelEditBtn", function () {
            const form = $('#slotForm');
            form.find('select').val('');
            form.find('input[type="text"], input[type="number"]').val('');
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.slots.store') }}");
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $(document).on("click", "#closeEditBtn", function () {
            const form = $('#slotForm');
             form.find('select').val('');
            form.find('input[type="text"], input[type="number"]').val('');
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.rooms.store') }}");
            document.getElementById('slotCreateForm').style.display = 'none';
        });

        $('#slotTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route("admin.master.inventory.slots.toggle-status") }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function (res) {
                if (res.success) {
                    button.toggleClass('btn-success btn-secondary')
                        .text(res.status ? 'Active' : 'Inactive');
                }
            });
        });

        $(document).on("change", "#room_id", function () {
            const roomId = $(this).val();

            $.post('{{ route("admin.master.inventory.racks.get-racks") }}', {
                _token: '{{ csrf_token() }}',
                room_id: roomId
            }, function (res) {
                console.log(res);
                let options = '<option value="">Select Rack</option>';

                $.each(res.racks, function (key, rack) {
                    options += `<option value="${rack.rack_id}" data-rack-no="${rack.rack_no}" >${rack.name}</option>`;
                });
            
                $('#rack_id').html(options);
            });
        });

        $(document).on("change", "#rack_id", function () {
            const roomId = $('#room_id').val();
            const rackId = $(this).val();

            $.post('{{ route("admin.master.inventory.slots.get-slots") }}', {
                _token: '{{ csrf_token() }}',
                room_id: roomId,
                rack_id: rackId
            }, function (res) {
                let levelOptions = '<option value="">Select Level</option>';
                let depthOptions = '<option value="">Select Depth</option>';

                // Use Sets to store unique values
                const uniqueLevels = new Set();
                const uniqueDepths = new Set();

                $.each(res.slots, function (key, slot) {
                    uniqueLevels.add(slot.level_no);
                    uniqueDepths.add(slot.depth_no);
                });

                // Convert Sets to options
                uniqueLevels.forEach(level => {
                    levelOptions += `<option value="${level}">${level}</option>`;
                });

                uniqueDepths.forEach(depth => {
                    depthOptions += `<option value="${depth}">${depth}</option>`;
                });

                $('#level_no').html(levelOptions);
                $('#depth_no').html(depthOptions);
            });
        });

        // Handle delete
        $(document).on('click', '.delete-btn', function () {
            if (confirm('Are you sure to delete this rack?')) {
                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        $('#slotTable').DataTable().ajax.reload();
                    }
                });
            }
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
                            <span>${rack.name}</span>
                            <span class="badge bg-secondary">${rack.pallets_count || 0} pallets</span>
                        </div>
                    </div>`;
            });
            
            container.html(html);
        }


    });

    function toggleView(view) {
        if (view === '3d') {
            document.getElementById('slot-3d-view').style.display = 'block';
            document.getElementById('slot-list-view').style.display = 'none';
        } else if(view === 'list') {
            document.getElementById('slot-3d-view').style.display = 'none';
            document.getElementById('slot-list-view').style.display = 'block';
        } else if(view === 'create') {
            document.getElementById('slotCreateForm').style.display = 'block';
        }
    }
</script>
@stop
