@extends('adminlte::page')

@section('title', 'Palletization')

@section('content_header')
    <h1>Palletization</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.palletization.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>
</div>

<div class="card page-list">
    <div class="card-body">
        <table id="palletizationTable" class="table table-bordered table-striped page-list-table">
            <thead>
                <tr>
                    <th>Palletization No</th>
                    <th>Packing List No</th>
                    <th>Doc No</th>
                    <th>Vehicle No</th>
                    <th>Gatepass No</th>
                    <th>Client</th>
                    <th>Supplier</th>
                    <th>Total Pallets</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy Data Rows -->
                <tr>
                    <td>PAL-25-00001</td>
                    <td>PKG-25-00001</td>
                    <td>DOC-001</td>
                    <td>KL07AB1234</td>
                    <td>GP-1001</td>
                    <td>ABC Foods Ltd</td>
                    <td>LMG Grupa</td>
                    <td class="text-center">12</td>
                    <td class="text-center"><span class="badge badge-success">Completed</span></td>
                    <td>2025-08-20</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.palletization.view', 1) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.palletization.edit', 1) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.palletization.print', 1) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>PAL-25-00002</td>
                    <td>PKG-25-00002</td>
                    <td>DOC-002</td>
                    <td>KL07CD5678</td>
                    <td>GP-1002</td>
                    <td>Fresh Harvest</td>
                    <td>Global Fruits</td>
                    <td class="text-center">8</td>
                    <td class="text-center"><span class="badge badge-warning">Draft</span></td>
                    <td>2025-08-21</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.palletization.view', 2) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.palletization.edit', 2) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.palletization.print', 2) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>PAL-25-00003</td>
                    <td>PKG-25-00003</td>
                    <td>DOC-003</td>
                    <td>KL07EF9012</td>
                    <td>GP-1003</td>
                    <td>Cold Chain Logistics</td>
                    <td>Fruitex Ltd</td>
                    <td class="text-center">15</td>
                    <td class="text-center"><span class="badge badge-primary">Dispatched</span></td>
                    <td>2025-08-22</td>
                    <td class="text-center">
                        <a href="{{ route('admin.inventory.palletization.view', 3) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.inventory.palletization.edit', 3) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.palletization.print', 3) }}" class="btn btn-sm btn-secondary" title="Print"><i class="fas fa-print"></i></a>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('js')
<script>
$(function () {
    $('#palletizationTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        order: [[9, 'desc']]
    });
});
</script>
@endsection
