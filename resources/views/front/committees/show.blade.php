@extends('front.layouts.master')
@push('styles')
@endpush
@section('content')
    <section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset('assets/front/img/bg/breadcrumb_bg.jpg') }}"
        style="background-image: url(&quot;{{ asset('assets/front/img/bg/breadcrumb_bg.jpg') }}&quot;);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
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
        <div class="breadcrumb__shape">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape01.png') }}" alt="">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape02.png') }}" alt="" class="rightToLeft">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape03.png') }}" alt="">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape04.png') }}" alt="">
            <img src="{{ asset('assets\front\img\images\breadcrumb_shape05.png') }}" alt="" class="alltuchtopdown">

        </div>
    </section>


    <section class="team__details-area">
        <div class="container">
            <div class="team__details-inner">
                <div class="row align-items-center">
                    <div class="col-36">
                        <div class="team__details-img">
                            <img src="{{ $committee->image ? asset($committee->image) : asset('assets/back/images/empty.svg') }}" alt="{{ $committee->name }}">
                        </div>
                    </div>
                    <div class="col-64">
                        <div class="team__details-content">
                            <h2 class="title">{{$committee->name}} </h2>
                            <div class="d-flex position" style="height: 20px">
                                @foreach (@$committee->categories as $category)
                                    <span class="" style="margin-right: 13px;"> {{ $category->name }}</span>
                                @endforeach
                            </div>

                            <p>{!! $committee->content !!}</p>

                            <div class="team__details-info">
                                <ul class="list-wrap">
                                    <li>
                                        <i class="flaticon-phone-call"></i>
                                        <a href="tel:0123456789">{{$committee->phone}}</a>
                                    </li>
                                    <li>
                                        <i class="flaticon-mail"></i>
                                        <a href="mailto:{{$committee->email}}">{{$committee->email}}</a>
                                    </li>
                                    <li>
                                        <i class="flaticon-pin"></i>
                                       {{@$committee->province()->first()->name}}
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
@endpush
