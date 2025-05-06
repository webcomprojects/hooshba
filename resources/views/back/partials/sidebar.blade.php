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

                    @can('posts.category')

                    <li>
                        <a href="{{route('back.posts.categories')}}" class="{{ active_class('back.posts.categories') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>دسته بندی </span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('pages')
            <li class="{{ open_class(['back.pages.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class="fas fa-file-alt"></i>
                    <span>صفحات</span>
                </a>
                <ul>
                    @can('pages.index')
                    <li>
                        <a href="{{route('back.pages.index')}}" class="{{ active_class('back.pages.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>لیست صفحات</span>
                        </a>
                    </li>
                    @endcan
                    @can('pages.create')
                    <li>
                        <a href="{{route('back.pages.create')}}" class="{{ active_class('back.pages.create') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>ایجاد صفحه</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- @can('committees')
            <li class="{{ open_class(['back.committees.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class="  fas fa-users-rectangle"></i>
                    <span>کمیته ها </span>
                </a>
                <ul>
                    @can('committees.index')
                    <li>
                        <a href="{{route('back.committees.index')}}" class="{{ active_class('back.committees.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>لیست کمیته ها </span>
                        </a>
                    </li>
                    @endcan
                    @can('committees.create')

                    <li>
                        <a href="{{route('back.committees.create')}}" class="{{ active_class('back.committees.create') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>ایجاد کمیته</span>
                        </a>
                    </li>
                    @endcan
                    @can('committees.category')

                    <li>
                        <a href="{{route('back.committees.categories')}}" class="{{ active_class('back.committees.categories') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>دسته بندی </span>
                        </a>
                    </li>
                    @endcan



                </ul>
            </li>
            @endcan --}}


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

{{--
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
            @endcan --}}

            {{-- @can('members')
            <li class="{{ open_class(['back.members.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class="  fas fa-people-group"></i>
                    <span>اعضاء شورا </span>
                </a>
                <ul>
                    @can('members.index')
                    <li>
                        <a href="{{route('back.members.index')}}" class="{{ active_class('back.members.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>لیست اعضاء شورا </span>
                        </a>
                    </li>
                    @endcan
                    @can('members.create')

                    <li>
                        <a href="{{route('back.members.create')}}" class="{{ active_class('back.members.create') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>ایجاد عضو جدید</span>
                        </a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan --}}


            {{-- @can('provinces')
            <li class="{{ open_class(['back.about-us.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class="   fas fa-chalkboard-user"></i>
                    <span> درباره ما </span>
                </a>
                <ul>
                    @can('provinces.index')
                    <li class="">
                        <a href="{{route('back.about-us.organization-chart.index')}}" class="{{ active_class('back.about-us.organization-chart.index')}}">
                            <i class="far fa-circle-dot"></i>
                            <span>چارت سازمانی</span>
                        </a>
                    </li>
                    @endcan
                    @can('provinces.create')

                    <li>
                        <a href="{{route('back.about-us.introduction.index')}}" class="{{ active_class('back.about-us.introduction.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span> معرفی شوراء</span>
                        </a>
                    </li>
                    @endcan
                    @can('provinces.create')

                    <li>
                        <a href="{{route('back.about-us.goals.index')}}" class="{{ active_class('back.about-us.goals.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>  اهداف ما</span>
                        </a>
                    </li>
                    @endcan
                    @can('provinces.create')

                    <li>
                        <a href="{{route('back.about-us.plans.index')}}" class="{{ active_class('back.about-us.plans.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>  برنامه‌های ما</span>
                        </a>
                    </li>
                    @endcan




                </ul>
            </li>
            @endcan --}}

            @can('settings')
            <li class="{{ open_class(['back.settings.*']) }}">
                <a href="#" class="dropdown-toggle">
                    <i class="   icon-settings"></i>
                    <span> تنظیمات </span>
                </a>
                <ul>
                    @can('settings.general')
                    <li class="">
                        <a href="{{route('back.settings.information.index')}}" class="{{ active_class('back.settings.information.index')}}">
                            <i class="far fa-circle-dot"></i>
                            <span>تنظیمات عمومی</span>
                        </a>
                    </li>
                    @endcan
                     @can('settings.menu')

                    <li>
                        <a href="{{route('back.settings.menus.index')}}" class="{{ active_class('back.settings.menus.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span> منوها</span>
                        </a>
                    </li>
                    @endcan
                    @can('settings.social')

                    <li>
                        <a href="{{route('back.settings.socials.index')}}" class="{{ active_class('back.settings.socials.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span> شبکه های اجتماعی </span>
                        </a>
                    </li>
                    @endcan

                    @can('settings.footerLinks')

                    <li>
                        <a href="{{route('back.settings.footerlinks.index')}}" class="{{ active_class('back.settings.footerlinks.index') }}">
                            <i class="far fa-circle-dot"></i>
                            <span>لینک های فوتر</span>
                        </a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan









        </ul><!-- /#side-menu -->
    </div><!-- /.side-menu-container -->
</div>