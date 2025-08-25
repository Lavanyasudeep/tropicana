<li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center">
        <span>
            <i class="fas fa-folder"></i> {{ $menu->name }}
        </span>
        <span>
            <button class="btn btn-sm btn-success add-submenu" data-id="{{ $menu->id }}"><i class="fas fa-plus"></i></button>
            <button class="btn btn-sm btn-warning edit-menu" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-parent="{{ $menu->parent_id }}"><i class="fas fa-edit"></i></button>
            <button class="btn btn-sm btn-link toggle-submenu"><i class="fas fa-chevron-down"></i></button>
        </span>
    </div>

    @if ($menu->children->count())
        <ul class="list-group ml-4 mt-2 d-none submenu">
            @foreach($menu->children as $child)
                @include('admin.master.general.menu.item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>
