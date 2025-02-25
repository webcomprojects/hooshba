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
                    <li><a href="{{ route('back.users.index') }}">لیست اعضاء</a></li>
                    <li><a>ایجاد اعضاء جدید</a></li>
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
                            ایجاد اعضاء جدید
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

                            <form action="{{ route('back.members.store') }}" role="form" method="POST"
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
                                            <label> نام </label>
                                            <input name="name" type="text" class="form-control"
                                                value="{{ old('name') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>نوع عضو  </label>
                                            <select name="type" class="form-control " required>
                                                <option  value="">انتخاب کنید</option>
                                                <option {{old('type') == "council" ? "selected" : ""}}  value="council">شورا</option>
                                                <option {{old('type') == "presidency" ? "selected" : ""}}  value="presidency">ریاست جمهوری</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> موقعیت شغلی </label>
                                            <input name="job_position" type="text" class="form-control"
                                                value="{{ old('job_position') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>استان</label>
                                            <div class="input-group round">

                                                <select id="province" name="province_id" class="form-control select2">
                                                    <option  value="">انتخاب کنید</option>
                                                    @foreach ($provinces as $province)
                                                        <option {{ old('province_id') == $province->id ? 'selected' : '' }}
                                                            value="{{ $province->id }}" data-title="{{ $province->name }}">
                                                            {{ $province->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> ایمیل</label>
                                            <input name="email" type="email" class="form-control"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> موبایل</label>
                                            <input name="mobile" type="text" class="form-control"
                                                value="{{ old('mobile') }}">
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                        <div class="form-group curve">
                                            <label> لینک ها</label>
                                            <input name="links" type="text" class="form-control"
                                                value="{{ old('links') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first-name-vertical"> سوابق تحصیلی</label>
                                            <textarea class="form-control" rows="6" name="educational_background">{!! old('educational_background') !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first-name-vertical"> سوابق شغلی</label>
                                            <textarea class="form-control" rows="6" name="executive_background">{!! old('executive_background') !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">توضیحات دیگر</label>
                                            <textarea id="content" class="form-control" rows="3" name="description">{!! old('description') !!}</textarea>
                                        </div>
                                    </div>



                                    <div class="col-md-6">


                                        <div class="form-group relative">
                                            <input type="file" name="image" class="form-control">
                                            <label> تصویر شاخص </label>
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
                                                    <input name="is_published"
                                                        {{ old('is_published') == '1' ? 'checked' : '' }} value="1"
                                                        type="checkbox">
                                                    <label>  انتشار؟</label>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label> تاریخ انتشار</label>
                                            <input id="publish_date_picker" name="slug" type="text" class="form-control publish_date_picker" value="{{old('slug')}}">
                                        @error('birth_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div> --}}

                                </div>




                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <button class="btn btn-success btn-block">
                                                <i class="icon-check"></i>
                                                ایجاد
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
