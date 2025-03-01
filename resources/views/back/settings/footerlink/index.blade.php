@extends('back.layouts.master')

@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow d-flex justify-content-sm-between">
                <ul class="breadcrumb">
                    <li><a href="{{ route('back.dashboard') }}">داشبورد</a></li>
                    <li><a>لیست لینک ها </a></li>
                </ul>
                <div class="col-4 d-flex" style="padding-left: 30px">
                    <a href="{{ route('back.settings.footerlinks.groups.index') }}" class="btn btn-default btn-block"
                        style="margin-top: 6px">
                        <i class=" icon-check"></i>
                         لیست گروه ها


                    </a>

                    <a href="{{ route('back.settings.footerlinks.create') }}" class="btn btn-info btn-block"
                        style="margin-top: 6px;margin-right: 5px">
                        <i class=" icon-check"></i>
                        ایجاد لینک


                    </a>
                </div>
            </div>

        </div><!-- /.col-md-12 -->
        <!-- END BREADCRUMB -->

        <div class="col-lg-12">
            <div class="portlet box shadow">
                <div class="portlet-heading d-flex justify-content-sm-between">
                    <div class="portlet-title">
                        <h3 class="title">
                            <i class="icon-frane"></i>
                        لیست لینک های گروه اول
                        </h3>
                    </div><!-- /.portlet-title -->


                </div><!-- /.portlet-heading -->




                <div class="portlet-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>

                                    <th> عنوان</th>
                                    <th> لینک</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($footers1))
                                    @foreach ($footers1 as $item)
                                        <tr>

                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->link }}</td>


                                            <td>
                                                <a href="{{ route('back.settings.footerlinks.edit', $item) }}"
                                                    class="btn btn-info">ویرایش<div class="paper-ripple">
                                                        <div class="paper-ripple__background" style="opacity: 0.00256;">
                                                        </div>
                                                        <div class="paper-ripple__waves"></div>
                                                    </div></a>

                                                <button data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                    data-action="{{ route('back.settings.footerlinks.destroy', ['footerlink'=>$item]) }}"
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



                    </div><!-- /.table-responsive -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>

        <div class="col-lg-12">
            <div class="portlet box shadow">
                <div class="portlet-heading d-flex justify-content-sm-between">
                    <div class="portlet-title">
                        <h3 class="title">
                            <i class="icon-frane"></i>
                        لیست لینک های گروه اول
                        </h3>
                    </div><!-- /.portlet-title -->


                </div><!-- /.portlet-heading -->




                <div class="portlet-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>

                                    <th> عنوان</th>
                                    <th> لینک</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($footers2))
                                    @foreach ($footers2 as $item2)
                                        <tr>

                                            <td>{{ $item2->title }}</td>
                                            <td>{{ $item2->link }}</td>


                                            <td>
                                                <a href="{{ route('back.settings.footerlinks.edit', $item2) }}"
                                                    class="btn btn-info">ویرایش<div class="paper-ripple">
                                                        <div class="paper-ripple__background" style="opacity: 0.00256;">
                                                        </div>
                                                        <div class="paper-ripple__waves"></div>
                                                    </div></a>

                                                <button data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                    data-action="{{ route('back.settings.footerlinks.destroy', ['footerlink'=>$item2]) }}"
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



                    </div><!-- /.table-responsive -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>

        <div class="col-lg-12">
            <div class="portlet box shadow">
                <div class="portlet-heading d-flex justify-content-sm-between">
                    <div class="portlet-title">
                        <h3 class="title">
                            <i class="icon-frane"></i>
                        لیست لینک های گروه اول
                        </h3>
                    </div><!-- /.portlet-title -->


                </div><!-- /.portlet-heading -->




                <div class="portlet-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>

                                    <th> عنوان</th>
                                    <th> لینک</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($footers3))
                                    @foreach ($footers3 as $item3)
                                        <tr>

                                            <td>{{ $item3->title }}</td>
                                            <td>{{ $item3->link }}</td>


                                            <td>
                                                <a href="{{ route('back.settings.footerlinks.edit', $item3) }}"
                                                    class="btn btn-info">ویرایش<div class="paper-ripple">
                                                        <div class="paper-ripple__background" style="opacity: 0.00256;">
                                                        </div>
                                                        <div class="paper-ripple__waves"></div>
                                                    </div></a>

                                                <button data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                    data-action="{{ route('back.settings.footerlinks.destroy', ['footerlink'=>$item3]) }}"
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



                    </div><!-- /.table-responsive -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>

    </div>


    @include('back.partials.delete-modal', [
        'text_body' => 'با حذف لینک،دیگر قادر به بازیابی آن نخواهید بود',
    ])


@endsection
