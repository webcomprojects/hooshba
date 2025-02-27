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
                        <h2 class="title">
                            اعضای شورای تخصصی هوش مصنوعی ایران </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">خانه</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    اعضای شورای تخصصی هوش مصنوعی ایران</li>
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
                    @foreach ($CouncilMembers as $CouncilMember)
                    <div class="col-md-3 council-members-item">
                        <svg width="283" height="262" viewBox="0 0 283 262" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.8" filter="url(#filter0_b_3_340)"><path d="M0 24C0 10.7452 10.7452 0 24 0H259C272.255 0 283 10.7452 283 24V238C283 251.255 272.255 262 259 262H165.5C152.245 262 141.5 251.255 141.5 238V212C141.5 198.745 130.755 188 117.5 188H24C10.7452 188 0 177.255 0 164V24Z" fill="white"></path><path d="M1.5 24C1.5 11.5736 11.5736 1.5 24 1.5H259C271.426 1.5 281.5 11.5736 281.5 24V238C281.5 250.426 271.426 260.5 259 260.5H165.5C153.074 260.5 143 250.426 143 238V212C143 197.917 131.583 186.5 117.5 186.5H24C11.5736 186.5 1.5 176.426 1.5 164V24Z" stroke="#011341" stroke-width="3"></path></g><defs><filter id="filter0_b_3_340" x="-40" y="-40" width="363" height="342" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feGaussianBlur in="BackgroundImageFix" stdDeviation="20"></feGaussianBlur><feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_3_340"></feComposite><feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_3_340" result="shape"></feBlend></filter></defs></svg>

                        <div class="council-members-logo">
                            <img src="{{ asset('assets\front\img\logo\nav-logo.webp') }}"
                            alt="Logo">
                        </div>
                        <div class="council-members-avatar">
                            <img src="{{ $CouncilMember->featured_image ? asset($CouncilMember->featured_image) : asset('assets/back/images/avatar-empty.png') }}" alt="">
                        </div>
                        <div class="council-members-item-title">
                            <span>
                                {{$CouncilMember->name}}
                            </span>

                            <span>
                                {{$CouncilMember->job_position}}
                            </span>
                        </div>

                        <a class="btn btn-no-arrow council-members-item-btn" href="#">اطلاعات بیشتر </a>
                    </div>
                    @endforeach

                </div>
            </div>

            <div class="pagination-wrap mt-40">
                {{ $CouncilMembers->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </section>
@endsection
@push('scripts')
@endpush
