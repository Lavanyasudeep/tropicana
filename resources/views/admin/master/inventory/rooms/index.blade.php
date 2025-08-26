@extends('adminlte::page')

@section('title', 'Rooms')

@section('content_header')
    <h1>Manage Rooms</h1>
@stop

@section('content')

<div class="row" id="roomCreateForm">
    <!-- Room Form -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">Add / Edit Form</h3>
            </div>
            <div class="card-body">
                <form id="roomForm" action="{{ route('admin.master.inventory.rooms.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Warehouse Unit</label>
                            <select name="warehouse_unit_id" class="form-control" required>
                                <option value="">-- Select Warehouse Unit --</option>
                                @foreach($warehouseUnits as $unit)
                                    <option value="{{ $unit->wu_id }}">{{ $unit->wu_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Room No</label>
                            <input type="text" class="form-control" name="room_no" placeholder="R001" required>
                        </div>
                        <div class="col-md-4">
                            <label>Room Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                        <div class="col-md-4">
                            <label>Total Capacity (tons)</label>
                            <input type="number" step="0.01" class="form-control" name="total_capacity" required>
                        </div>
                        <div class="col-md-4">
                            <label>Temperature Range (°C)</label>
                            <input type="text" class="form-control" name="temperature_range" placeholder="-18°C to -22°C" required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Storage Product Type</label>
                            <select name="storage_product_type_id" class="form-control" required>
                                <option value="">-- Select Product Type --</option>
                                @foreach($productTypes as $type)
                                    <option value="{{ $type->product_type_id }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Is Active</label>
                            <select name="is_active" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
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
<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns" >
        <button class="btn btn-create" onclick="toggleView('create')" title="Create New" ><i class="fas fa-plus" ></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')" title="List View" ><i class="fas fa-list" ></i> List View</button>
        <button class="btn btn-3dview" onclick="toggleView('3d')" title="3d View"><i class="fas fa-box" ></i> 3D View</button>        
    </div>
</div>

<!-- 3D Graphical View -->
<div id="room-3d-view" class="card p-3" style="display: none;" >
    <div id="three-container" style="width: 100%; height: 400px; position: relative;"></div>
    <div id="tooltip" class="tooltip-box" style="position: absolute; display: none; background: rgba(0,0,0,0.8); color: white; padding: 6px 12px; border-radius: 5px; font-size: 14px;"></div>
</div>

<!-- List View with Filters -->
<div id="room-list-view" class="card page-list-panel" >
    <div class="card-body">
        <table id="roomTable" class="page-list-table" >
            <thead>
                <tr>
                    <th style="width:5%;" >#</th>
                    <th style="width:20%;" >Name</th>
                    <th style="width:20%;" >Warehouse Unit</th>
                    <th style="width:30%;" >Description</th>
                    <th style="width:10%;" >Capacity</th>
                    <th style="width:10%;" >Temperature</th>
                    <th style="width:10%;" >Status</th>
                    <th style="width:15%;" >Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('css')
<style>
    #roomCreateForm { display:none; }
    #three-container { background-color: #f8f9fa; }
    #tooltip {
        position: absolute;
        background: rgba(0, 0, 0, 0.85);
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        pointer-events: none;
        display: none;
        font-size: 14px;
        max-width: 250px;
        z-index: 1000;
    }
</style>
@stop

@section('js')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script> -->
<script>
    $(document).ready(function() {
        const table = $('#roomTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.master.inventory.rooms.index') }}',
            columns: [
                { data: 'room_id', name: 'room_id', width: '5%' },
                { data: 'name', name: 'name', width: '25%' },
                { data: 'warehouse_unit', name: 'warehouse_unit', width: '15%' },
                { data: 'description', name: 'description', width: '25%' },
                { data: 'total_capacity', name: 'total_capacity', width: '12.5%' },
                { data: 'temperature_range', name: 'temperature_range', width: '12.5%' },
                { data: 'Status', name: 'Status', width: '10%', orderable: false, searchable: false  },
                { data: 'actions', name: 'actions', width: '10%', orderable: false, searchable: false }
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'text-center'
                },
                {
                    targets: 5,
                    className: 'text-center'
                },
                {
                    targets: 6,
                    className: 'text-center'
                }
            ],
            order: [[0, 'desc']]
        });

        $(document).on("click", ".edit-btn", function () {
            const id = $(this).data('id');

            // Fill form fields
            $('input[name="name"]').val($(this).data('name'));
            $('input[name="description"]').val($(this).data('description'));
            $('input[name="total_capacity"]').val($(this).data('capacity'));
            $('input[name="temperature_range"]').val($(this).data('temperature'));

            // Change form action and method for update
            const form = $('form');
            form.attr('action', '/admin/master/inventory/rooms/update/' + id);
            if (form.find('input[name="_method"]').length === 0) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            } else {
                form.find('input[name="_method"]').val('PUT');
            }

            // Optionally scroll to form
            window.scrollTo({ top: 0, behavior: 'smooth' });
            document.getElementById('roomCreateForm').style.display = 'block';
        });

        $(document).on("click", "#cancelEditBtn", function () {
            const form = $('#roomForm');
            form.find('input[type="text"], input[type="number"]').val('');
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.rooms.store') }}");
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $(document).on("click", "#closeEditBtn", function () {
            const form = $('#roomForm');
            form.find('input[type="text"], input[type="number"]').val('');
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.rooms.store') }}");
            document.getElementById('roomCreateForm').style.display = 'none';
        });

        $('#roomTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route('admin.master.inventory.rooms.toggle-status') }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function (res) {
                if (res.success) {
                    button.toggleClass('btn-success btn-secondary')
                        .text(res.status ? 'Active' : 'Inactive');
                }
            });
        });

    });

    const storageRooms = @json($storageRooms);

    let scene, camera, renderer, raycaster, mouse, dragging = false;
    let selectedObject = null;
    const tooltip = document.getElementById('tooltip');

    init();
    animate();
    
    function toggleView(view) {
        if (view === '3d') {
            document.getElementById('room-3d-view').style.display = 'block';
            document.getElementById('room-list-view').style.display = 'none';
        } else if(view === 'list') {
            document.getElementById('room-3d-view').style.display = 'none';
            document.getElementById('room-list-view').style.display = 'block';
        } else if(view === 'create') {
            document.getElementById('roomCreateForm').style.display = 'block';
        }
    }

    function init() {
        scene = new THREE.Scene();
        camera = new THREE.PerspectiveCamera(75, window.innerWidth / 400, 0.1, 1000);
        camera.position.z = 50;

        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, 400);
        document.getElementById('three-container').appendChild(renderer.domElement);

        raycaster = new THREE.Raycaster();
        mouse = new THREE.Vector2();

        const ambientLight = new THREE.AmbientLight(0xffffff, 1);
        scene.add(ambientLight);

        storageRooms.forEach((room, index) => {
            createStorageRoomCube(room, index);
        });

        renderer.domElement.addEventListener("mousedown", onMouseDown);
        renderer.domElement.addEventListener("mouseup", onMouseUp);
        renderer.domElement.addEventListener("mousemove", onMouseMove);
    }

    function createStorageRoomCube(room, index) {
        const geometry = new THREE.BoxGeometry(5, 5, 5);
        const material = new THREE.MeshStandardMaterial({ color: 0x007bff });
        const cube = new THREE.Mesh(geometry, material);
        
        cube.position.x = (index % 5) * 8;
        cube.position.y = Math.floor(index / 5) * 8;
        cube.userData = {
            name: room.name,
            description: room.description,
            capacity: room.total_capacity,
            temperature: room.temperature_range
        };

        // Label as Sprite
        const canvas = document.createElement('canvas');
        canvas.width = 256;
        canvas.height = 64;
        const context = canvas.getContext('2d');
        context.fillStyle = 'white';
        context.font = '20px Arial';
        context.fillText(room.name, 10, 40);

        const texture = new THREE.CanvasTexture(canvas);
        const spriteMaterial = new THREE.SpriteMaterial({ map: texture });
        const sprite = new THREE.Sprite(spriteMaterial);
        sprite.scale.set(10, 3, 1);
        sprite.position.set(0, 4, 0);
        cube.add(sprite);

        scene.add(cube);
    }

    function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    }

    function onMouseDown(event) {
        updateMouseCoords(event);

        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(scene.children);

        if (intersects.length > 0) {
            selectedObject = intersects[0].object;
            dragging = true;
        }

        selectedObject.material.emissive.set(0x00ff00);
    }

    function onMouseUp() {
        dragging = false;
        selectedObject = null;

        if (selectedObject) selectedObject.material.emissive.set(0x000000);
    }

    function onMouseMove(event) {
        updateMouseCoords(event);

        raycaster.setFromCamera(mouse, camera);

        if (dragging && selectedObject) {
            const planeZ = new THREE.Plane(new THREE.Vector3(0, 0, 1), 0);
            const intersection = new THREE.Vector3();
            raycaster.ray.intersectPlane(planeZ, intersection);

            // Clamp within view boundaries
            selectedObject.position.x = Math.max(-80, Math.min(80, intersection.x));
            selectedObject.position.y = Math.max(-70, Math.min(70, intersection.y));
        } else {
            const intersects = raycaster.intersectObjects(scene.children);
            if (intersects.length > 0) {
                const cube = intersects[0].object;
                if (cube.userData && cube.userData.name) {
                    const info = cube.userData;
                    tooltip.innerHTML = `
                        <strong>${info.name}</strong><br>
                        Capacity: ${info.capacity} tons<br>
                        Temp: ${info.temperature} °C<br>
                        ${info.description}
                    `;
                    tooltip.style.display = "block";
                    tooltip.style.left = event.clientX + 10 + "px";
                    tooltip.style.top = event.clientY + 10 + "px";
                }
            } else {
                tooltip.style.display = "none";
            }
        }
    }

    function updateMouseCoords(event) {
        const rect = renderer.domElement.getBoundingClientRect();
        mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
    }
</script>
@stop