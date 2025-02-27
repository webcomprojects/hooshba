@extends('front.layouts.master')
@push('styles')
@endpush
@section('content')



    <section class="team__details-area">
        <div class="container">
            <div class="team__details-inner">
                <div class="row align-items-center">
                    <div class="text-center">
                        <h2 class="title">{{ option('introduction_title') }}</h2>
                        <p>{{ option('introduction_shortContent') }} </p>

                    </div>
                    <div class="col-36">
                        <div class="team__details-img">

                            @if (option('introduction_video'))
                                {!! option('introduction_video') !!}
                            @elseif (option('introduction_featured_image'))
                                <img src="{{ asset(option('introduction_featured_image')) }}"
                                    alt="{{ option('introduction_title') }}">
                            @endif
                        </div>
                    </div>
                    <div class="col-64">
                        <div class="team__details-content">
                            <p>{!! option('introduction_content') !!} </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
