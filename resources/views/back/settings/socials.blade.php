@extends('back.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/back/plugins/jquery-tagsinput/jquery.tagsinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\front\plugins\persian-date\persian-datepicker.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{ route('back.dashboard') }}">داشبورد</a></li>
                    <li><a> شبکه های اجتماعی</a></li>
                </ul>
            </div>

        </div><!-- /.col-md-12 -->
        <!-- END BREADCRUMB -->
        <div class="col-12">
            <div class="portlet box shadow">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h3 class="title">
                            <i class="icon-note"></i>
                            شبکه های اجتماعی
                        </h3>
                    </div><!-- /.portlet-title -->
                    <div class="buttons-box">
                        <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" title="کوچک کردن"
                            href="#">
                            <i class="icon-arrow-up"></i>
                        </a>
                    </div><!-- /.buttons-box -->
                </div><!-- /.portlet-heading -->

                <div class="portlet-body edit-form">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 m-auto m-b-30">

                            <form class="information" action="{{ route('back.settings.socials.store') }}" role="form"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <div class="row ">


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> تلگرام</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fab fa-telegram"></i>
                                                </span>
                                                <input type="text" name="social_telegram" class="form-control link"
                                                    value="{{old('social_telegram',option('social_telegram'))}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> اینستاگرام</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fab fa-instagram"></i>
                                                </span>
                                                <input type="text" name="social_instagram" class="form-control link"
                                                    value="{{old('social_instagram',option('social_instagram'))}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> واتساپ</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fab fa-whatsapp"></i>
                                                </span>
                                                <input type="text" name="social_whatsapp" class="form-control link"
                                                    value="{{old('social_whatsapp',option('social_whatsapp'))}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> فیسبوک</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fab fa-square-facebook"></i>
                                                </span>
                                                <input type="text" name="social_facebook" class="form-control link"
                                                    value="{{old('social_facebook',option('social_facebook'))}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> یوتیوب</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fab fa-youtube"></i>
                                                </span>
                                                <input type="text" name="social_youtube" class="form-control link"
                                                    value="{{old('social_youtube',option('social_youtube'))}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> آپارات</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fas fa-video"></i>
                                                </span>
                                                <input type="text" name="social_aparat" class="form-control link"
                                                    value="{{old('social_aparat',option('social_aparat'))}}">
                                            </div>
                                        </div>
                                    </div>


                                </div>





                        </div>

                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button class="btn btn-success btn-block">
                                        <i class="icon-check"></i>
                                        ذخیره
                                        <div class="paper-ripple">
                                            <div class="paper-ripple__background" style="opacity: 0;"></div>
                                            <div class="paper-ripple__waves"></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        </form>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.portlet-body -->
        </div><!-- /.portlet -->
    </div>

    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/back/js/pages/pages/about-us/goals.js') }}"></script>
@endpush
