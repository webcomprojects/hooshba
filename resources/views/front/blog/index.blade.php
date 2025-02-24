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
                        <h2 class="title">آرشیو مقالات</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">خانه</a></li>
                                <li class="breadcrumb-item active" aria-current="page">وبلاگ</li>
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
                        <div class="blog-post-wrap">
                            <div class="row gutter-24">
                                @foreach ($posts as $post)
                                    <div class="col-md-6">
                                        <div class="blog__post-two shine-animate-item">
                                            <div class="blog__post-thumb-two">
                                                <a class="shine-animate"
                                                    href="{{ route('front.blog.show', $post->slug) }}"><img
                                                        src="{{ asset($post->featured_image) }}"
                                                        alt="{{ $post->title }}"></a>
                                            </div>
                                            <div class="blog__post-content-two">
                                                <div class="blog-post-meta">
                                                    <ul class="list-wrap">
                                                        @if ($post->categories->first())
                                                            <li>
                                                                <a class="blog__post-tag-two"
                                                                    href="{{ url('/blog?c=' . $post->categories->first()->slug . '&k=' . request('k')) }}">
                                                                    {{ @$post->categories->first()->name }}</a>
                                                            </li>
                                                        @endif

                                                        <li><i
                                                                class="fas fa-calendar-alt"></i>{{ jDate($post->created_at)->format('%d %B، %Y') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h2 class="title">
                                                    <a href="{{ route('front.blog.show', $post->slug) }}">
                                                        {{ $post->title }}
                                                    </a>
                                                </h2>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="pagination-wrap mt-40">
                                {{ $posts->links('pagination::bootstrap-4') }}
                            </div>
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
