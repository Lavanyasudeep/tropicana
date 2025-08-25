<tr>
    <td style="padding-left: {{ $level * 25 }}px;">
        @if($menu->children && $menu->children->count())
            <i class="fas fa-folder-open text-primary me-1"></i>
        @else
            <i class="fas fa-file-alt text-secondary me-1"></i>
        @endif
        {{ $menu->menu_name }}
    </td>
    @foreach ($permissions as $perm)
        @php
            $isChecked = isset($assigned[$menu->menu_id]) && in_array($perm->permission_id, $assigned[$menu->menu_id]);
        @endphp
        <td style="width:15%; text-align:center;">
            <div class="form-check form-switch d-inline-block">
                <input class="form-check-input"
                    type="checkbox"
                    name="permissions[{{ $menu->menu_id }}][]"
                    value="{{ $perm->permission_id }}"
                    {{ $isChecked ? 'checked' : '' }}>
            </div>
        </td>
    @endforeach
</tr>

@if($menu->children && $menu->children->count())
    @foreach($menu->children as $child)
        @include('admin.master.general.role.partials.menu', [
            'menu' => $child,
            'permissions' => $permissions,
            'assigned' => $assigned,
            'level' => $level + 1
        ])
    @endforeach
@endif
