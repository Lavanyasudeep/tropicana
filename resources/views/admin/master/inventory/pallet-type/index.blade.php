@extends('adminlte::page')

@section('title', 'Pallet Type Master')

@section('content_header')
    <h1>Manage Pallet Types</h1>
@stop

@section('content')

<div class="row" id="palletTypeCreateForm" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Add / Edit Pallet Type</h3>
            </div>
            <div class="card-body">
                <form id="palletTypeForm" action="{{ route('admin.master.inventory.pallet-type.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Type Name</label>
                            <input type="text" class="form-control" name="type_name" required>
                        </div>
                        <div class="col-md-8">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Length (mm)</label>
                            <input type="number" class="form-control" name="length_mm" id="length_mm" required>
                        </div>
                        <div class="col-md-3">
                            <label>Width (mm)</label>
                            <input type="number" class="form-control" name="width_mm" id="width_mm" required>
                        </div>
                        <div class="col-md-3">
                            <label>Max Stack Height (mm)</label>
                            <input type="number" class="form-control" name="height_mm" id="height_mm" required>
                        </div>
                        <div class="col-md-3">
                            <label>Pallet Volume (m³)</label>
                            <input type="text" class="form-control" name="volume_m3" id="volume_m3" readonly>
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

<!-- Action buttons -->
<div class="page-sub-header">
    <h3>Pallet Type List</h3>
    <div class="action-btns">
        <button class="btn btn-create" onclick="toggleView('create')"><i class="fas fa-plus"></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')"><i class="fas fa-list"></i> List View</button>
    </div>
</div>

<!-- List View -->
<div id="palletType-list-view" class="card page-list-panel">
    <div class="card-body">
        <table id="palletTypeTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type Name</th>
                    <th>Description</th>
                    <th>Length (mm)</th>
                    <th>Width (mm)</th>
                    <th>Max Stack Height (mm)</th>
                    <th>Pallet Volume (m³)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@stop

@section('js')
<script>
    $(function() {
        // const table = $('#palletTypeTable').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: '{{ route('admin.master.inventory.pallet-type.index') }}',
        //     columns: [
        //         { data: 'pallet_type_id', name: 'pallet_type_id' },
        //         { data: 'type_name', name: 'type_name' },
        //         { data: 'description', name: 'description' },
        //         { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
        //         { data: 'actions', name: 'actions', orderable: false, searchable: false }
        //     ],
        //     order: [[0, 'desc']]
        // });

        const dummyData = [
            {
                pallet_type_id: 1,
                type_name: "Standard Wooden",
                description: "1200x1000mm, 1500mm height",
                length_mm: 1200,
                width_mm: 1000,
                height_mm: 1500,
                volume_m3: "1.800",
                is_active: '<button class="badge badge-primary toggle-status" data-id="1">Active</button>',
                actions: '<button class="btn btn-sm btn-primary edit-btn" data-id="1" data-type-name="Standard Wooden" data-description="1200x1000mm, 1500mm height">Edit</button>'
            },
            {
                pallet_type_id: 2,
                type_name: "Euro Pallet",
                description: "1200x800mm, 1500mm height",
                length_mm: 1200,
                width_mm: 800,
                height_mm: 1500,
                volume_m3: "1.440",
                is_active: '<button class="badge badge-secondary toggle-status" data-id="2">Inactive</button>',
                actions: '<button class="btn btn-sm btn-primary edit-btn" data-id="2" data-type-name="Euro Pallet" data-description="1200x800mm, 1500mm height">Edit</button>'
            },
            {
                pallet_type_id: 3,
                type_name: "Plastic Export",
                description: "1100x1100mm, 1400mm height",
                length_mm: 1100,
                width_mm: 1100,
                height_mm: 1400,
                volume_m3: "1.694",
                is_active: '<button class="badge badge-primary toggle-status" data-id="3">Active</button>',
                actions: '<button class="btn btn-sm btn-primary edit-btn" data-id="3" data-type-name="Plastic Export" data-description="1100x1100mm, 1400mm height">Edit</button>'
            },
            {
                pallet_type_id: 4,
                type_name: "Half Pallet",
                description: "800x600mm, 1200mm height",
                length_mm: 800,
                width_mm: 600,
                height_mm: 1200,
                volume_m3: "0.576",
                is_active: '<button class="badge badge-secondary toggle-status" data-id="4">Inactive</button>',
                actions: '<button class="btn btn-sm btn-primary edit-btn" data-id="4" data-type-name="Half Pallet" data-description="800x600mm, 1200mm height">Edit</button>'
            }
        ];

        const table = $('#palletTypeTable').DataTable({
            data: dummyData,
            columns: [
                { data: 'pallet_type_id' },
                { data: 'type_name' },
                { data: 'description' },
                { data: 'length_mm' },
                { data: 'width_mm' },
                { data: 'height_mm' },
                { data: 'volume_m3' },
                { data: 'is_active', orderable: false, searchable: false },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });

        $(document).on("click", ".edit-btn", function () {
            const id = $(this).data('id');
            $('input[name="type_name"]').val($(this).data('type-name'));
            $('input[name="description"]').val($(this).data('description'));

            const form = $('#palletTypeForm');
            form.attr('action', '/admin/master/inventory/pallet-type/update/' + id);
            if (!form.find('input[name="_method"]').length) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $('#palletTypeCreateForm').show();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $("#cancelEditBtn, #closeEditBtn").click(function () {
            const form = $('#palletTypeForm');
            form[0].reset();
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.pallet-type.store') }}");
            $('#palletTypeCreateForm').hide();
        });

        $('#palletTypeTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route('admin.master.inventory.pallet-type.toggle-status') }}', {
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


    function calculateVolume() {
        const length = parseFloat($('#length_mm').val()) || 0;
        const width = parseFloat($('#width_mm').val()) || 0;
        const height = parseFloat($('#height_mm').val()) || 0;

        // Convert mm to meters
        const volume = (length / 1000) * (width / 1000) * (height / 1000);
        $('#volume_m3').val(volume.toFixed(3));
    }

    $('#length_mm, #width_mm, #height_mm').on('input', calculateVolume);

    function toggleView(view) {
        if (view === 'create') {
            $('#palletTypeCreateForm').show();
        } else {
            $('#palletTypeCreateForm').hide();
        }
    }
</script>
@stop
