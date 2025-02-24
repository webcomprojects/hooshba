<div id="sidebar">

    <div class="side-menu-container">
        <ul class="metismenu" id="side-menu">
            <li class="open active conditional-bg">
                <a href="{{route('back.dashboard')}}" class="{{ active_class('back.dashboard')}}">
                    <i class="icon-home"></i>
                    <span>پیشخوان</span>
                </a>
            </li>

            @can('users')
  {{-- users --}}
            <li class="{{ open_class(['back.users.*']) }}">
                <a href="" class="dropdown-toggle">
                    <i class="fas fa-user-group"></i>
                    <span>کاربران</span>
                </a>
                <ul>
                    @can('users.index')
                    <li>
                        <a href="{{route('back.users.index')}}" class="{{ active_class('back.users.index').' '.active_class('back.users.edit') }}">
                            <i class=" far fa-circle-dot"></i>
                            <span>لیست کاربران</span>
                        </a>
                    </li>
                    @endcan



                    @can('users.create')
                    <li>
                        <a href="{{route('back.users.create')}}" class="{{ active_class('back.users.create') }}">
                            <i class=" far fa-circle-dot"></i>
                            <span> افزودن کاربر جدید</span>
                        </a>
                    </li>
                    @endcan



                </ul>
            </li>

            @endcan

            @can('posts')
            <li class="{{ open_class(['back.posts.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class=" fas  fab fa-blogger-b"></i>
                    <span>مقالات </span>
                </a>
                <ul>
                    @can('posts.index')
                    <li>
                        <a href="{{route('back.posts.index')}}" class="{{ active_class('back.posts.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>لیست مقالات </span>
                        </a>
                    </li>
                    @endcan
                    @can('posts.create')

                    <li>
                        <a href="{{route('back.posts.create')}}" class="{{ active_class('back.posts.create') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>ایجاد مقاله</span>
                        </a>
                    </li>
                    @endcan




                </ul>
            </li>
            @endcan


            @can('roles')
            <li class="{{ open_class(['back.roles.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class=" fas fa-unlock-keyhole"></i>
                    <span>مقام ها</span>
                </a>
                <ul>
                    @can('roles.index')
                    <li>
                        <a href="{{route('back.roles.index')}}" class="{{ active_class('back.roles.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>لیست مقام ها</span>
                        </a>
                    </li>
                    @endcan
                    @can('roles.create')

                    <li>
                        <a href="{{route('back.roles.create')}}" class="{{ active_class('back.roles.create') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>ایجاد مقام</span>
                        </a>
                    </li>
                    @endcan




                </ul>
            </li>
            @endcan


            @can('regions')
            <li class="{{ open_class(['back.regions.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class="  fas fa-map-location-dot"></i>
                    <span>مناطق </span>
                </a>
                <ul>
                    @can('regions.index')
                    <li>
                        <a href="{{route('back.regions.index')}}" class="{{ active_class('back.regions.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>لیست مناطق </span>
                        </a>
                    </li>
                    @endcan
                    @can('regions.create')

                    <li>
                        <a href="{{route('back.regions.create')}}" class="{{ active_class('back.regions.create') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>ایجاد منطقه</span>
                        </a>
                    </li>
                    @endcan




                </ul>
            </li>
            @endcan

            @can('provinces')
            <li class="{{ open_class(['back.provinces.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class="  fas fa-location-dot"></i>
                    <span>استان ها </span>
                </a>
                <ul>
                    @can('provinces.index')
                    <li>
                        <a href="{{route('back.provinces.index')}}" class="{{ active_class('back.provinces.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>لیست استان ها </span>
                        </a>
                    </li>
                    @endcan
                    @can('provinces.create')

                    <li>
                        <a href="{{route('back.provinces.create')}}" class="{{ active_class('back.provinces.create') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>ایجاد استان</span>
                        </a>
                    </li>
                    @endcan




                </ul>
            </li>
            @endcan








            {{-- posts --}}


        </ul><!-- /#side-menu -->
    </div><!-- /.side-menu-container -->
</div>