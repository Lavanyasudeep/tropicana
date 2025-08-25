@extends('adminlte::page')

@section('title', 'Manage Racks')

@section('content_header')
    <h1>Manage Racks</h1>
@stop

@section('content')

<!-- Rack Form at Top -->
<div class="card mb-3" id="rackCreateForm" style="display: none;">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Add / Edit Form</h3>
    </div>
    <div class="card-body">
        <form id="rackForm" action="{{ route('admin.master.inventory.racks.store') }}" method="POST" >
            @csrf
            <input type="hidden" id="rack-id" name="rack_id">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="storage_room_id">Storage Room</label>
                    <select class="form-control" name="storage_room_id" id="storage_room_id" required>
                        <option value="">-- Select --</option>
                        @foreach($storageRooms as $room)
                            <option value="{{ $room->room_id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="block_id">Block</label>
                    <select class="form-control" name="block_id" id="block_id" required>
                        <option value="">-- Select --</option>
                        @foreach($blocks as $block)
                            <option value="{{ $block->block_id }}">{{ $block->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">Rack Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="rack_no">Rack No</label>
                    <input type="text" class="form-control" name="rack_no" id="rack_no" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="capacity">Capacity (tons)</label>
                    <input type="number" class="form-control" name="capacity" id="capacity" required1>
                </div>
                <div class="form-group col-md-4">
                    <label for="position_x">Position X</label>
                    <input type="text" class="form-control" name="position_x" id="position_x" required1>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="position_y">Position Y</label>
                    <input type="text" class="form-control" name="position_y" id="position_y" required1>
                </div>
                <div class="form-group col-md-4">
                    <label for="no_of_levels">No of Levels</label>
                    <input type="number" class="form-control" name="no_of_levels" id="no_of_levels" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="no_of_depth">No of Depth</label>
                    <input type="text" class="form-control" name="no_of_depth" id="no_of_depth" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
            <button type="button" class="btn btn-default" id="closeEditBtn">Close</button>
        </form>
    </div>
</div>

<!-- Toggle between Views -->
<div class="page-sub-header" >
    <h3>List</h3>
    <div class="action-btns" >
        <button class="btn btn-create" onclick="toggleView('create')" title="Create New" ><i class="fas fa-plus" ></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')" title="List View"><i class="fas fa-list" ></i> List View</button>
        <button class="btn btn-3dview" onclick="toggleView('3d')" title="3d View"><i class="fas fa-box" ></i> 3D View</button>
    </div>
</div>

<!-- Animated View Section -->
<div id="rack-3d-view" class="card p-3" style="display: none;">
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
<div id="rack-list-view" class="card page-list-panel" >
    <div class="card-body">
        <table class="page-list-table" id="rackTable" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Rack Name</th>
                    <th>Rack No</th>
                    <th>Storage Room</th>
                    <th>Block</th>
                    <th>No of Levels</th>
                    <th>No of Depth</th>
                    <th>Status</th>
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
    
</style>
@stop 

@section('js')
<script>
    $(document).ready(function () {
        // Yajra DataTable
        const table = $('#rackTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.master.inventory.racks.index") }}',
            columns: [
                { data: 'rack_id', name: 'rack_id', defaultContent: '' },
                { data: 'name', name: 'rack_no', defaultContent: ' ' },
                { data: 'rack_no', name: 'name', defaultContent: '' },
                { data: 'storage_room_name', name: 'storage_room_name', defaultContent: 'No Room' },
                { data: 'block_name', name: 'block_name', defaultContent: 'No Room' },
                { data: 'no_of_levels', name: 'no_of_levels', defaultContent: '' },
                { data: 'no_of_depth', name: 'no_of_depth', defaultContent: '' },
                { data: 'Status', name: 'Status', orderable: false, searchable: false },
                { data: 'actions', orderable: false, searchable: false }
            ],
            columnDefs: [
                {
                    targets: [4,5,6],
                    className: 'text-center'
                }
            ],
            order: [[0, 'desc']]
        });

        $(document).on("click", ".edit-rack-btn", function () {
            const id = $(this).data('id');

            // Fill form fields
            $('input[name="rack_no"]').val($(this).data('no'));
            $('input[name="name"]').val($(this).data('name'));
            $('#storage_room_id').val($(this).data('roomid'));
            $('#block_id').val($(this).data('blockid'));
            $('input[name="capacity"]').val($(this).data('capacity'));
            $('input[name="no_of_levels"]').val($(this).data('no-of-levels'));
            $('input[name="no_of_depth"]').val($(this).data('no-of-depth'));
            $('input[name="position_x"]').val($(this).data('position_x'));
            $('input[name="position_y"]').val($(this).data('position_y'));

            // Change form action and method for update
            const form = $('form');
            form.attr('action', '/admin/racks/update/' + id);
            if (form.find('input[name="_method"]').length === 0) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            } else {
                form.find('input[name="_method"]').val('PUT');
            }

            // Optionally scroll to form
            window.scrollTo({ top: 0, behavior: 'smooth' });
            document.getElementById('rackCreateForm').style.display = 'block';
        });

        $(document).on("click", "#cancelEditBtn", function () {
            const form = $('#rackForm');
            form.find('select').val('');
            form.find('input[type="text"], input[type="number"]').val('');
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.racks.store') }}");
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $(document).on("click", "#closeEditBtn", function () {
            const form = $('#storageForm');
            form.find('input[type="text"], input[type="number"]').val('');
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.rooms.store') }}");
            document.getElementById('roomCreateForm').style.display = 'none';
        });

        $('#rackTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route("admin.master.inventory.racks.toggle-status") }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function (res) {
                if (res.success) {
                    button.toggleClass('btn-success btn-secondary')
                        .text(res.status ? 'Active' : 'Inactive');
                }
            });
        });

    
        // Edit from animated view
        $(document).on('click', '.edit-icon', function () {
            $('#rack-id').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $('#capacity').val($(this).data('capacity'));
            $('#storage_room_id').val($(this).data('storage-room'));
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
                        $('#rackTable').DataTable().ajax.reload();
                    }
                });
            }
        });

        $(document).on('click', '.generate-pallets-btn', function () {
            const rackId = $(this).data('id');

            $.ajax({
                url: '/admin/racks/' + rackId + '/generate-pallets',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert('Pallets generated successfully!');
                    $('#rackTable').DataTable().ajax.reload(); // reload table
                },
                error: function () {
                    alert('Failed to generate pallets.');
                }
            });
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
            document.getElementById('rack-3d-view').style.display = 'block';
            document.getElementById('rack-list-view').style.display = 'none';
        } else if(view === 'list') {
            document.getElementById('rack-3d-view').style.display = 'none';
            document.getElementById('rack-list-view').style.display = 'block';
        } else if(view === 'create') {
            document.getElementById('rackCreateForm').style.display = 'block';
        }
    }
</script>
@stop
