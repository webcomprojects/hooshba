<header class="tg-header__style-four transparent-header">
    <div class="tg-header__top tg-header__top-three">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="tg-header__top-info tg-header__top-info-four list-wrap">
                        <li><i class="flaticon-phone-call"></i><a href="tel:0123456789" dir="ltr">+123 9898 500</a></li>
                        <li><i class="flaticon-pin"></i>شیراز - بلوار چمران کوچه 12 </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul class="tg-header__top-right tg-header__top-right-four list-wrap">
                        <li class="flex-md-column">
                            <span>
                                <img width="100" src="{{asset('assets/front/img/besmellah.svg')}}" alt="">
                            </span>
                            <span class="d-flex">
                                <p class="font-weight-700 color-white">
                                    مقام معظم رهبری:
                                </p>
                                <p class="color-white font-s-15p">
                                    برعمق هوش مصنوعی مسلط شوید.
                                </p>
                            </span>
                        </li>
                        <li>
                            <img src="{{asset('assets/front/img/rahbari-image.webp')}}" alt="">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="sticky-header" class="tg-header__area tg-header__area-four">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tgmenu__wrap home-9">
                        <nav class="tgmenu__nav">
                            <div class="logo">
                                <a href="/"><img src="{{asset('assets\front\img\logo\nav-logo.webp')}}" alt="Logo"></a>
                            </div>
                            <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                                <ul class="navigation">
                                    <li class="active">
                                        <a href="/">خانه</a>

                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="/blog">اخبار</a>
                                         <ul class="sub-menu">
                                            <li><a href='/blog'>اخبار</a></li>
                                            <li><a href='/blog?c=رویداد'>رویدادها</a></li>
                                            <li><a href='/blog?c=نمایشگاه'>نمایشگاه‌ها</a></li>
                                        </ul>
                                    </li>
                                    <li class="">
                                        <a href="/">برج هوش مصنویی</a>

                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">سامانه ها</a>
                                        <ul class="sub-menu">
                                            <li class="menu-item-has-children menu-arrow-left">
                                                <a href=''>سامانه آموزشی</a>
                                                <ul class="sub-menu">
                                                    <li><a href=''> آموزش عمومی</a></li>
                                                    <li><a href='https://techwich.org/auth/register'> آموزش تخصصی</a></li>
                                                </ul>
                                            </li>
                                            <li><a href=''> سامانه خدمات هوش مصنوعی</a></li>
                                            <li><a href=''> سامانه های متصل</a></li>

                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">درباره ما</a>
                                        {{-- <ul class="sub-menu">
                                            <li><a href='about.html'>درباره  ما (کسب و کار)</a></li>
                                            <li><a href='about-2.html'>درباره ما (سرمایه گذاری)</a></li>
                                            <li><a href='about-5.html'>درباره ما (مشاوره)</a></li>
                                            <li><a href='about-3.html'>درباره ما (بیمه)</a></li>
                                            <li><a href='about-4.html'>درباره ما (دیجیتال مارکتینگ)</a></li>
                                        </ul> --}}
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">ارتباط با ما</a>
                                        {{-- <ul class="sub-menu">
                                            <li><a href='services.html'>خدمات ما (کسب و کار)</a></li>
                                            <li><a href='services-2.html'>خدمات ما (سرمایه گذاری)</a></li>
                                            <li><a href='services-3.html'>خدمات ما (مشاوره)</a></li>
                                            <li><a href='services-4.html'>خدمات ما (بیمه)</a></li>
                                            <li><a href='services-5.html'>خدمات ما (دیجیتال مارکتینگ)</a></li>
                                            <li><a href='services-details.html'>خدمات تکی 1</a></li>
                                            <li><a href='services-details-2.html'>خدمات تکی 2</a></li>
                                            <li><a href='services-details-3.html'>خدمات تکی 3</a></li>
                                            <li><a href='services-details-4.html'>خدمات تکی 4</a></li>
                                            <li><a href='services-details-5.html'>خدمات تکی 5</a></li>
                                        </ul> --}}
                                    </li>

                                    <li class="">
                                        <a href="/membership">عضویت در انجمن</a>

                                    </li>


                                </ul>
                            </div>
                            <div class="tgmenu__action tgmenu__action-four d-none d-md-block">
                                <ul class="list-wrap">
                                    {{-- <li class="header-search"> --}}
                                        <a href="javascript:void(0)" class="search-open-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="none">
                                                <path d="M19 19.0002L14.657 14.6572M14.657 14.6572C15.3999 13.9143 15.9892 13.0324 16.3912 12.0618C16.7933 11.0911 17.0002 10.0508 17.0002 9.00021C17.0002 7.9496 16.7933 6.90929 16.3913 5.93866C15.9892 4.96803 15.3999 4.08609 14.657 3.34321C13.9141 2.60032 13.0322 2.01103 12.0616 1.60898C11.0909 1.20693 10.0506 1 9.00002 1C7.94942 1 6.90911 1.20693 5.93848 1.60898C4.96785 2.01103 4.08591 2.60032 3.34302 3.34321C1.84269 4.84354 0.999817 6.87842 0.999817 9.00021C0.999817 11.122 1.84269 13.1569 3.34302 14.6572C4.84335 16.1575 6.87824 17.0004 9.00002 17.0004C11.1218 17.0004 13.1567 16.1575 14.657 14.6572Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="header-btn"><a href="/login" class="btn">ورود</a></li>
                                    <li class="offCanvas-menu">
                                        <a href="javascript:void(0)" class="menu-tigger">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 18 18" fill="none">
                                                <path d="M0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2Z" fill="currentcolor"></path>
                                                <path d="M0 9C0 7.89543 0.895431 7 2 7C3.10457 7 4 7.89543 4 9C4 10.1046 3.10457 11 2 11C0.895431 11 0 10.1046 0 9Z" fill="currentcolor"></path>
                                                <path d="M0 16C0 14.8954 0.895431 14 2 14C3.10457 14 4 14.8954 4 16C4 17.1046 3.10457 18 2 18C0.895431 18 0 17.1046 0 16Z" fill="currentcolor"></path>
                                                <path d="M7 2C7 0.895431 7.89543 0 9 0C10.1046 0 11 0.895431 11 2C11 3.10457 10.1046 4 9 4C7.89543 4 7 3.10457 7 2Z" fill="currentcolor"></path>
                                                <path d="M7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9Z" fill="currentcolor"></path>
                                                <path d="M7 16C7 14.8954 7.89543 14 9 14C10.1046 14 11 14.8954 11 16C11 17.1046 10.1046 18 9 18C7.89543 18 7 17.1046 7 16Z" fill="currentcolor"></path>
                                                <path d="M14 2C14 0.895431 14.8954 0 16 0C17.1046 0 18 0.895431 18 2C18 3.10457 17.1046 4 16 4C14.8954 4 14 3.10457 14 2Z" fill="currentcolor"></path>
                                                <path d="M14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9Z" fill="currentcolor"></path>
                                                <path d="M14 16C14 14.8954 14.8954 14 16 14C17.1046 14 18 14.8954 18 16C18 17.1046 17.1046 18 16 18C14.8954 18 14 17.1046 14 16Z" fill="currentcolor"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mobile-nav-toggler mobile-nav-toggler-two">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 18 18" fill="none">
                                    <path d="M0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2Z" fill="currentcolor"></path>
                                    <path d="M0 9C0 7.89543 0.895431 7 2 7C3.10457 7 4 7.89543 4 9C4 10.1046 3.10457 11 2 11C0.895431 11 0 10.1046 0 9Z" fill="currentcolor"></path>
                                    <path d="M0 16C0 14.8954 0.895431 14 2 14C3.10457 14 4 14.8954 4 16C4 17.1046 3.10457 18 2 18C0.895431 18 0 17.1046 0 16Z" fill="currentcolor"></path>
                                    <path d="M7 2C7 0.895431 7.89543 0 9 0C10.1046 0 11 0.895431 11 2C11 3.10457 10.1046 4 9 4C7.89543 4 7 3.10457 7 2Z" fill="currentcolor"></path>
                                    <path d="M7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9Z" fill="currentcolor"></path>
                                    <path d="M7 16C7 14.8954 7.89543 14 9 14C10.1046 14 11 14.8954 11 16C11 17.1046 10.1046 18 9 18C7.89543 18 7 17.1046 7 16Z" fill="currentcolor"></path>
                                    <path d="M14 2C14 0.895431 14.8954 0 16 0C17.1046 0 18 0.895431 18 2C18 3.10457 17.1046 4 16 4C14.8954 4 14 3.10457 14 2Z" fill="currentcolor"></path>
                                    <path d="M14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9Z" fill="currentcolor"></path>
                                    <path d="M14 16C14 14.8954 14.8954 14 16 14C17.1046 14 18 14.8954 18 16C18 17.1046 17.1046 18 16 18C14.8954 18 14 17.1046 14 16Z" fill="currentcolor"></path>
                                </svg>
                            </div>
                        </nav>
                    </div>
                    <!-- Mobile Menu  -->
                    <div class="tgmobile__menu">
                        <nav class="tgmobile__menu-box">
                            <div class="close-btn"><i class="fas fa-times"></i></div>
                            <div class="nav-logo">
                                <a href="index.html"><img src="assets\img\logo\logo.png" alt="Logo"></a>
                            </div>
                            <div class="tgmobile__search">
                                <form action="#">
                                    <input type="text" placeholder="جستجو ....">
                                    <button><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                            <div class="tgmobile__menu-outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="tgmobile__menu-bottom">
                                <div class="contact-info">
                                    <ul class="list-wrap">
                                        <li><a href="mailto:info@apexa.com">info@apexa.com</a></li>
                                        <li><a href="tel:0123456789" dir="ltr">+123 888 9999</a></li>
                                    </ul>
                                </div>
                                <div class="social-links">
                                    <ul class="list-wrap">
                                        <li>
                                            <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><i class="fab fa-youtube"></i></a>
                                        </li>
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
                                <svg width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="search__form">
                            <form action="#">
                                <div class="search__input">
                                    <input class="search-input-field" type="text" placeholder="جستجو کنید">
                                    <span class="search-focus-border"></span>
                                    <button>
                                        <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
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
            <a href="index.html"><img src="{{asset('assets\front\img\logo\nav-logo.webp')}}" alt="Logo"></a>
        </div>
        <div class="offCanvas__side-info mb-30">
        <div class="contact-list mb-30">
            <h4>آدرس دفتر مرکزی</h4>
            <p>شیراز - بلوار ارم کوچه 3<br>ساختمان یاس </p>
        </div>
        <div class="contact-list mb-30">
            <h4>شماره تماس</h4>
            <p>+0989 7876 9865 9</p>
            <p>+(090) 8765 86543 85</p>
        </div>
        <div class="contact-list mb-30">
            <h4>آدرس ایمیل</h4>
            <p>info@example.com</p>
            <p>example.mail@hum.com</p>
        </div>
        </div>
        <div class="offCanvas__social-icon mt-30">
            <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
            <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
            <a href="javascript:void(0)"><i class="fab fa-google-plus-g"></i></a>
            <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
    <div class="offCanvas__overly"></div>
    <!-- offCanvas-menu-end -->
</header>