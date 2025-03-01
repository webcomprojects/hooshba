@extends('back.layouts.master')

@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{ route('back.dashboard') }}">داشبورد</a></li>
                    <li><a>لیست کاربران</a></li>
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
                            لیست کاربران
                        </h3>
                    </div><!-- /.portlet-title -->
                    <div class="buttons-box">
                        <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" href="#"
                            aria-label="{{ __('container.fullscreen') }}"
                            data-bs-original-title="{{ __('container.fullscreen') }}">
                            <i class="icon-size-fullscreen"></i>
                            <div class="paper-ripple">
                                <div class="paper-ripple__background"></div>
                                <div class="paper-ripple__waves"></div>
                            </div>
                        </a>
                        <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" href="#"
                            aria-label="{{ __('container.Miniaturize') }}"
                            data-bs-original-title="{{ __('container.Miniaturize') }}">
                            <i class="icon-arrow-up"></i>
                            <div class="paper-ripple">
                                <div class="paper-ripple__background"></div>
                                <div class="paper-ripple__waves"></div>
                            </div>
                        </a>
                    </div><!-- /.buttons-box -->
                </div><!-- /.portlet-heading -->

                <div class="mb-2 datatable-actions collapse " style="">
                    <div class="d-flex align-items-center">
                        <div class="font-weight-bold text-danger mr-3"><span id="datatable-selected-rows">0</span> مورد
                            انتخاب شده: </div>

                        <button class="btn btn-danger multiple-delete-modal"
                            data-action="{{ route('back.users.multipleDestroy') }}" type="button" data-bs-toggle="modal"
                            data-bs-target="#multiple-delete-modal">خذف همه</button>
                    </div>
                </div>


                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width:20px"><input type="checkbox" id="btn-check-all-toggle"></th>
                                    {{-- <th class="text-center"> آواتار</th> --}}
                                    <th>نام و نام خانوادگی</th>
                                    <th> نوع کاربر</th>
                                    <th> موبایل</th>
                                    <th>ایمیل</th>
                                    <th>زمان ایجاد</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($users))
                                    @foreach ($users as $item)
                                        @if (Auth::user()->level != 'creator' && $item->level == 'creator')
                                            @continue
                                        @endif
                                        <tr>
                                            <td><input class="item-checked" type="checkbox" value="{{ $item->id }}">
                                            </td>
                                            {{-- <td  class="text-center">
                                            <img class="image-thumb-index" @if (!$item->avatar) style="width: 50px;" @endif src="{{ $item->avatar ? asset($item->avatar) : asset('back/assets/images/avatar-empty.png') }}" alt="image">
                                        </td> --}}
                                            <td>{{ $item->fullName }}</td>
                                            <td>
                                                @if ($item->level == 'user')
                                                    <span class="label label-default">کاربر</span>
                                                @elseif($item->level == 'admin')
                                                    <span class="label label-default">مدیر</span>
                                                @endif

                                            </td>

                                            <td>{{ $item->mobile }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ jDate($item->created_at)->format('%d %B، %Y') }}</td>
                                            <td>


                                                <a href="{{ route('back.users.edit', ['user' => $item]) }}"
                                                    class="btn btn-info">ویرایش<div class="paper-ripple">
                                                        <div class="paper-ripple__background" style="opacity: 0.00256;">
                                                        </div>
                                                        <div class="paper-ripple__waves"></div>
                                                    </div></a>

                                                <button data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                    data-action="{{ route('back.users.destroy', ['user' => $item]) }}"
                                                    class="btn btn-danger delete-modal">حذف<div class="paper-ripple">
                                                        <div class="paper-ripple__background"></div>
                                                        <div class="paper-ripple__waves"></div>
                                                    </div></button>

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
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>

                    </div><!-- /.table-responsive -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>

    </div>


    @include('back.partials.delete-modal', [
        'text_body' => 'با حذف کاربر،دیگر قادر به بازیابی آن نخواهید بود',
    ])
    @include('back.partials.multiple-delete-modal', [
        'text_body' => 'با حذف کاربران،دیگر قادر به بازیابی آنها نخواهید بود.',
    ])

@endsection
