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

                            <form action="{{ route('back.about-us.goals.store') }}" role="form" method="POST"
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
                                            <input name="goals_title" type="text" class="form-control"
                                                value="{{ option('goals_title') }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group curve">
                                            <label> خلاصه توضیحات </label>
                                            <textarea name="goals_shortContent" rows="4" class="form-control">{!! option('goals_shortContent') !!}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-5">

                                    <div class="d-flex justify-content-sm-between">
                                        <h2 class="m-0 ">هدف ها </h2>
                                        <div id="Add_goals_item" class="btn btn-no-arrow btn-success">افزودن هدف
                                            جدید
                                            <i class="fa fa-solid fa-plus"></i>
                                        </div>
                                    </div>

                                    <hr class="mt-2">

                                    <div id="goals_items">
                                        @php
                                            $corporate_experience_ai = old('moreGoals', json_decode(option('moreGoals'), true) ?? []);
                                        @endphp

                                        @if (count($corporate_experience_ai))
                                            @foreach ($corporate_experience_ai as $index => $exp)
                                                <div class="goals_item">

                                                    @if ($index != 0)
                                                    <hr>
                                                    <div class="btn btn-no-arrow btn-danger remove_btn_goals_item" style="float:left">حذف<i class="fa fa-solid fa-trash"></i></div>

                                                    @endif

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="text-16-semibold pb-2"> عنوان </label>
                                                                <input type="text" class="form-control"
                                                                    name="moreGoals[{{ $index }}][title]"
                                                                    value="{{ old("moreGoals.$index.title", $exp['title'] ?? '') }}"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="text-16-semibold pb-2"> توضیحات </label>
                                                                <textarea name="moreGoals[{{ $index }}][description]" class="form-control" rows="3">{!! old("moreGoals.$index.description", $exp['description'] ?? '') !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="goals_item">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-16-semibold pb-2"> عنوان </label>
                                                            <input type="text" class="form-control" name="moreGoals[0][title]" value="" placeholder="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-16-semibold pb-2"> توضیحات </label>
                                                            <textarea name="moreGoals[0][description]" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
