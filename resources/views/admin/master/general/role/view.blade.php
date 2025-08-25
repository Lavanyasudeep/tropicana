@extends('adminlte::page')

@section('title', 'View Role')

@section('content_header')
    <h1>Role</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.general.role.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" id="roleTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="role-tab" data-toggle="tab" href="#role" role="tab">Role Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="permissions-tab" data-toggle="tab" href="#permissions" role="tab">Permissions</a>
        </li>
    </ul>

    
    <div class="card page-form" >
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="role" role="tabpanel">
                    <div class="row" >
                        <!-- Panel 1 -->
                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:250px;" >
                                <div class="pform-row">
                                    <div class="pform-label" >Role Name</div>
                                    <div class="pform-value" >{{ $role->role_name }}</div>
                                </div>
                                <div class="pform-row">
                                    <div class="pform-label" >Short Name</div>
                                    <div class="pform-value" >{{ $role->short_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Description</div>
                                    <div class="pform-value" >{{ $role->role_desc }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Mobile Access</div>
                                    <div class="pform-value" >{{ $role->mobile_access? 'Yes':'No' }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="tab-pane fade" id="permissions" role="tabpanel">
                    <table class="table table-bordered page-list-table">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                @foreach($permissions as $perm)
                                    <th class="text-center">{{ $perm->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="permission-tree">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection

@section('css')
<style>
</style>
@stop

@section('js')
<script>
const menus = @json($menus); // Nested menu array with children
const permissions = @json($permissions->map(fn($p) => ['id' => $p->permission_id, 'name' => $p->permission_name]));
const assigned = @json($assigned); // Example: { 1: [1, 2], 2: [4] }

function renderTree(menus, level = 0) {
    let html = '';
    menus.forEach(menu => {
        const padding = level * 25;
        const isFolder = menu.children && menu.children.length > 0;
        const iconClass = isFolder ? 'fas fa-folder-open text-primary me-1' : 'fas fa-file-alt text-secondary me-1';

        html += '<tr>';

        // Menu column with indentation and icon
        html += `<td style="padding-left: ${padding}px;">`;
        html += `<i class="${iconClass}"></i> ${menu.menu_name}</td>`;

        // Permission columns
        permissions.forEach(perm => {
            const hasPermission = assigned[menu.menu_id] && assigned[menu.menu_id].includes(perm.id);
            const icon = hasPermission ? '✅' : '❌';
            const label = hasPermission ? 'Granted' : 'Not Allowed';
            html += `<td class="text-center" style="width:15%;">${icon} <span class="text-muted small">${label}</span></td>`;
        });

        html += '</tr>';

        // Recurse into children
        if (isFolder) {
            html += renderTree(menu.children, level + 1);
        }
    });
    return html;
}

document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('permission-tree');
    tbody.innerHTML = renderTree(menus);
});
</script>
@stop
