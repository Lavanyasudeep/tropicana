@extends('adminlte::page')

@section('title', 'Product Type Pricing')

@section('content_header')
    <h1>Manage Product Type Prices</h1>
@stop

@section('content')
<div class="row" id="priceCreateForm" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Add / Edit Price</h3>
            </div>
            <div class="card-body">
                <form id="priceForm" action="{{ route('admin.master.general.product-type-price.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Product Type</label>
                            <select name="product_type_id" class="form-control" required>
                                <option value="">Select</option>
                                @foreach($productTypes as $type)
                                    <option value="{{ $type->product_type_id }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Unit</label>
                            <select name="unit_id" class="form-control" required>
                                <option value="">Select</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->unit_id }}">{{ $unit->unit }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Price</label>
                            <input type="number" step="0.01" class="form-control" name="price" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Action buttons -->
<div class="page-sub-header">
    <h3>Price List</h3>
    <div class="action-btns">
        <button class="btn btn-create" onclick="toggleView('create')"><i class="fas fa-plus"></i> Create</button>
    </div>
</div>

<!-- List View -->
<div id="productPrice-list-view" class="card page-list-panel">
    <div class="card-body">
        <table id="priceTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Type</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Duration</th>
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
    $(document).ready(function() {
        const table = $('#priceTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.master.general.product-type-price.index') }}',
            columns: [
                { data: 'price_id', name: 'price_id' },
                { data: 'product_type_name', name: 'product_type_name' },
                { data: 'unit_name', name: 'unit_name' },
                { data: 'price', name: 'price' },
                { data: 'duration_type', name: 'duration_type' },
                { data: 'active', name: 'active' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        $(document).on("click", ".edit-btn", function () {
            const id = $(this).data('id');
            $('input[name="product_type_id"]').val($(this).data('product-type-id'));
            $('input[name="unit_id"]').val($(this).data('unit-id'));
            $('input[name="price"]').val($(this).data('price'));

            const form = $('#priceForm');
            form.attr('action', '/admin/master/general/product-type-price/update/' + id);
            if (!form.find('input[name="_method"]').length) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $('#priceCreateForm').show();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $("#cancelEditBtn, #closeEditBtn").click(function () {
            const form = $('#priceForm');
            form[0].reset();
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.general.product-type-price.store') }}");
            $('#priceCreateForm').hide();
        });

        $('#priceTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route('admin.master.general.product-type-price.toggle-status') }}', {
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

    function toggleView(view) {
        if (view === 'create') {
            $('#priceCreateForm').show();
        } else {
            $('#priceCreateForm').hide();
        }
    }
</script>
@stop
