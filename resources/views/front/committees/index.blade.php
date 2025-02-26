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
                        <h2 class="title"> کمیته ها</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">خانه</a></li>
                                <li class="breadcrumb-item active" aria-current="page">کمیته ها</li>
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


    <section class="team-area ">
        <div class="container">

            <div class="team-item-wrap">
                <div class="row justify-content-center">
                    @foreach ($committees as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="team-item">
                                <a href="{{route('front.committees.show',$item)}}" class="team-thumb">
                                    <img src="{{ $item->image ? asset($item->image) : asset('assets/back/images/empty.svg') }}" alt="{{ $item->name }}">

                                </a>
                                <div class="team-content">
                                    <h4 class="title"><a href="{{route('front.committees.show',$item)}}">{{ $item->name }}</a></h4>
                                    <div class="d-flex" style="height: 20px">
                                        @foreach (@$item->categories as $category)
                                            <span style="margin-right: 13px;"> {{ $category->name }}</span>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="pagination-wrap mt-40">
                {{ $committees->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
