<div id="sidebar">

    <div class="side-menu-container">
        <ul class="metismenu" id="side-menu">
            <li class="open active conditional-bg">
                <a href="/admin">
                    <i class="icon-home"></i>
                    <span>پیشخوان</span>
                </a>
            </li>

            {{-- users --}}
            <li class="{{ open_class(['back.users.*']) }}">
                <a href="" class="dropdown-toggle">
                    <i class="fas fa-user-group"></i>
                    <span>کاربران</span>
                </a>
                <ul>
                    <li>
                        <a href="{{route('back.users.index')}}" class="{{ active_class('back.users.index').' '.active_class('back.users.edit') }}">
                            <i class=" far fa-circle-dot"></i>
                            <span>لیست کاربران</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('back.users.create')}}" class="{{ active_class('back.users.create') }}">
                            <i class=" far fa-circle-dot"></i>
                            <span> افزودن کاربر جدید</span>
                        </a>
                    </li>

                </ul>
            </li>

            {{-- posts --}}
        

        </ul><!-- /#side-menu -->
    </div><!-- /.side-menu-container -->
</div>