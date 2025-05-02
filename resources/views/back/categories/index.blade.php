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
                                                <input name="name" type="text" class="form-control"
                                                    value="{{ old('name') }}" placeholder="افزودن دسته بندی جدید..."
                                                    autofocus>
                                            </div>
                                        </div>

                                        <input type="hidden" name="type" value="{{ request()->segment(2) }}">

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
                                                @foreach ($categories as $index => $category)
                                                    @include('back.categories.category-item', [
                                                        'category' => $category,
                                                        'index' => $index,
                                                    ])
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

    <div id="edit-category-modal" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title">آیا مطمعن هستید؟</h4>
                </div><!-- /.modal-header -->

                <div class="modal-footer" style="border-top: unset">
                    <form action="#" id="edit-category-form" class="row" method="post">
                        @csrf
                        @method('put')

                        <div class="col-md-12">
                            <div class="form-group curve">
                                <label> نام </label>
                                <input name="name" type="text" class="form-control"
                                    value="{{ old('name') }}">
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group curve">
                                <label> slug </label>
                                <input name="slug" type="text" class="form-control"
                                    value="{{ old('slug') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>استان</label>
                                <div class="input-group round">

                                    <select id="province" name="province_id" class="form-control ">
                                        <option  value="">انتخاب کنید</option>
                                        @foreach (\App\Models\Province::latest()->Published()->get() as $province)
                                            <option {{ old('province_id') == $province->id ? 'selected' : '' }}
                                                value="{{ $province->id }}" data-title="{{ $province->name }}">
                                                {{ $province->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>
                        </div>

                        <p class="text-right">
                            <button class="btn btn-success btn-block">
                                <i class="icon-check"></i>
                                ویرایش
                                <div class="paper-ripple">
                                    <div class="paper-ripple__background" style="opacity: 0;"></div>
                                    <div class="paper-ripple__waves"></div>
                                </div>
                                <div class="paper-ripple">
                                    <div class="paper-ripple__background" style="opacity: 0.00984;">
                                    </div>
                                    <div class="paper-ripple__waves"></div>
                                </div>
                                <div class="paper-ripple">
                                    <div class="paper-ripple__background" style="opacity: 0;"></div>
                                    <div class="paper-ripple__waves"></div>
                                </div>
                            </button>
                        </p>
                    </form>
                </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    @include('back.partials.delete-modal', [
        'text_body' => ' با حذف دسته بندی،دیگر قادر به بازیابی آن نخواهید بود، دسته بندی های فرزد هم حذف می شوند .',
    ])

@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/back/plugins/nestable/jquery.nestable.js') }}"></script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/back/js/pages/pages/categories/nestable.js') }}"></script>
@endpush
