<h5 class="ca-col-header">
    Menu - {{ $parent->menu_name }}
    <button class="btn btn-sm btn-create" onclick="openForm('menu', {{ $parent->menu_id }})">+ Add</button>
</h5>
<ul>
    @foreach($children as $child)
    <li id="ca-ul-li-l2-{{ $parent->menu_id }}" >
        <a href="javascript:void(0)" onclick="loadMenu({{ $child->menu_id }})">
            <i class="{{ $child->icon_class ?? 'fas fa-folder' }}"></i>
            {{ $child->menu_name }}
        </a>
        <button class="btn btn-sm btn-warning btn-edit" onclick="editMenu('menu', {{ $child->menu_id }})" title="Edit" >
            <i class="fas fa-pen"></i>
        </button>
    </li>
    @endforeach
</ul>