@extends('back.layouts.master')


@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{route('back.dashboard')}}">داشبورد</a></li>
                    <li><a href="{{route('back.pages.index')}}">لیست صفحات</a></li>
                    <li><a>ایجاد صفحه جدید</a></li>
                </ul>
            </div>
        </div><!-- /.col-md-12 -->
        <!-- END BREADCRUMB -->

        <div class="col-lg-12">
            <div class="portlet box shadow">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h3 class="title">
                            <i class="icon-frane"></i>
                            ایجاد صفحه جدید
                        </h3>
                    </div><!-- /.portlet-title -->
                    <div class="buttons-box">
                        <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" href="#" aria-label="{{ __('container.fullscreen') }}" data-bs-original-title="{{ __('container.fullscreen') }}">
                            <i class="icon-size-fullscreen"></i>
                            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
                        <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" href="#" aria-label="{{ __('container.Miniaturize') }}" data-bs-original-title="{{ __('container.Miniaturize') }}">
                            <i class="icon-arrow-up"></i>
                            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
                    </div><!-- /.buttons-box -->
                </div><!-- /.portlet-heading -->

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 m-auto m-b-30">
                            <form action="{{ route('back.pages.store') }}" role="form" method="POST">
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
                                            <input id="title" name="title" type="text" class="form-control" value="{{ old('title') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> آدرس </label>
                                            <input id="address" name="slug" type="text" class="form-control" value="{{ old('slug') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">محتوا</label>
                                            <textarea id="content" class="form-control" rows="3" name="content">{{ old('content') }}</textarea>
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label>
                                                    <input name="is_published"
                                                        {{ old('is_published') == '1' ? 'checked' : '' }} value="1"
                                                        type="checkbox">
                                                    <label>  انتشار نوشته؟</label>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">ذخیره</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>
    </div>
@endsection
@push('plugin-scripts')
<script src="{{ asset('assets/back/plugins/ckeditor/ckeditor.js') }}"></script>
@endpush


@push('scripts')
<script src="{{ asset('assets/back/js/slug-generator.js') }}"></script>
<script>
    CKEDITOR.replace('content');
</script>
@endpush