@extends('adminlte::page')

@section('title', 'Menu Management')

@section('content_header')
    <h1>Menu Management</h1>
@stop

@section('content')
<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <button class="btn btn-primary btn-sm" id="addMenuBtn" data-type="parent" title="create">
            <i class="fas fa-plus"></i> Add
        </button>
    </div>
</div>

<!-- Quick Filter -->
<div class="page-quick-filter">
    <div class="row">
        <div class="col-md-1 fltr-title">
            <span>FILTER BY</span>
        </div>
        <div class="col-md-3 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text pq-fltr-icon"><i class="fas fa-search fa-lg"></i></span>
            </div>
            <input type="text" id="searchQuery" class="form-control pq-fltr-input" placeholder="Type here" >
        </div>
        <div class="col-md-1 input-group">
            <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" onclick="searchAccount()"/>
        </div>
    </div>
</div>

<div class="card page-list-panel">
    <div class="card-body">
        <div id="menuTree">
            @forelse ($menus as $parent)
                <div class="card mb-2 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="{{ $parent->icon_class ?? 'fas fa-folder' }}"></i>
                            <strong>{{ $parent->menu_name }}</strong>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" onclick="openAddMenuModal({{ $parent->menu_id }})"><i class="fas fa-plus"></i></button>
                            <button class="btn btn-sm btn-outline-warning" onclick="openEditMenuModal({{ $parent->menu_id }})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#children-{{ $parent->menu_id }}">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                    <div id="children-{{ $parent->menu_id }}" class="collapse">
                        <ul class="list-group list-group-flush">
                            @foreach($parent->children as $child)
                                <li class="list-group-item d-flex justify-content-between align-items-center ps-5">
                                    <div>
                                        <i class="{{ $child->icon_class ?? 'far fa-file' }}"></i>
                                        {{ $child->menu_name }}
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-warning" onclick="openEditMenuModal({{ $child->menu_id }})"><i class="fas fa-edit"></i></button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">No menus available. Click "Add" to create one.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <form id="menuForm" action="{{ route('admin.master.general.menu.store') }}" method="POST">
        @csrf
        <input type="hidden" name="menu_id">
        <input type="hidden" name="parent_id" id="parent_id">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">Add Menu</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group" id="parentIdGroup" style="display:none;">
                    <label>Parent ID</label>
                    <input type="text" class="form-control" name="parent_id_display" disabled>
                </div>

                <div class="form-group">
                    <label>Menu Name</label>
                    <input type="text" class="form-control" name="menu_name" required>
                </div>

                <div class="form-group">
                    <label>Short Name</label>
                    <input type="text" class="form-control" name="short_name">
                </div>

                <div class="form-group">
                    <label>Menu Description</label>
                    <textarea class="form-control" name="menu_desc"></textarea>
                </div>

                <div class="form-group">
                    <label>Icon Class</label>
                    <input type="text" class="form-control" name="icon_class">
                </div>

                <div class="form-group">
                    <label>Path</label>
                    <input type="text" class="form-control" name="path">
                </div>

                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" value="0">
                </div>

                <div class="form-group">
                    <label>Active</label>
                    <select class="form-control" name="active">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Display</label>
                    <select class="form-control" name="display">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Menu</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection

@push('js')
<script>
    function openAddMenuModal(parentId = null) {
    $('#menuModalLabel').text(parentId ? 'Add Child Menu' : 'Add Parent Menu');
    $('#menuForm')[0].reset();
    $('#menuForm input[name=menu_id]').val('');
    $('#menuForm input[name=parent_id]').val(parentId);
    if (parentId) {
        $('#parentIdGroup').show();
    } else {
        $('#parentIdGroup').hide();
    }
    $('#menuModal').modal('show');
}

function openEditMenuModal(menuId) {
    $.get('/admin/menu/' + menuId + '/edit', function(data) {
        $('#menuModalLabel').text('Edit Menu');
        $('#menuForm input[name=menu_id]').val(data.menu_id);
        $('#menuForm input[name=menu_name]').val(data.menu_name);
        $('#menuForm input[name=short_name]').val(data.short_name);
        $('#menuForm input[name=icon_class]').val(data.icon_class);
        $('#menuForm input[name=path]').val(data.path);
        $('#menuForm input[name=sort_order]').val(data.sort_order);
        $('#menuForm input[name=parent_id]').val(data.parent_id);
        $('#menuForm select[name=active]').val(data.active);
        $('#menuForm select[name=display]').val(data.display);
        $('#menuForm textarea[name=menu_desc]').val(data.menu_desc);

        if (data.parent_id) {
            $('#parentIdGroup').show();
        } else {
            $('#parentIdGroup').hide();
        }

        $('#menuModal').modal('show');
    });
}
</script>
@endpush