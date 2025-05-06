<li class="dd-item" data-id="{{ $menu['id'] }}">
    <div class="dd-handle">
        <span>{{ $menu['name'] }}</span>

    </div>
    <span class="operation-menu-item">
        <span data-bs-toggle="modal" data-bs-target="#edit-menu-modal" data-data="{{ route('back.settings.menus.edit', $menu['id']) }}" data-action="{{ route('back.settings.menus.update', $menu['id']) }}" class=" fas fa-pen edit-menu-item"></span>
        <span data-bs-toggle="modal" data-bs-target="#delete-modal"
            data-action="{{ route('back.settings.menus.destroy', $menu['id']) }}"
            class=" btn-danger delete-modal fas fa-trash-can remove-menu-item"></span>
    </span>
    @if (!empty($menu['children']))
        <ol class="dd-list dd-list-child">
            @foreach ($menu['children'] as $child)
                @include('back.menus.menu-item', ['menu' => $child])
            @endforeach
        </ol>
    @endif
</li>
