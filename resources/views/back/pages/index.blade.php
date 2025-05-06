@extends('back.layouts.master')

@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{route('back.dashboard')}}">داشبورد</a></li>
                    <li><a>لیست صفحات</a></li>
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
                            لیست صفحات
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
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="check-all"></th>
                                    <th>عنوان</th>
                                    <th class="text-center">آدرس صفحه</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($pages))
                                    @foreach($pages as $item)
                                        <tr>
                                            <td><input class="item-checked" type="checkbox" value="{{$item->id}}"></td>
                                            <td><a href="{{route('front.pages.show',$item)}}" target="_blink">{{$item->title}}</a></td>
                                            <td style="direction: ltr;text-align:center"><a href="{{route('front.pages.show',$item)}}" target="_blink">/pages/{{$item->slug}}</a></td>
                                            <td class="text-center">
                                                @if($item->is_published)
                                                    <span class="label label-success">انتشار</span>
                                                @else
                                                    <span class="label label-default">پیش نویس</span>
                                                @endif
                                                <br>
                                                {{ jDate($item->created_at)->format('%d %B %Y') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('back.pages.edit',$item)}}" class="btn btn-info">ویرایش<div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
                                                <button data-bs-toggle="modal" data-bs-target="#delete-modal" data-action="{{route('back.pages.destroy',$item)}}" class="btn btn-danger delete-modal">حذف<div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></button>
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

                        <div class="pagination-wrap mt-40 text-center">
                            {{ $pages->links('pagination::bootstrap-4') }}
                        </div>

                    </div><!-- /.table-responsive -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>
    </div>

@include('back.partials.delete-modal',['text_body'=>'با حذف صفحه،دیگر قادر به بازیابی آن نخواهید بود' ])
@include('back.partials.multiple-delete-modal',['text_body'=>'با حذف صفحات،دیگر قادر به بازیابی آنها نخواهید بود.'])

@endsection