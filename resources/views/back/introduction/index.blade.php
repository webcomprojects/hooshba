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
                    <li><a> معرفی شوراء </a></li>
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
                            معرفی شوراء
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

                            <form action="{{ route('back.about-us.introduction.store') }}" role="form" method="POST"
                                enctype="multipart/form-data">
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


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> عنوان </label>
                                            <input name="introduction_title" type="text" class="form-control"
                                                value="{{ option('introduction_title') }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group curve">
                                            <label> خلاصه توضیحات </label>
                                           <textarea name="introduction_shortContent" rows="4" class="form-control">{!! option('introduction_shortContent') !!}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">محتوا</label>
                                            <textarea id="content" class="form-control" rows="3" name="introduction_content">{!! option('introduction_content') !!}</textarea>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>لینک ویدئو(کد امبد)</label>
                                            <textarea class="form-control" name="introduction_video" rows="3" style="height: 96px;">{!!  option('introduction_video')  !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">


                                        <div class="form-group relative">
                                            <input type="file" name="featured_image" class="form-control">
                                            <label> تصویر شاخص </label>
                                            <br>
                                            <img class="image-thumb-index d-block mb-2" @if(!option('introduction_featured_image')) style="width: 50px;" @endif src="{{ option('introduction_featured_image') ? asset(option('introduction_featured_image')) : asset('assets/back/images/empty.svg') }}" alt="image">

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


                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label>
                                                    <input name="introduction_is_published"
                                                        {{ option('introduction_is_published') == '1' ? 'checked' : '' }} value="1"
                                                        type="checkbox">
                                                    <label>  انتشار ؟</label>

                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <button class="btn btn-success btn-block">
                                                <i class="icon-check"></i>
                                                ویرایش
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
@push('plugin-scripts')
<script src="{{ asset('assets/back/plugins/jquery-tagsinput/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/back/plugins/ckeditor/ckeditor.js') }}"></script>
@endpush

@push('scripts')
    <script src="{{ asset('assets\front\plugins\persian-date\persian-date.min.js') }}"></script>
    <script src="{{ asset('assets\front\plugins\persian-date\persian-datepicker.min.js') }}"></script>

    <script src="{{ asset('assets/back/js/pages/pages/posts/app.js') }}"></script>
@endpush
