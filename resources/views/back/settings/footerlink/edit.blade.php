@extends('back.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/back/plugins/jquery-tagsinput/jquery.tagsinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\front\plugins\persian-date\persian-datepicker.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow d-flex justify-content-sm-between">
                <ul class="breadcrumb">
                    <li><a href="{{ route('back.dashboard') }}">داشبورد</a></li>
                    <li><a> ایجاد لینک
                        </a></li>
                </ul>

                <div class="col-2" style="padding-left: 30px">
                    <a href="{{ route('back.settings.footerlinks.index') }}" class="btn btn-info btn-block"
                        style="margin-top: 6px">

                        برگشت
                        <i class=" fas fa-arrow-left-long"></i>
                        <div class="paper-ripple">
                            <div class="paper-ripple__background" style="opacity: 0;"></div>
                            <div class="paper-ripple__waves"></div>
                        </div>
                        <div class="paper-ripple">
                            <div class="paper-ripple__background" style="opacity: 0;"></div>
                            <div class="paper-ripple__waves"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div><!-- /.col-md-12 -->
        <!-- END BREADCRUMB -->
        <div class="col-12">
            <div class="portlet box shadow">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h3 class="title">
                            <i class="icon-note"></i>
                            ایجاد لینک

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

                            <form class="information" action="{{ route('back.settings.footerlinks.update',$footerlink) }}"
                                role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
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
                                            <label> عنوان </label>
                                            <div class="input-group round">

                                                <input type="text" name="title" class="form-control "
                                                    value="{{ old('title',$footerlink->title) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>لینک</label>
                                            <div class="input-group round">

                                                <input type="text" name="link" class="form-control link"
                                                    value="{{ old('link',$footerlink->link) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>گروه </label>
                                            <div class="input-group round">

                                                <select  name="link_group_id" class="form-control ">
                                                    <option value="0" {{old('link_group_id',$footerlink->link_group_id)==0 ? "selected" : ""}} > گروه اول</option>
                                                    <option value="1" {{old('link_group_id',$footerlink->link_group_id)==1 ? "selected" : ""}}> گروه دوم</option>
                                                    <option value="2" {{old('link_group_id',$footerlink->link_group_id)==2 ? "selected" : ""}}> گروه سوم</option>

                                                </select>
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
