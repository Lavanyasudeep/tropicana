@extends('adminlte::page')

@section('title', 'Menu')

@section('content_header')
    <h1>Menu</h1>
@endsection

@section('content')
    <!-- Toggle between Views -->
    <div class="page-sub-header">
        <h3>List</h3>
    </div>

    <!-- Quick Filter -->
    <div class="page-quick-filter">
        <div class="row">
            <div class="col-md-1 fltr-title">
                <span>FILTER BY</span>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text pq-fltr-icon"><i class="fas fa-search fa-lg"></i></span>
                    </div>
                    <input type="text" id="searchQuery" class="form-control pq-fltr-input" placeholder="Type here" >
                </div>
            </div>
            <div class="col-md-1">
                <div class="input-group">
                    <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" onclick="searchAccount()"/>
                </div>
            </div>
        </div>
    </div>

    <div class="card page-list-panel" >
        <div class="card-body" >

            <div id="finderTree" class="menuPanel" >
                <!-- Main Menu -->
                <div class="ca-col" id="level1Column">
                    <div class="ca-col-header" >
                        <h5>
                            Main Menu
                            <button class="btn btn-sm btn-create" onclick="openForm('mainmenu')">+ Add</button>
                        </h5>
                    </div>
                    <ul id="sortableMainMenu">
                        @foreach($menus as $parent)
                            <li id="ca-ul-li-{{$parent->menu_id}}" data-menu-id="{{ $parent->menu_id }}">
                                <a href="javascript:void(0)" onclick="loadSubMenu({{ $parent->menu_id }})" >
                                    <i class="{{ $parent->icon_class ?? 'fas fa-folder' }}"></i>
                                    {{ $parent->menu_name }}
                                </a>
                                <button class="btn btn-sm btn-warning btn-edit" onclick="editMenu('mainmenu', {{ $parent->menu_id }})" title="Edit" >
                                    <i class="fas fa-pen"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Level 2 and onward columns -->
                <div class="ca-col" id="sub-menu-column"></div>
                <div class="ca-col" id="menu-column"></div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="menuModal">
        <div class="modal-dialog">
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

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="display" value="1" id="menuDisplay" checked >
                            <label class="form-check-label" for="menuDisplay">Display</label>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="is_quick_menu" value="1" id="menuQuick">
                            <label class="form-check-label" for="menuQuick">Quick Menu</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
<style>
    .menuPanel { display:flex; }
    .menuPanel .ca-col { width:33.33%; float:left; border:1px solid #CCC; margin-left:-1px; }
    .menuPanel .ca-col-header { margin:0; padding:15px; min-height:62px; background-color:#1b5f76; color:#fff; font-size:16px; }
    .menuPanel .ca-col-header h5 { margin:0; padding:0; font-size:16px; }
    .menuPanel .ca-col-header button { float:right; }
    .menuPanel ul { list-style-type:none; margin:0; padding:0; }
    .menuPanel ul li { margin:0; padding:0; border-bottom:1px solid #CCC; position:relative; }
    .menuPanel ul li a { color:#000; font-size:16px; padding:5px 10px; width: 100%; display: block; }
    .menuPanel ul li a i { margin-right:5px; color:#333; }
    .menuPanel ul li a span { font-size:12px; display:block; }
    .menuPanel ul li .btn-edit { font-size:12px; float:right; position:absolute; top:4px; right:4px; }
    .menuPanel ul li.active { background-color:#dbdfe0; color:#000; }
    .menuPanel ul li:hover { background-color:#dbdfe0; color:#000; } 
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
function loadSubMenu(menu_id) {
    $('#ca-ul-li-'+menu_id).closest('ul').find('li a i.fa-folder-open').removeClass('fa-folder-open').addClass('fa-folder');
    $('#ca-ul-li-'+menu_id+' i').removeClass('fa-folder').addClass('fa-folder-open');

    $('#ca-ul-li-'+menu_id).closest('ul').find('li').removeClass('active');
    $('#ca-ul-li-'+menu_id).addClass('active');

    $.get("{{ route('admin.master.general.menu.get-sub-menu') }}", { menu_id }, function(html) {
        $('#sub-menu-column').html(html);
    });
}

function loadMenu(menu_id) {
    $('#ca-ul-li-l2-'+menu_id).closest('ul').find('li').removeClass('active');
    $('#ca-ul-li-l2-'+menu_id).addClass('active');

    $.get("{{ route('admin.master.general.menu.get-menu') }}", { menu_id }, function(html) {
        $('#menu-column').html(html);
    });
}

// function openForm(type, parentId = null) {
//     $('#menuForm')[0].reset();
//     $('#menuForm input[name=menu_id]').val('');
//     $('#menuForm input[name=parent_id]').val(parentId);
//     $('#menuModal').modal('show');
// }
function openForm(type, parentId = null) {
    const form = $('#menuForm');
    form[0].reset();

    // reset action + method
    form.attr('action', "{{ route('admin.master.general.menu.store') }}");
    form.find('input[name=_method]').remove(); // remove hidden _method if exists

    form.find('input[name=menu_id]').val('');
    form.find('input[name=parent_id]').val(parentId);

    $('#menuModalLabel').text('Add Menu');
    $('#menuModal').modal('show');
}

function openForm(type, parentId = null) {
    const form = $('#menuForm');
    form[0].reset();

    // reset action + method
    form.attr('action', "{{ route('admin.master.general.menu.store') }}");
    form.find('input[name=_method]').remove(); // remove hidden _method if exists

    form.find('input[name=menu_id]').val('');
    form.find('input[name=parent_id]').val(parentId);

    $('#menuModalLabel').text('Add Menu');
    $('#menuModal').modal('show');
}

function editMenu(type, id) {
    $.get("{{ url('admin/master/general/menu') }}/" + id + "/edit", function(data) {
        const form = $('#menuForm');

        form.find('input[name=menu_id]').val(data.menu_id);
        form.find('input[name=parent_id]').val(data.parent_id);
        form.find('input[name=menu_name]').val(data.menu_name);
        form.find('input[name=short_name]').val(data.short_name);
        form.find('textarea[name=menu_desc]').val(data.menu_desc);
        form.find('input[name=icon_class]').val(data.icon_class);
        form.find('input[name=path]').val(data.path);
        form.find('input[name=sort_order]').val(data.sort_order);
        form.find('select[name=active]').val(data.active);
        form.find('select[name=display]').val(data.display);

        // update form action
        form.attr('action', "{{ url('admin/master/general/menu/update') }}/" + id);

        // inject PUT method if not already there
        if (!form.find('input[name=_method]').length) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        }

        $('#menuModalLabel').text('Edit Menu');
        $('#menuModal').modal('show');
    });
}

function searchAccount() {
    const q = $('#searchQuery').val();
    if (!q) return;

    $.get("{{ route('admin.master.general.menu.search') }}", { q }, function(data) {
        if (data.found) {
            loadSubMenu(data.menu_id);
            setTimeout(() => {
                loadMenu(data.menu_id);
                setTimeout(() => {
                    highlightMenu(data.menu_id);
                }, 500);
            }, 500);
        } else {
            alert("No menu found matching: " + q);
        }
    });
}

function highlightMenu(menu_id) {
    const selector = `[data-menu-id="${menu_id}"]`;
    const el = $(selector);
    if (el.length) {
        el.addClass('bg-warning');
        el[0].scrollIntoView({ behavior: "smooth", block: "center" });
        setTimeout(() => el.removeClass('bg-warning'), 3000);
    }
}

$(function () {
    $('#sortableMainMenu').sortable({
        placeholder: "ui-state-highlight",
        update: function (event, ui) {
            let order = [];
            $('#sortableMainMenu li').each(function (index) {
                order.push({
                    id: $(this).data('menu-id'),
                    sort_order: index + 1
                });
            });

            // Auto-save order via AJAX
            $.ajax({
                url: '{{ route("admin.master.general.menu.sort.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order: order
                },
                success: function (res) {
                    console.log('Sort order updated');
                },
                error: function () {
                    alert('Failed to update sort order');
                }
            });
        }
    });
});
</script>
@endpush