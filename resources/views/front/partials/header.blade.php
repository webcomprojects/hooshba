<header class="tg-header__style-four transparent-header">
    <div class="tg-header__top tg-header__top-three">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="tg-header__top-info tg-header__top-info-four list-wrap">
                        @if (option('info_tel'))
                            <li><i class="flaticon-phone-call"></i><a href="tel:{{ option('info_tel') }}"
                                    dir="ltr">{{ option('info_tel') }}</a>
                            </li>
                        @endif

                        @if (option('info_address'))
                            <li><i class="flaticon-pin"></i>{{ option('info_address') }}</li>
                        @endif

                    </ul>
                </div>
                <div class="col-lg-6">
                    <!--<ul class="tg-header__top-right tg-header__top-right-four list-wrap">-->
                    <!--    <li class="flex-md-column">-->
                    <!--        <span>-->
                    <!--            <img width="100" src="{{ asset('assets/front/img/besmellah.svg') }}" alt="">-->
                    <!--        </span>-->
                    <!--        <span class="d-flex">-->
                    <!--            <p class="font-weight-700 color-white">-->
                    <!--                مقام معظم رهبری:-->
                    <!--            </p>-->
                    <!--            <p class="color-white font-s-15p">-->
                    <!--                برعمق هوش مصنوعی مسلط شوید.-->
                    <!--            </p>-->
                    <!--        </span>-->
                    <!--    </li>-->
                    <!--    <li>-->
                    <!--        <img src="{{ asset('assets/front/img/rahbari-image.webp') }}" alt="">-->
                    <!--    </li>-->
                    <!--</ul>-->
                </div>
            </div>
        </div>
    </div>

    @php
        $categories = \App\Models\Category::where('type', 'committee')->orderBy('ordering', 'asc')->get();
        $provinces = \App\Models\Province::latest()->Published()->get();
    @endphp
    <div id="sticky-header" class="tg-header__area tg-header__area-four">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tgmenu__wrap home-9">
                        <nav class="tgmenu__nav">
                            <div class="logo">
                                <a href="/"><img src="{{ asset(option('info_nav_logo')) }}" alt="Logo"></a>
                            </div>
                            <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
             @include('front.partials.menu-header')


                            </div>
                            <div class="tgmenu__action tgmenu__action-four d-none d-md-block">
                                <ul class="list-wrap">
                                    {{-- <li class="header-search"> --}}
                                    <a href="javascript:void(0)" class="search-open-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="none">
                                            <path
                                                d="M19 19.0002L14.657 14.6572M14.657 14.6572C15.3999 13.9143 15.9892 13.0324 16.3912 12.0618C16.7933 11.0911 17.0002 10.0508 17.0002 9.00021C17.0002 7.9496 16.7933 6.90929 16.3913 5.93866C15.9892 4.96803 15.3999 4.08609 14.657 3.34321C13.9141 2.60032 13.0322 2.01103 12.0616 1.60898C11.0909 1.20693 10.0506 1 9.00002 1C7.94942 1 6.90911 1.20693 5.93848 1.60898C4.96785 2.01103 4.08591 2.60032 3.34302 3.34321C1.84269 4.84354 0.999817 6.87842 0.999817 9.00021C0.999817 11.122 1.84269 13.1569 3.34302 14.6572C4.84335 16.1575 6.87824 17.0004 9.00002 17.0004C11.1218 17.0004 13.1567 16.1575 14.657 14.6572Z"
                                                stroke="currentcolor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                    </li>
                                    <li class="header-btn">
                                        @if (Auth::check())
                                        <a href="/admin" class="btn">ورود به پنل</a>
                                        @else
                                        <a href="/login" class="btn">ورود</a>
                                        @endif
                                    </li>
                                    <li class="offCanvas-menu">
                                        <a href="javascript:void(0)" class="menu-tigger">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 18 18" fill="none">
                                                <path
                                                    d="M0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2Z"
                                                    fill="currentcolor"></path>
                                                <path
                                                    d="M0 9C0 7.89543 0.895431 7 2 7C3.10457 7 4 7.89543 4 9C4 10.1046 3.10457 11 2 11C0.895431 11 0 10.1046 0 9Z"
                                                    fill="currentcolor"></path>
                                                <path
                                                    d="M0 16C0 14.8954 0.895431 14 2 14C3.10457 14 4 14.8954 4 16C4 17.1046 3.10457 18 2 18C0.895431 18 0 17.1046 0 16Z"
                                                    fill="currentcolor"></path>
                                                <path
                                                    d="M7 2C7 0.895431 7.89543 0 9 0C10.1046 0 11 0.895431 11 2C11 3.10457 10.1046 4 9 4C7.89543 4 7 3.10457 7 2Z"
                                                    fill="currentcolor"></path>
                                                <path
                                                    d="M7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9Z"
                                                    fill="currentcolor"></path>
                                                <path
                                                    d="M7 16C7 14.8954 7.89543 14 9 14C10.1046 14 11 14.8954 11 16C11 17.1046 10.1046 18 9 18C7.89543 18 7 17.1046 7 16Z"
                                                    fill="currentcolor"></path>
                                                <path
                                                    d="M14 2C14 0.895431 14.8954 0 16 0C17.1046 0 18 0.895431 18 2C18 3.10457 17.1046 4 16 4C14.8954 4 14 3.10457 14 2Z"
                                                    fill="currentcolor"></path>
                                                <path
                                                    d="M14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9Z"
                                                    fill="currentcolor"></path>
                                                <path
                                                    d="M14 16C14 14.8954 14.8954 14 16 14C17.1046 14 18 14.8954 18 16C18 17.1046 17.1046 18 16 18C14.8954 18 14 17.1046 14 16Z"
                                                    fill="currentcolor"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mobile-nav-toggler mobile-nav-toggler-two">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 18 18" fill="none">
                                    <path
                                        d="M0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2Z"
                                        fill="currentcolor"></path>
                                    <path
                                        d="M0 9C0 7.89543 0.895431 7 2 7C3.10457 7 4 7.89543 4 9C4 10.1046 3.10457 11 2 11C0.895431 11 0 10.1046 0 9Z"
                                        fill="currentcolor"></path>
                                    <path
                                        d="M0 16C0 14.8954 0.895431 14 2 14C3.10457 14 4 14.8954 4 16C4 17.1046 3.10457 18 2 18C0.895431 18 0 17.1046 0 16Z"
                                        fill="currentcolor"></path>
                                    <path
                                        d="M7 2C7 0.895431 7.89543 0 9 0C10.1046 0 11 0.895431 11 2C11 3.10457 10.1046 4 9 4C7.89543 4 7 3.10457 7 2Z"
                                        fill="currentcolor"></path>
                                    <path
                                        d="M7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9Z"
                                        fill="currentcolor"></path>
                                    <path
                                        d="M7 16C7 14.8954 7.89543 14 9 14C10.1046 14 11 14.8954 11 16C11 17.1046 10.1046 18 9 18C7.89543 18 7 17.1046 7 16Z"
                                        fill="currentcolor"></path>
                                    <path
                                        d="M14 2C14 0.895431 14.8954 0 16 0C17.1046 0 18 0.895431 18 2C18 3.10457 17.1046 4 16 4C14.8954 4 14 3.10457 14 2Z"
                                        fill="currentcolor"></path>
                                    <path
                                        d="M14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9Z"
                                        fill="currentcolor"></path>
                                    <path
                                        d="M14 16C14 14.8954 14.8954 14 16 14C17.1046 14 18 14.8954 18 16C18 17.1046 17.1046 18 16 18C14.8954 18 14 17.1046 14 16Z"
                                        fill="currentcolor"></path>
                                </svg>
                            </div>
                        </nav>
                    </div>
                    <!-- Mobile Menu  -->
                    <div class="tgmobile__menu">
                        <nav class="tgmobile__menu-box">
                            <div class="close-btn"><i class="fas fa-times"></i></div>
                            <div class="nav-logo">
                                <a href="/"><img src="{{ asset(option('info_nav_logo')) }}" alt="Logo"></a>
                            </div>
                            {{-- <div class="tgmobile__search">
                                <form action="#">
                                    <input type="text" placeholder="جستجو ....">
                                    <button><i class="fas fa-search"></i></button>
                                </form>
                            </div> --}}
                            <div class="tgmobile__menu-outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="tgmobile__menu-bottom">
                                <div class="contact-info">
                                    <ul class="list-wrap">
                                        <li><a href="mailto:{{option('info_email')}}">{{option('info_email')}}</a></li>
                                        <li><a href="tel:{{option('info_tel')}}" dir="ltr">{{option('info_tel')}}</a></li>
                                    </ul>
                                </div>
                                <div class="social-links">
                                    <ul class="list-wrap">
                                        @if (option('social_telegram'))
                                        <li><a href="{{ option('social_telegram') }}"><i
                                                    class="fab fa-telegram"></i></a></li>
                                    @endif

                                    @if (option('social_instagram'))
                                        <li><a href="{{ option('social_instagram') }}"><i
                                                    class="fab fa-instagram"></i></a></li>
                                    @endif

                                    @if (option('social_whatsapp'))
                                        <li><a href="{{ option('social_whatsapp') }}"><i
                                                    class="fab fa-whatsapp"></i></a></li>
                                    @endif

                                    @if (option('social_facebook'))
                                        <li><a href="{{ option('social_facebook') }}"><i
                                                    class="fab fa-facebook-f"></i></a></li>
                                    @endif

                                    @if (option('social_youtube'))
                                        <li><a href="{{ option('social_youtube') }}"><i
                                                    class="fab fa-youtube"></i></a></li>
                                    @endif

                                    @if (option('social_aparat'))
                                        <li><a href="{{ option('social_aparat') }}"><i class="fab fa-video"></i></a>
                                        </li>
                                    @endif
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="tgmobile__menu-backdrop"></div>
                    <!-- End Mobile Menu -->
                </div>
            </div>
        </div>
    </div>
    <!-- header-search -->
    <div class="search__popup">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search__wrapper">
                        <div class="search__close">
                            <button type="button" class="search-close-btn">
                                <svg width="18" height="18" viewbox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="search__form">
                            <form action="#">
                                <div class="search__input">
                                    <input class="search-input-field" type="text" placeholder="جستجو کنید">
                                    <span class="search-focus-border"></span>
                                    <button>
                                        <svg width="20" height="20" viewbox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-popup-overlay"></div>
    <!-- header-search-end -->
    <!-- offCanvas-menu -->
    <div class="offCanvas__info">
        <div class="offCanvas__close-icon menu-close">
            <button><i class="far fa-window-close"></i></button>
        </div>
        <div class="offCanvas__logo mb-30">
            <a href="/"><img src="{{ asset(option('info_nav_logo')) }}" alt="Logo"></a>
        </div>
        <div class="offCanvas__side-info mb-30">
            @if (option('info_address'))
                <div class="contact-list mb-30">
                    <h4>آدرس </h4>
                    <p>{{ option('info_address') }}</p>
                </div>
            @endif

            @if (option('info_tel'))
                <div class="contact-list mb-30">
                    <h4>شماره تماس</h4>
                    <p>{{ option('info_tel') }}</p>
                </div>
            @endif

            @if (option('info_email'))
                <div class="contact-list mb-30">
                    <h4>آدرس ایمیل</h4>
                    <p>{{ option('info_email') }}</p>
                </div>
            @endif

        </div>
        <div class="offCanvas__social-icon mt-30">
            @if (option('social_telegram'))
            <a href="{{ option('social_telegram') }}"><i
                        class="fab fa-telegram"></i></a>
        @endif

        @if (option('social_instagram'))
            <a href="{{ option('social_instagram') }}"><i
                        class="fab fa-instagram"></i></a>
        @endif

        @if (option('social_whatsapp'))
            <a href="{{ option('social_whatsapp') }}"><i
                        class="fab fa-whatsapp"></i></a>
        @endif

        @if (option('social_facebook'))
            <a href="{{ option('social_facebook') }}"><i
                        class="fab fa-facebook-f"></i></a>
        @endif

        @if (option('social_youtube'))
            <a href="{{ option('social_youtube') }}"><i
                        class="fab fa-youtube"></i></a>
        @endif

        @if (option('social_aparat'))
            <a href="{{ option('social_aparat') }}"><i class="fab fa-video"></i></a>

        @endif
        </div>
    </div>
    <div class="offCanvas__overly"></div>
    <!-- offCanvas-menu-end -->
</header>
