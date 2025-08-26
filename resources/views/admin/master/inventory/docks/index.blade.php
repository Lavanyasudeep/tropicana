@extends('adminlte::page')

@section('title', 'Dock Master')

@section('content_header')
    <h1>Manage Docks</h1>
@stop

@section('content')

<!-- Create/Edit Form -->
<div class="row" id="dockCreateForm">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">Add / Edit Dock</h3>
            </div>
            <div class="card-body">
                <form id="dockForm" action="#" method="POST">
                    @csrf
                    <input type="hidden" name="dock_id">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Dock No</label>
                            <input type="text" class="form-control" name="dock_no" required>
                        </div>
                        <div class="col-md-4">
                            <label>Dock Name</label>
                            <input type="text" class="form-control" name="dock_name" required>
                        </div>
                        <div class="col-md-4">
                            <label>Warehouse Unit</label>
                            <select class="form-control" name="warehouse_unit_id" required>
                                <option value="">-- Select Warehouse Unit --</option>
                                <option value="1">WU001 - Frozen Storage</option>
                                <option value="2">WU002 - Chiller Room</option>
                                <option value="3">WU003 - Dry Storage</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Vehicle Type</label>
                            <input type="text" class="form-control" name="vehicle_type" required>
                        </div>
                        <div class="col-md-4">
                            <label>Dock Type</label>
                            <select class="form-control" name="dock_type" required>
                                <option value="">-- Select Dock Type --</option>
                                <option value="Loading">Loading</option>
                                <option value="Receiving">Receiving</option>
                                <option value="Multi-purpose">Multi-purpose</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4" style="margin-top: 30px;">
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
    <div class="action-btns">
        <button class="btn btn-create" onclick="toggleView('create')" title="Create New"><i class="fas fa-plus"></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')" title="List View"><i class="fas fa-list"></i> List View</button>
    </div>
</div>

<!-- List View -->
<div id="dock-list-view" class="card page-list-panel">
    <div class="card-body">
        <table id="dockTable" class="page-list-table">
            <thead>
                <tr>
                    <th style="width:10%;">Dock No</th>
                    <th style="width:20%;">Dock Name</th>
                    <th style="width:20%;">Warehouse Unit</th>
                    <th style="width:15%;">Vehicle Type</th>
                    <th style="width:10%;">Status</th>
                    <th style="width:15%;">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@stop

@push('js')
<script>
$(document).ready(function() {
    // Dummy data for presentation
    const dummyDocks = [
        { dock_no: 'D001', dock_name: 'Main Loading Dock', warehouse_unit: 'WU001 - Frozen Storage', vehicle_type: 'Reefer Truck', status: 'Active' },
        { dock_no: 'D002', dock_name: 'Side Dock', warehouse_unit: 'WU002 - Chiller Room', vehicle_type: 'Van', status: 'Inactive' },
        { dock_no: 'D003', dock_name: 'Rear Dock', warehouse_unit: 'WU003 - Dry Storage', vehicle_type: 'Container Truck', status: 'Active' }
    ];

    $('#dockTable').DataTable({
        data: dummyDocks,
        columns: [
            { data: 'dock_no' },
            { data: 'dock_name' },
            { data: 'warehouse_unit' },
            { data: 'vehicle_type' },
            { 
                data: 'status',
                render: function(data) {
                    return `<span class="badge ${data === 'Active' ? 'bg-success' : 'bg-secondary'}">${data}</span>`;
                }
            },
            { 
                data: null,
                render: function(row) {
                    return `
                        <button class="btn btn-warning btn-sm edit-btn" data-dock='${JSON.stringify(row)}'>Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                    `;
                }
            }
        ]
    });

    // Edit button
    $(document).on("click", ".edit-btn", function () {
        const dock = $(this).data('dock');
        $('input[name="dock_no"]').val(dock.dock_no);
        $('input[name="dock_name"]').val(dock.dock_name);
        $('select[name="warehouse_unit_id"]').val(dock.warehouse_unit_id);
        $('input[name="vehicle_type"]').val(dock.vehicle_type);
        $('select[name="status"]').val(dock.status);
        $('#dockCreateForm').show();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Cancel edit
    $(document).on("click", "#cancelEditBtn", function () {
        $('#dockForm').trigger('reset');
        $('#dockCreateForm').hide();
    });
});

function toggleView(view) {
    if (view === 'list') {
        $('#dock-list-view').show();
        $('#dockCreateForm').hide();
    } else if (view === 'create') {
        $('#dockCreateForm').show();
    }
}
</script>
@endpush
