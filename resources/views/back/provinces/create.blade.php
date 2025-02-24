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
                    <li><a href="{{ route('back.users.index') }}">لیست مناطق</a></li>
                    <li><a>ایجاد استان جدید</a></li>
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
                            ایجاد استان جدید
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

                            <form action="{{ route('back.provinces.store') }}" role="form" method="POST"
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
                                            <label> منطقه</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fas fa-map-location-dot"></i>
                                                </span>
                                                <select name="region_id" id=""
                                                    class="form-control account @error('region_id') is-invalid @enderror">
                                                    <option value="">منطقه (انتخاب کنید)</option>
                                                    @foreach ($regions as $region)
                                                        <option value="{{$region->id}}"
                                                            {{ old('region_id') == $region->id ? 'selected' : '' }}>{{$region->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('region_id')
                                                <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label>
                                                    <input name="is_published"
                                                        {{ old('is_published') == '1' ? 'checked' : '' }} value="1"
                                                        type="checkbox">
                                                    <label> انتشار؟</label>

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
