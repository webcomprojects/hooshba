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
                        <h2 class="title">جزئیات وبلاگ </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">خانه</a></li>
                                <li class="breadcrumb-item active" aria-current="page">جزئیات وبلاگ</li>
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
                            <div class="blog__details-thumb">
                                @if ($post->video)
                                {!! $post->video !!}
                                @else
                                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                                @endif

                            </div>
                            <div class="blog__details-content">
                                <h1 class="title">{{ $post->title }}</h1>
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">
                                        <li><a class="blog__post-tag-two"
                                                href="{{ url('/blog?c=' . $post->categories->first()->slug . '&k=' . request('k')) }}">{{ @$post->categories->first()->name }}</a>
                                        </li>
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
                                        </li> --}}
                                        <li><i
                                                class="fas fa-calendar-alt"></i>{{ jDate($post->created_at)->format('%B %d، %Y') }}
                                        </li>
                                        <li><i class="far fa-comment"></i><a href=""> دیدگاه</a></li>
                                    </ul>
                                </div>

                                <p>
                                    {!! $post->content !!}
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

                    <div class="col-30">
                        <aside class="blog__sidebar">
                            <div class="sidebar__widget sidebar__widget-two">
                                <div class="sidebar__search">
                                    <form action="{{ url('/blog') }}" method="GET">
                                        <input type="text" name="k" value="{{ request('k') }}"
                                            placeholder="جستجو . . .">
                                        <input type="hidden" name="c" value="{{ request('c') }}">
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z"
                                                    stroke="currentcolor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>
                            <div class="sidebar__widget">
                                <h4 class="sidebar__widget-title">دسته ها</h4>
                                <div class="sidebar__cat-list">
                                    <ul class="list-wrap">
                                        <li>
                                            <a href="/blog">
                                                <i class="flaticon-arrow-button"></i>نمایش همه
                                            </a>
                                        </li>
                                        @foreach ($categories as $category)
                                            @php $count = DB::table('category_post')->where('category_id', $category->id)->count(); @endphp
                                            @if ($count)
                                                <li>
                                                    <a
                                                        href="{{ url('/blog?c=' . $category->slug . '&k=' . request('k')) }}">
                                                        <i class="flaticon-arrow-button"></i>{{ $category->name }}
                                                        ({{ $count }})
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                            <div class="sidebar__widget">
                                <h4 class="sidebar__widget-title">آخرین مطالب</h4>
                                <div class="sidebar__post-list">
                                    @foreach ($last_posts as $last)
                                        <div class="sidebar__post-item">
                                            <div class="sidebar__post-thumb">
                                                <a href="{{ route('front.blog.show', $last->slug) }}"><img
                                                        src="{{ asset($last->featured_image) }}"
                                                        alt="{{ $last->title }}"></a>
                                            </div>
                                            <div class="sidebar__post-content">
                                                <h5 class="title"><a
                                                        href="{{ route('front.blog.show', $last->slug) }}">{{ $last->title }}</a>
                                                </h5>
                                                <span class="date"><i class="flaticon-time"></i>
                                                    {{ jDate($last->created_at)->format('%B %d، %Y') }} </span>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                            @if (count($tags))
                                <div class="sidebar__widget">
                                    <h4 class="sidebar__widget-title">برچسب‌ها</h4>
                                    <div class="sidebar__tag-list">
                                        <ul class="list-wrap">
                                            @foreach ($tags as $tag)
                                                <li>
                                                    <a href="{{ url('/blog?tag=' . $tag->slug) }}">{{ $tag->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
