@php
    $menus = App\Models\Menu::orderBy('ordering')->get();
    $parentMenus = $menus->whereNull('parent_id');
@endphp

<ul class="navigation">
    @foreach($parentMenus as $menu)
        <li class="{{ $menu->class_name ?? ($menus->where('parent_id', $menu->id)->count() > 0 ? 'menu-item-has-children' : '') }}">
            <a href="{{ $menu->link }}">{{ $menu->name }}</a>

            @if($menus->where('parent_id', $menu->id)->count() > 0)
                <ul class="sub-menu">
                    @foreach($menus->where('parent_id', $menu->id) as $submenu)
                        <li class="{{ $submenu->class_name ?? ($menus->where('parent_id', $submenu->id)->count() > 0 ? 'menu-item-has-children menu-arrow-left' : '') }}">
                            <a href="{{ $submenu->link }}">{{ $submenu->name }}</a>

                            @if($menus->where('parent_id', $submenu->id)->count() > 0)
                                <ul class="sub-menu">
                                    @foreach($menus->where('parent_id', $submenu->id) as $thirdLevel)
                                        <li class="{{ $thirdLevel->class_name ?? '' }}">
                                            <a href="{{ $thirdLevel->link }}">{{ $thirdLevel->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>