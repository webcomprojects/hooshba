@extends('back.layouts.master')
@push('styles')
    <link href="{{ asset('assets/back/plugins/nestable/nestable.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{ route('back.dashboard') }}">داشبورد</a></li>
                    <li><a>لیست دسته بندی </a></li>
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
                            لیست دسته بندی
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


                            <div class="col-md-8 m-auto">

                                <form action="{{ route('back.categories.store') }}" role="form" method="POST"
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
                                        <div class="col-10">
                                            <div class="form-group curve">
                                                <input name="name" type="text" class="form-control" value="{{old('name')}}"
                                                    placeholder="افزودن دسته بندی جدید...">
                                            </div>
                                        </div>

                                        <input type="hidden" name="type" value="{{request()->segment(2)}}">

                                        <div class="col-2">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-block">
                                                    <i class="icon-check"></i>
                                                    افزودن
                                                    <div class="paper-ripple">
                                                        <div class="paper-ripple__background" style="opacity: 0;"></div>
                                                        <div class="paper-ripple__waves"></div>
                                                    </div>
                                                    <div class="paper-ripple">
                                                        <div class="paper-ripple__background" style="opacity: 0.00984;">
                                                        </div>
                                                        <div class="paper-ripple__waves"></div>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </form>

                                <div class="portlet box ">

                                    <div class="portlet-body">
        
                                        <div class="nestable dd" id="nestable-via-output">
                                            <ol class="dd-list">
                                                @foreach ($categories as $index =>  $category)
                                                    @include('back.categories.category-item', ['category' => $category,'index'=>$index])
                                                @endforeach
                                            </ol>

                                        </div><!-- /.nestable -->
                                    </div><!-- /.portlet-body -->
                                </div><!-- /.portlet -->
                            </div>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>

    </div>
@endsection
@push('plugin-scripts')
    <script src="{{ asset('assets/back/plugins/nestable/jquery.nestable.js') }}"></script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/back/js/pages/pages/categories/nestable.js') }}"></script>
@endpush
