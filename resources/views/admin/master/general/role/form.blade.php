@extends('adminlte::page')

@section('title', 'Role')

@section('content_header')
    <h1>Role</h1>
@endsection

@section('content')
@php
   if(isset($role)) {
        $page_title = 'Edit';
        $action = route('admin.master.general.role.update', $role->role_id);
        $method = 'PUT';

        $role_name = $role->role_name;
        $role_desc = $role->role_desc;
        $mobile_access = $role->mobile_access;
        $short_name = $role->short_name??'';
    } else {
        $page_title = 'Create';
        $action = route('admin.master.general.role.store');
        $method = 'POST';

        $role_name = '';
        $role_desc = '';
        $mobile_access = '';
        $short_name = '';
    }
@endphp

<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
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

    <div class="card page-form page-form-add">
        <div class="card-body">
            <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
                @csrf
                @method($method)
                <div class="tab-content mt-3" id="roleTabsContent">
                <!-- TAB 1: Role Info -->
                    <div class="tab-pane fade show active" id="role" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:180px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Role Name</div>
                                        <div class="pform-value">
                                            <input type="text" name="role_name" id="role_name" value="{{ old('role_name', $role_name) }}" required />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Short Name</div>
                                        <div class="pform-value">
                                            <input type="text" name="short_name" id="short_name" value="{{ old('short_name', $short_name) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Description</div>
                                        <div class="pform-value">
                                            <textarea name="role_desc" id="role_desc" >{{ old('role_desc', $role_desc) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Mobile Access</div>
                                        <div class="pform-value">
                                            <div class="form-switch">
                                                <input class="form-check-input" type="checkbox" name="mobile_access" id="mobile_access" value="1" {{ old('mobile_access', $mobile_access) ? 'checked' : '' }} >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: Permissions -->
                    <div class="tab-pane fade" id="permissions" role="tabpanel">
                        <table class="table table-bordered page-list-table role-per-tree" style="width:60%;" >
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    @foreach($permissions as $perm)
                                        <th >
                                            {{ ucfirst($perm->name) }}
                                            <input type="checkbox" class="select-all" data-perm="{{ $perm->permission_id }}">
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    @include('admin.master.general.role.partials.menu', [
                                        'menu' => $menu,
                                        'permissions' => $permissions,
                                        'assigned' => $assigned,
                                        'level' => 0
                                    ])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Submit -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-save float-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    /* .role-per-tree {}
    .role-per-tree tr {}
    .role-per-tree tr th { font-size:14px; padding:8px; }
    .role-per-tree tr td { font-size:14px; padding:8px; } 
    .role-per-tree td, .role-per-tree th { vertical-align: middle; }
    .role-per-tree thead th>input { float: right;}
    .role-per-tree tbody tr:hover { background-color: #f9f9f9; transition: background 0.2s ease-in-out; }
    .role-per-tree td:first-child { font-weight: 500; white-space: nowrap; padding-left: 10px; } */
    /* .form-switch .form-check-input { width: 2.5em; height: 1.2em; } */
</style>
@endpush

@section('js')
<script>
$(document).ready(function () {
    $('.select-all').on('change', function () {
        let permId = $(this).data('perm');
        let isChecked = $(this).is(':checked');

        $('input[type=checkbox][value="' + permId + '"]').each(function () {
            $(this).prop('checked', isChecked);
        });
    });
});
</script>
@endsection
