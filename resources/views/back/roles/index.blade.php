@extends('back.layouts.master')

@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{route('back.dashboard')}}">داشبورد</a></li>
                    <li><a>لیست مقام ها</a></li>
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
                            لیست مقام ها
                        </h3>
                    </div><!-- /.portlet-title -->
                    <div class="buttons-box">
                        <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" href="#" aria-label="تمام صفحه" data-bs-original-title="تمام صفحه">
                            <i class="icon-size-fullscreen"></i>
                            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
                        <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" href="#" aria-label="کوچک کردن" data-bs-original-title="کوچک کردن">
                            <i class="icon-arrow-up"></i>
                            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
                    </div><!-- /.buttons-box -->
                </div><!-- /.portlet-heading -->


                <div class="mb-2 datatable-actions collapse " style="">
                    <div class="d-flex align-items-center">
                        <div class="font-weight-bold text-danger mr-3"><span id="datatable-selected-rows">0</span> مورد انتخاب شده: </div>

                        <button class="btn btn-danger multiple-delete-modal" data-action="{{route('back.roles.multipleDestroy')}}" type="button" data-bs-toggle="modal" data-bs-target="#multiple-delete-modal">حذف همه</button>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width:20px"><input type="checkbox" id="btn-check-all-toggle"></th>
                                <th> عنوان</th>
                                <th>توضیحات</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($items))
                                @foreach($items as $item)
                                    <tr>
                                        <td><input class="item-checked"  type="checkbox" value="{{$item->id}}"></td>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>
                                            <a href="{{route('back.roles.edit',['role'=>$item])}}" class="btn btn-info">ویرایش<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00256;"></div><div class="paper-ripple__waves"></div></div></a>
                                            <button data-bs-toggle="modal" data-bs-target="#delete-modal" data-action="{{route('back.roles.destroy',['role'=>$item])}}" class="btn btn-danger delete-modal">حذف<div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="9">چیزی برای نمایش وجود ندارد</td>
                                </tr>
                            @endif


                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>

    </div>


@include('back.partials.delete-modal',['text_body'=>'با حذف مقام،دیگر قادر به بازیابی آنها نخواهید بود.'])
@include('back.partials.multiple-delete-modal',['text_body'=>'با حذف مقام ها،دیگر قادر به بازیابی آنها نخواهید بود.'])

@endsection

