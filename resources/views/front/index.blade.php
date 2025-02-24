@extends('front.layouts.master')

@push('meta')
    <meta name="description" content="{{ option('info_short_description') }}">
    <meta name="keywords" content="{{ option('info_tags') }}">

    <link rel="canonical" href="{{ url('/') }}" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "url": "{{ route('front.index') }}",
            "name": "{{ option('site_title') }}",
            "logo": "{{ option('info_logo') ? asset(option('info_logo')) : asset(config('front.asset_path') . 'img/logo.png') }}",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
@endpush

@section('content')
    <!-- banner-area -->
    <section class="slider__area">
        <div class="swiper-container ">
            {{-- .slider_baner__active --}}

            <div class="swiper-wrapper">
                {{-- <div class="swiper-slide"> --}}
                <div class="swiper-slide">
                    <div class="banner__area-three banner__bg-five"
                        data-background="{{ asset('assets/front/img/banner/h9_banner_bg.jpg') }}">
                        <div class="container">
                            <div class="row">
                                {{-- <div class="col-xl-7 col-lg-6">
                                <div class="banner__content-three home-9">

                                </div>
                            </div> --}}
                                <div class="col-xl-12 col-lg-12">
                                    <div class="banner__img home-9 video-slider">
                                        <video class="w-100" style="height: 400px; width: 100%;" autoplay muted loop>
                                            <source src="/assets/front/img/slider/bg-video.mp4" type="video/mp4">
                                            مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
                                        </video>

                                    </div>
                                </div>
                            </div>

                            {{-- تماس باما افقی --}}
                            {{-- <div class="banner-social banner-social-three banner-social-home-9">
                            <h5 class="title">مارا دنبال کنید</h5>
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
                                    <a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                            </ul>
                        </div> --}}

                        </div>
                    </div>
                </div>


            </div>
        </div>
        {{-- <div class="box-button-slider-bottom home-9 d-none d-lg-block">
        <div class="container">
            <div class="testimonial__nav-four">
                <div class="testimonial-two-button-prev button-swiper-prev"><i class="flaticon-right-arrow"></i></div>
                <div class="testimonial-two-button-next button-swiper-next"><i class="flaticon-right-arrow"></i></div>
            </div>
        </div>
    </div> --}}
    </section>
    <!-- banner-area-end -->
    <!-- features-area -->
    <section id="new-news" class="features__area-two ">
        <div class="container">
            <div class="row gutter-24 justify-content-center new-news-div">
                <div class="new-news-div-title">
                    <div class="box-yellow-sizing"></div>
                    <h3>تازه‌ترین‌ اخبار</h3>
                </div>

                @foreach ($last_posts as $last_post)
                    <div class="col-lg-4 col-md-6">
                        <div class="features__item-two">
                            <div class="features__icon-two">
                                <img src="{{ asset($last_post->featured_image) }}" alt="{{ $last_post->title }}">
                            </div>
                            <div class="features__content-two">
                                {{-- <h4 class="title">
                                    <a href='services-details.html'> </a>
                                </h4> --}}
                                <a class="title">{{ $last_post->title }}</a>
                                <div class="blog-post-meta mb-20">
                                    <ul class="list-wrap">
                                        <li><i
                                                class="fas fa-calendar-alt"></i>{{ jDate($last_post->created_at)->format('%B %d، %Y') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- features-area-end -->
    <!-- brand-area -->

    <section class="services-area services-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section-title text-center mb-40 tg-heading-subheading animation-style3">
                        <span class="sub-title">جدیدترین ویدئو ها</span>
                        <h2 class="title ">میتوانید ویدئو ها را در اینجا تماشا کنید</h2>
                    </div>
                </div>
            </div>
            <div class="services-item-wrap">
                <div class="row justify-content-center">
                    @foreach ($video_posts as $video)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="services-item shine-animate-item">
                                <div class="services-thumb">
                                    <a class="shine-animate" href="services-details.html"><img
                                            src="{{ asset($video->featured_image) }}" alt="{{ $video->title }}"></a>
                                </div>
                                <div class="services-content">
                                    <a class="icon">
                                        <i class="fas fa-solid fa-play"></i>
                                    </a>
                                    <h4 class="title">
                                        <a href="services-details.html">{{ $video->title }}</a>
                                    </h4>

                                    <div class="blog-post-meta mb-20">
                                        <ul class="list-wrap">
                                            <li><i
                                                    class="fas fa-calendar-alt"></i>{{ jDate($video->created_at)->format('%B %d، %Y') }}
                                            </li>
                                        </ul>
                                    </div>

                                    <a class="btn btn-no-arrow" href="blog-details.html">
                                        مشاهده ویدئو |
                                        <i class="fas fa-solid fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="services-bottom-content">
                <p>برای مشاهده بیشتر کلیک کنید</p>
                <a class="btn" href="services.html">نمایش همه ویدئوها</a>
            </div>

        </div>
    </section>


    <section class="testimonial__area-two">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title white-title text-center mb-50">
                        <span class="sub-title">تازه‌ترین رویدادهای دنیای هوش مصنوعی را در این سایت دنبال کنید!</span>
                        <h2 class="title">تازه‌ترین ‌رویداد‌ها</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center gutter-24">
                <div class="col-12">
                    <div class="swiper-container events-slider">
                        <div class="swiper-wrapper">
                            @foreach ($event_posts as $event)
                                <div class="swiper-slide">

                                    <div class="blog-post-item blog__post-three shine-animate-item p-0 ">
                                        <div class="blog-post-thumb blog__post-thumb-three mb-3">
                                            <a class="shine-animate" href="blog-details.html"><img
                                                    src="{{ asset($event->featured_image) }}" alt="{{ $event->title }}"></a>
                                        </div>
                                        <div class="blog-post-content blog__post-content-three p-2 pt-0">
                                            <h2 class="title"><a href="blog-details.html">{{ $event->title }}</a>
                                            </h2>
                                            <div class="blog-post-meta mb-20">
                                                <ul class="list-wrap">
                                                    <li><i
                                                            class="fas fa-calendar-alt"></i>{{ jDate($event->created_at)->format('%B %d، %Y') }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <a class="btn" href="blog-details.html">مطالعه بیشتر</a>
                                        </div>
                                    </div>

                                </div> <!--swiper slider-->
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="testimonial__shape-two">
            <img src="assets\img\images\h2_testimonial_shape.png" alt="" data-aos="fade-up" data-aos-delay="400">
        </div>
    </section>


    <section class="our_team__area-six mb-6rem">
        <div class="container">
            <div class="section-title mb-30 tg-heading-subheading animation-style3 text-center">
                <span class="sub-title text-capitalize">تازه‌ترین رویدادهای دنیای هوش مصنوعی را در این سایت دنبال کنید!                </span>
                <h2 class="title "> تازه‌ترین ‌رویداد‌ها</h2>
            </div>
            <div class="row">
                @foreach ($posts as $event)
                <div class="col-lg-6">
                    <div class="card-team-area-six">
                        <div class="card-image">
                            <img src="{{ asset($event->featured_image) }}" alt="{{ $event->title }}">
                        </div>
                        <div class="card-info">
                            <div class="card-title">
                                <a href="team-details.html">{{$event->title}}</a>
                                <p class="card-dept mt-10">{{ @$event->categories->first()->name }}</p>
                            </div>
                            <div class="blog-post-meta mb-20">
                                <ul class="list-wrap">
                                    <li><i
                                            class="fas fa-calendar-alt"></i>{{ jDate($event->created_at)->format('%B %d، %Y') }}
                                    </li>
                                </ul>
                            </div>
                            <a class="btn" href="blog-details.html">مطالعه بیشتر</a>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
            <div class="text-center">
                <a class="btn aos-init aos-animate" data-aos-delay="600" data-aos="fade-up" href="contact.html">نمایش همه رویدادها</a>
            </div>
        </div>
    </section>


    <section class="consulting-area mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="consulting-inner-wrap shine-animate-item">
                        <div class="consulting-content">

                            <div class="content-right">
                                <h2 class="title">شورای تخصصی هوش مصنوعی ایران را در شبکه های اجتماعی دنبال نمایید

                                </h2>
                                <p>
                                    شبکه‌های اجتماعی شورای تخصصی هوش مصنوعی ایران سریع‌ترین روش دسترسی به اخبار هوش مصنوعی، تکنولوژی و فناوری است. اگر می‌خواهید به‌روز باشید، شبکه‌های اجتماعی شورای تخصصی هوش مصنوعی ایران را دنبال کنید.

                                </p>
                                <div class="footer__social-two">
                                    <ul class="list-wrap">
                                        <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="fab fa-youtube"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="consulting-img shine-animate">
                            <img src="{{asset('assets\front\img\Social-Media.webp')}}" alt="">
                        </div>
                        <div class="consulting-shape">
                            <img src="{{asset('assets\front\img\images\consulting_shape.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="blog__post-area-four">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="section-title text-center mb-50 tg-heading-subheading animation-style3">
                        <span class="sub-title">جدیدترین مقالات</span>
                        <h2 class="title ">میتوانید اخبار بروز را در اینجا بخوانید</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="swiper-container posts-slider">
                    <div class="swiper-wrapper">
                        @foreach ($posts as $post)
                            <div class="swiper-slide">

                                <div class="blog-post-item blog__post-three shine-animate-item">
                                    <div class="blog-post-thumb blog__post-thumb-three">
                                        <a class="shine-animate" href="blog-details.html"><img
                                                src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}"></a>
                                    </div>
                                    <div class="blog-post-content blog__post-content-three">
                                        <a class="post-tag" href="blog.html">{{ @$post->categories->first()->name }}</a>
                                        <h2 class="title"><a href="blog-details.html">{{ $post->title }}</a>
                                        </h2>
                                        <div class="blog-post-meta mb-20">
                                            <ul class="list-wrap">
                                                <li><i
                                                        class="fas fa-calendar-alt"></i>{{ jDate($post->created_at)->format('%B %d، %Y') }}
                                                </li>
                                            </ul>
                                        </div>
                                        <a class="btn" href="blog-details.html">مطالعه بیشتر</a>
                                    </div>
                                </div>

                            </div> <!--swiper slider-->
                        @endforeach
                    </div>
                </div>
                @foreach ($posts as $post)
                    <div class="col-xl-4 col-lg-6 col-md-10">

                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <section class="consulting-area mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="consulting-inner-wrap shine-animate-item">
                        <div class="consulting-content">

                            <div class="content-right">
                                <h2 class="title">
                                    ایده یا طرح نوآورانه دارید؟
                                </h2>
                                <h2 class="title">برای عملی کردن آن، شورای تخصصی هوش مصنوعی همراه شماست !
                                </h2>
                                <p>

                                    با دنبال کردن ما در شبکه‌های اجتماعی، از آخرین ایده‌ها، نوآوری‌ها و تکنولوژی‌های روز دنیا مطلع شوید. ایده های خود را با ما در میان بگزارید تا با کمک هم آن هارا به واقعیت بدل نماییم.

                                </p>

                            </div>
                        </div>
                        <div class="consulting-img shine-animate Innovative-idea text-left">
                            <img src="{{asset('assets/front/img/banner/idea-icon.webp')}}" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="project__area-two exhibition">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="section-title mb-50 tg-heading-subheading animation-style3">
                        <span class="sub-title">
                            نمایشگاه
                        </span>
                        <h2 class="title ">
                            شورای تخصصی هوش مصنوعی در نمایشگاه
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row gutter-24">


                <div class="col-lg-3 col-md-4">
                    <div class="project__item-two">
                        <div class="project__thumb-two">
                            <img src="{{asset('assets\front\img\exhibition\kish-expo.webp')}}" alt="">
                        </div>
                        <div class="project__content-two">
                            <h2 class="title"><a href="project-details.html">  کیش اکسپو 2025  </a></h2>
                            <span>
                                تاریخ برگزاری:
                            </span>
                            <span>
                                29 دی لغایت 5 بهمن
                            </span>
                            <div class="link-arrow link-arrow-two">
                                <a href="project-details.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27956C17.7117 2.80339 17.4427 2.34761 17.0096 2.17811C16.9477 2.15384 16.8824 2.13551 16.8144 2.12375L6.96087 0.419136C6.4166 0.325033 5.89918 0.689841 5.80497 1.23409C5.71085 1.77828 6.0757 2.29576 6.61988 2.38991L14.0947 3.68293L1.3658 12.6573C0.914426 12.9756 0.806485 13.5994 1.12473 14.0508C1.44298 14.5022 2.06688 14.6101 2.51825 14.2919L15.2471 5.31752L13.954 12.7923C13.8599 13.3365 14.2248 13.854 14.7689 13.9481C15.3132 14.0422 15.8306 13.6774 15.9248 13.1332L17.6293 3.27956Z" fill="currentcolor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27956C17.7117 2.80339 17.4427 2.34761 17.0096 2.17811C16.9477 2.15384 16.8824 2.13551 16.8144 2.12375L6.96087 0.419136C6.4166 0.325033 5.89918 0.689841 5.80497 1.23409C5.71085 1.77828 6.0757 2.29576 6.61988 2.38991L14.0947 3.68293L1.3658 12.6573C0.914426 12.9756 0.806485 13.5994 1.12473 14.0508C1.44298 14.5022 2.06688 14.6101 2.51825 14.2919L15.2471 5.31752L13.954 12.7923C13.8599 13.3365 14.2248 13.854 14.7689 13.9481C15.3132 14.0422 15.8306 13.6774 15.9248 13.1332L17.6293 3.27956Z" fill="currentcolor"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="project__item-two">
                        <div class="project__thumb-two">
                            <img src="{{asset('assets\front\img\exhibition\iran-tarakonesh.webp')}}" alt="">
                        </div>
                        <div class="project__content-two">
                            <h2 class="title"><a href="project-details.html">  کیش اکسپو 2025  </a></h2>
                            <span>
                                تاریخ برگزاری:
                            </span>
                            <span>
                                29 دی لغایت 5 بهمن
                            </span>
                            <div class="link-arrow link-arrow-two">
                                <a href="project-details.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27956C17.7117 2.80339 17.4427 2.34761 17.0096 2.17811C16.9477 2.15384 16.8824 2.13551 16.8144 2.12375L6.96087 0.419136C6.4166 0.325033 5.89918 0.689841 5.80497 1.23409C5.71085 1.77828 6.0757 2.29576 6.61988 2.38991L14.0947 3.68293L1.3658 12.6573C0.914426 12.9756 0.806485 13.5994 1.12473 14.0508C1.44298 14.5022 2.06688 14.6101 2.51825 14.2919L15.2471 5.31752L13.954 12.7923C13.8599 13.3365 14.2248 13.854 14.7689 13.9481C15.3132 14.0422 15.8306 13.6774 15.9248 13.1332L17.6293 3.27956Z" fill="currentcolor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27956C17.7117 2.80339 17.4427 2.34761 17.0096 2.17811C16.9477 2.15384 16.8824 2.13551 16.8144 2.12375L6.96087 0.419136C6.4166 0.325033 5.89918 0.689841 5.80497 1.23409C5.71085 1.77828 6.0757 2.29576 6.61988 2.38991L14.0947 3.68293L1.3658 12.6573C0.914426 12.9756 0.806485 13.5994 1.12473 14.0508C1.44298 14.5022 2.06688 14.6101 2.51825 14.2919L15.2471 5.31752L13.954 12.7923C13.8599 13.3365 14.2248 13.854 14.7689 13.9481C15.3132 14.0422 15.8306 13.6774 15.9248 13.1332L17.6293 3.27956Z" fill="currentcolor"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-4">
                    <div class="project__item-two">
                        <div class="project__thumb-two">
                            <img src="{{asset('assets\front\img\exhibition\iran-clean.webp')}}" alt="">
                        </div>
                        <div class="project__content-two">
                            <h2 class="title"><a href="project-details.html">  کیش اکسپو 2025  </a></h2>
                            <span>
                                تاریخ برگزاری:
                            </span>
                            <span>
                                29 دی لغایت 5 بهمن
                            </span>
                            <div class="link-arrow link-arrow-two">
                                <a href="project-details.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27956C17.7117 2.80339 17.4427 2.34761 17.0096 2.17811C16.9477 2.15384 16.8824 2.13551 16.8144 2.12375L6.96087 0.419136C6.4166 0.325033 5.89918 0.689841 5.80497 1.23409C5.71085 1.77828 6.0757 2.29576 6.61988 2.38991L14.0947 3.68293L1.3658 12.6573C0.914426 12.9756 0.806485 13.5994 1.12473 14.0508C1.44298 14.5022 2.06688 14.6101 2.51825 14.2919L15.2471 5.31752L13.954 12.7923C13.8599 13.3365 14.2248 13.854 14.7689 13.9481C15.3132 14.0422 15.8306 13.6774 15.9248 13.1332L17.6293 3.27956Z" fill="currentcolor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27956C17.7117 2.80339 17.4427 2.34761 17.0096 2.17811C16.9477 2.15384 16.8824 2.13551 16.8144 2.12375L6.96087 0.419136C6.4166 0.325033 5.89918 0.689841 5.80497 1.23409C5.71085 1.77828 6.0757 2.29576 6.61988 2.38991L14.0947 3.68293L1.3658 12.6573C0.914426 12.9756 0.806485 13.5994 1.12473 14.0508C1.44298 14.5022 2.06688 14.6101 2.51825 14.2919L15.2471 5.31752L13.954 12.7923C13.8599 13.3365 14.2248 13.854 14.7689 13.9481C15.3132 14.0422 15.8306 13.6774 15.9248 13.1332L17.6293 3.27956Z" fill="currentcolor"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <div class="project__shape-wrap-two">
            <img src="assets\img\project\h2_project_shape.png" alt="" data-aos="fade-left" data-aos-delay="400" class="aos-init aos-animate">
        </div>
    </section>



@endsection


@push('scripts')

@endpush
