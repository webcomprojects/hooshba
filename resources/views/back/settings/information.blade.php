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
                    <li><a> تنظیمات عمومی</a></li>
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
                            تنظیمات عمومی
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

                            <form class="information" action="{{ route('back.settings.information.store') }}" role="form"
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

                                    <div class="col-md-4">


                                        <div class="form-group relative">
                                            <input type="file" name="info_icon" class="form-control">
                                            <label> آیکون </label>

                                            <br>
                                            <img class="image-thumb-index d-block mb-2"
                                                @if (!option('info_icon')) style="width: 50px;" @endif
                                                src="{{ option('info_icon') ? asset(option('info_icon')) : asset('assets/back/images/empty.svg') }}"
                                                alt="image">

                                            <div class="input-group round">
                                                <input type="text" class="form-control file-input"
                                                    placeholder="برای آپلود کلیک کنید">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success">
                                                        <i class="icon-picture"></i>
                                                        آپلود عکس
                                                        <div class="paper-ripple">
                                                            <div class="paper-ripple__background"></div>
                                                            <div class="paper-ripple__waves"></div>
                                                        </div>
                                                    </button>
                                                </span>
                                            </div><!-- /.input-group -->
                                            <div class="help-block"></div>
                                        </div>

                                    </div>


                                    <div class="col-md-4">


                                        <div class="form-group relative">
                                            <input type="file" name="info_logo" class="form-control">
                                            <label> لوگو </label>
                                            <br>
                                            <img class="image-thumb-index d-block mb-2"
                                                @if (!option('info_logo')) style="width: 50px;" @endif
                                                src="{{ option('info_logo') ? asset(option('info_logo')) : asset('assets/back/images/empty.svg') }}"
                                                alt="image">

                                            <div class="input-group round">
                                                <input type="text" class="form-control file-input"
                                                    placeholder="برای آپلود کلیک کنید">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success">
                                                        <i class="icon-picture"></i>
                                                        آپلود عکس
                                                        <div class="paper-ripple">
                                                            <div class="paper-ripple__background"></div>
                                                            <div class="paper-ripple__waves"></div>
                                                        </div>
                                                    </button>
                                                </span>
                                            </div><!-- /.input-group -->
                                            <div class="help-block"></div>
                                        </div>

                                    </div>

                                    <div class="col-md-4">


                                        <div class="form-group relative">
                                            <input type="file" name="info_nav_logo" class="form-control">
                                            <label> لوگو هدر</label>
                                            <br>
                                            <img class="image-thumb-index d-block mb-2"
                                                @if (!option('info_nav_logo')) style="width: 50px;" @endif
                                                src="{{ option('info_nav_logo') ? asset(option('info_nav_logo')) : asset('assets/back/images/empty.svg') }}"
                                                alt="image">

                                            <div class="input-group round">
                                                <input type="text" class="form-control file-input"
                                                    placeholder="برای آپلود کلیک کنید">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success">
                                                        <i class="icon-picture"></i>
                                                        آپلود عکس
                                                        <div class="paper-ripple">
                                                            <div class="paper-ripple__background"></div>
                                                            <div class="paper-ripple__waves"></div>
                                                        </div>
                                                    </button>
                                                </span>
                                            </div><!-- /.input-group -->
                                            <div class="help-block"></div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> عنوان وبسایت </label>
                                            <input name="info_site_title" type="text" class="form-control"
                                                value="{{ old('info_site_title') ? old('info_site_title') : option('info_site_title') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> تلفن </label>
                                            <input name="info_tel" type="text" class="form-control"
                                                value="{{ old('info_tel') ? old('info_tel') : option('info_tel') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> ایمیل </label>
                                            <input name="info_email" type="email" class="form-control"
                                                value="{{ old('info_email') ? old('info_email') : option('info_email') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group curve">
                                            <label> آدرس </label>
                                            <input name="info_address" type="text" class="form-control"
                                                value="{{ old('info_address') ? old('info_address') : option('info_address') }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group curve">
                                            <label>متن فوتر</label>
                                            <textarea name="info_footer_text" rows="4" class="form-control">{!! old('info_footer_text') ? old('info_footer_text') : option('info_footer_text') !!}</textarea>
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
