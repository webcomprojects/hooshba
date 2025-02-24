@extends('back.layouts.master')

@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{route('back.dashboard')}}">داشبورد</a></li>
                    <li><a>لیست مقام ها</a></li>
                    <li><a>ایجاد مقام جدید</a></li>
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
                            ایجاد مقام جدید
                        </h3>
                    </div><!-- /.portlet-title -->
                    <div class="buttons-box">
                        <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" title="کوچک کردن" href="#">
                            <i class="icon-arrow-up"></i>
                        </a>
                    </div><!-- /.buttons-box -->
                </div><!-- /.portlet-heading -->

                <div class="portlet-body edit-form">
                    <div class="row">
                            <form action="{{route('back.roles.store')}}" role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">

                                    <div class="col-lg-6 col-md-10 m-auto m-b-30">

                                        <div class="form-group">
                                            <label>عنوان</label>
                                            <div class="input-group round">
                                                <input type="text" name="title" class="form-control" value="{{old('title')}}">
                                            </div>
                                            @error('title')
                                            <em id="firstname-error" class="error help-block">{{$message}}</em>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                                    <label for="description">توضیحات</label>
                                                    <textarea class="form-control" rows="4" id="description" name="description" ></textarea>
                                                </div>
                                    </div>

                                    <div class="col-md-12">
                                        <h3 class="title">
                                            <i class=" fas fa-unlock-keyhole"></i>
                                           دسترسی ها
                                        </h3>
                                        <hr>
                                        <div id="accordion1">
                                            @foreach($items as $item)

                                                <div class="card m-b-20">
                                                    <div class="card-header cursor-pointer collapsed" data-bs-toggle="collapse" data-bs-target="#collapse{{$item->id}}" aria-expanded="false" aria-controls="collapse1">
                                                        <h5 class="m-b-0">
                                                            <div class="input-group">
                                                                <label class="w-100" >
                                                                    <input data-id="{{$item->id}}" value="{{$item->id}}" name="permissions[]" type="checkbox" class="btn-check-all-toggle parent-permission ">
                                                                    {{$item->title}}
                                                                </label>
                                                            </div>
                                                        </h5>
                                                    </div><!-- /.card-header -->
                                                    @if(count($item->permissionItems))
                                                        <div id="collapse{{$item->id}}" class="collapse" data-bs-parent="#accordion{{$item->id}}" style="">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                   @foreach($item->permissionItems as $perItem)
                                                                        <div class="col-md-3">
                                                                            <div class="input-group">
                                                                                <label class="" >
                                                                                    <input name="permissions[]" class="" data-permission_id="{{$item->id}}" value="{{$perItem->id}}" type="checkbox" >
                                                                                    {{$perItem->title}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                   @endforeach
                                                                </div>
                                                            </div>
                                                        </div><!-- /.collapse -->

                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div><!-- /.form-body -->

                                <div class="form-group">
                                    <button class="btn btn-success btn-block">
                                        <i class="icon-check"></i>
                                        ایجاد
                                        <div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0;"></div><div class="paper-ripple__waves"></div></div></button>
                                </div>
                            </form>
                        </div><!-- /.col -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>

    </div>
@endsection
@push('scripts')
<script src="{{asset('assets/back/js/pages/pages/role/app.js')}}"></script>

@endpush
