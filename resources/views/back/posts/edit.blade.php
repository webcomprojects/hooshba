@extends('back.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/back/plugins/tagsInput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/back/plugins/jquery-tagsinput/jquery.tagsinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/plugins/persian-date/persian-datepicker.min.css') }}">
@endpush

@push('styles')
    <style>
        .bootstrap-tagsinput {
            display: block;
        }

        .bootstrap-tagsinput .tag {
            padding: 0px 6px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{ route('back.dashboard') }}">داشبورد</a></li>
                    <li><a href="{{ route('back.users.index') }}">لیست مقالات</a></li>
                    <li><a>ایجاد مقاله جدید</a></li>
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
                            ایجاد مقاله جدید
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

                            <form action="{{ route('back.posts.update', $post) }}" role="form" method="POST"
                                enctype="multipart/form-data">
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


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> عنوان </label>
                                            <input id="title" name="title" type="text" class="form-control"
                                                value="{{ old('title') ? old('title') : $post->title }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>دسته بندی </label>
                                            <select name="categories[]" class="form-control select2" multiple>
                                                @foreach ($categories as $item)
                                                    @php
                                                        // بررسی مقادیر قبلی برای فرم و در غیر این صورت استفاده از نقش‌های کاربر
                                                        $cat = old(
                                                            'categories',
                                                            $post->categories->pluck('id')->toArray(),
                                                        );
                                                    @endphp
                                                    <option {{ in_array($item->id, $cat) ? 'selected' : '' }}
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>استان</label>
                                            <div class="input-group round">

                                                <select id="province" name="province_id" class="form-control select2">
                                                    @php
                                                        $provinceSelected = old('province_id')
                                                            ? old('province_id')
                                                            : $post->province_id;
                                                    @endphp
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($provinces as $province)
                                                        <option {{ $provinceSelected == $province->id ? 'selected' : '' }}
                                                            value="{{ $province->id }}"
                                                            data-title="{{ $province->name }}">
                                                            {{ $province->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                        </div>
                                    </div> --}}


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">محتوا</label>
                                            <textarea id="content" class="form-control" rows="3" name="content">{!! old('content') ? old('content') : $post->content !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> عنوان سئو </label>
                                            <input name="meta_title" type="text" class="form-control"
                                                value="{{ old('meta_title') ? old('meta_title') : $post->meta_title }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group curve">
                                            <label> url </label>
                                            <input id="slug" name="slug" type="text" class="form-control"
                                                value="{{ old('slug') ? old('slug') : $post->slug }}">
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-12 col-md-12">
                                            <div class="form-group curve">
                                                <label>کلمات کلیدی</label>

                                                @php
                                                    $tags = null;
                                                    if (old('tags')) {
                                                        $tags = implode(',', old('tags'));
                                                    } else {
                                                        $tags = $post->getTags;
                                                    }
                                                @endphp

                                                <input id="tags_tag" name="tags" type="text" class="form-control"
                                                    value="{{ $tags }}" data-role="tagsinput">

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">



                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>توضیحات سئو</label>
                                                <textarea class="form-control" name="meta_description" rows="3" style="height: 96px;">{!! old('meta_description') ? old('meta_description') : $post->meta_description !!}</textarea>
                                            </div>
                                        </div>




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>لینک ویدئو(کد امبد)</label>
                                                <textarea class="form-control" name="video" rows="3" style="height: 96px;">{!! old('video') ? old('video') : $post->video !!}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">


                                            <div class="form-group relative">
                                                <input type="file" name="featured_image" class="form-control">
                                                <label> تصویر شاخص </label>
                                                <br>
                                                <img class="image-thumb-index d-block mb-2"
                                                    @if (!$post->featured_image) style="width: 50px;" @endif
                                                    src="{{ $post->featured_image ? asset($post->featured_image) : asset('assets/back/images/empty.svg') }}"
                                                    alt="image">


                                                <div class="input-group round">
                                                    <input type="text" class="form-control file-input"
                                                        placeholder="برای جایگزین تصویر، کلیک کنید">
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
                                                        @php
                                                            $is_published = old('is_published')
                                                                ? old('is_published')
                                                                : $post->is_published;
                                                        @endphp
                                                        <input name="is_published"
                                                            {{ $is_published == '1' ? 'checked' : '' }} value="1"
                                                            type="checkbox">
                                                        <label> انتشار نوشته؟</label>

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
    <script src="{{ asset('assets/back/plugins/tagsInput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets/back/plugins/ckeditor/ckeditor.js') }}"></script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/front/plugins/persian-date/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/front/plugins/persian-date/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/back/js/pages/pages/posts/app.js') }}"></script>
@endpush
