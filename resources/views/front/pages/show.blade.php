@extends('front.layouts.master')
@push('styles')
@endpush
@section('content')
    <section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset('assets/front/img/bg/breadcrumb_bg.jpg') }}"
        style="background-image: url(&quot;{{ asset('assets/front/img/bg/breadcrumb_bg.jpg') }}&quot;);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">  {{$page->title}} </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">خانه</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> {{$page->title}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__shape">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape01.png') }}" alt="">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape02.png') }}" alt="" class="rightToLeft">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape03.png') }}" alt="">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape04.png') }}" alt="">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape05.png') }}" alt="" class="alltuchtopdown">

        </div>
    </section>


    <section class="blog__area">
        <div class="container">
            <div class="blog__inner-wrap">
                <div class="row">
                    <div class="col-70">
                        <div class="blog__details-wrap">

                            <div class="blog__details-content">
                                {{-- <h1 class="title">{{ $page->title }}</h1>
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">

                                        {{--  <li>
                                            <div class="blog-avatar">
                                                <div class="avatar-thumb">
                                                    <img src="{{ asset($post->featured_image) }}"
                                                    alt="{{ $post->title }}">
                                                </div>
                                                <div class="avatar-content">
                                                    <p>توسط <a href="blog-details.html">دومین اسمیت</a></p>
                                                </div>
                                            </div>
                                        </li>
                                        <li><i
                                                class="fas fa-calendar-alt"></i>{{ jDate($page->created_at)->format('%B %d، %Y') }}
                                        </li>--}}
                                        {{-- <li><i class="far fa-comment"></i><a href=""> دیدگاه</a></li>
                                    </ul>
                                </div> --}}

                                <p>
                                    {!! $page->content !!}
                                </p>
                            </div>
                            {{-- <div class="blog__avatar-wrap mb-60">
                                <div class="blog__avatar-img">
                                    <a href="#"><img src="assets\img\blog\blog_avatar01.png" alt="img"></a>
                                </div>
                                <div class="blog__avatar-info">
                                    <span class="designation">نویسنده</span>
                                    <h4 class="name"><a href="#">پارکر ویلی</a></h4>
                                    <p>این سیاهه‌ای از تاریخ‌نگاران است. نام‌ها بر شالودهٔ دوره‌های تاریخی دسته‌بندی شده که تاریخ‌نگار در آن دوره زندگی می‌کرد،،، ذ ه‌است.</p>
                                </div>
                            </div> --}}

                            {{--
                            <div class="comments-wrap">
                                <h3 class="comments-wrap-title">02 دیدگاه</h3>
                                <div class="latest-comments">
                                    <ul class="list-wrap">
                                        <li>
                                            <div class="comments-box">
                                                <div class="comments-avatar">
                                                    <img src="assets\img\blog\comment01.png" alt="img">
                                                </div>
                                                <div class="comments-text">
                                                    <div class="avatar-name">
                                                        <h6 class="name">جسیکا رز</h6>
                                                        <span class="date">27 مهر 1403</span>
                                                    </div>
                                                    <p>کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت.</p>
                                                    <a href="#" class="reply-btn">پاسخ</a>
                                                </div>
                                            </div>
                                            <ul class="children">
                                                <li>
                                                    <div class="comments-box">
                                                        <div class="comments-avatar">
                                                            <img src="assets\img\blog\comment02.png" alt="img">
                                                        </div>
                                                        <div class="comments-text">
                                                            <div class="avatar-name">
                                                                <h6 class="name">پارکر ویلی</h6>
                                                                <span class="date">28 مهر 1403</span>
                                                            </div>
                                                            <p>اعتماد شما را به شدت مشتری ما مجرای واقعی را انتخاب می کند زیرا می دانیم که ما بهترین منطقه در انتظار واقعاً هستیم.</p>
                                                            <a href="#" class="reply-btn">پاسخ</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="comment-respond">
                                <h3 class="comment-reply-title">ارسال دیدگاه</h3>
                                <form action="#" class="comment-form">
                                    <p class="comment-notes">آدرس ایمیل شما نمایش داده نخواهد شد *</p>
                                    <div class="form-grp">
                                        <textarea name="comment" placeholder="دیدگاه شما"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-grp">
                                                <input type="text" placeholder="نام">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-grp">
                                                <input type="email" placeholder="ایمیل">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-grp">
                                                <input type="url" placeholder="وبسایت">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-grp checkbox-grp">
                                        <input type="checkbox" id="checkbox">
                                        <label for="checkbox">نام ، ایمیل و وب سایت من را در این مرورگر ذخیره کنید برای دفعه بعد که نظر می دهم.</label>
                                    </div>
                                    <button type="submit" class="btn">ارسال پست</button>
                                </form>
                            </div> --}}
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
