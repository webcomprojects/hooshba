@extends('back.layouts.master')

@section('content')


<div class="row">
    <!-- BEGIN BREADCRUMB -->
    <div class="col-md-12">
        <div class="breadcrumb-box shadow">
            <ul class="breadcrumb">
                <li><a href="dashboard.html">پیشخوان</a></li>
            </ul>
            <div class="breadcrumb-left">
                سه شنبه، 1402/07/18
                <i class="icon-calendar"></i>
            </div><!-- /.breadcrumb-left -->
        </div><!-- /.breadcrumb-box -->
    </div><!-- /.col-md-12 -->
    <!-- END BREADCRUMB -->

    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="stat-box use-cyan shadow">
                    <a href="#">
                        <div class="stat">
                            <div class="counter-down" data-value="2048"></div>
                            <div class="h3">کاربر</div>
                        </div><!-- /.stat -->
                        <div class="visual">
                            <i class="icon-people"></i>
                        </div><!-- /.visual -->
                    </a>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-3 -->
            <div class="col-lg-3 col-6">
                <div class="stat-box use-blue shadow">
                    <a href="#">
                        <div class="stat">
                            <div class="counter-down" data-value="1024"></div>
                            <div class="h3">محصول</div>
                        </div><!-- /.stat -->
                        <div class="visual">
                            <i class="icon-present"></i>
                        </div><!-- /.visual -->
                    </a>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-3 -->
            <div class="col-lg-3 col-6">
                <div class="stat-box use-green shadow">
                    <a href="#">
                        <div class="stat">
                            <div class="counter-down" data-value="512"></div>
                            <div class="h3">سفارش ثبت شده</div>
                        </div><!-- /.stat -->
                        <div class="visual">
                            <i class="icon-diamond"></i>
                        </div><!-- /.visual -->
                    </a>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-3 -->
            <div class="col-lg-3 col-6">
                <div class="stat-box use-purple shadow">
                    <a href="#">
                        <div class="stat">
                            <div class="counter-down" data-value="256"></div>
                            <div class="h3">پیام</div>
                        </div><!-- /.stat -->
                        <div class="visual">
                            <i class="icon-bubbles"></i>
                        </div><!-- /.visual -->
                    </a>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-3 -->
        </div><!-- /.row -->


        <div class="row">
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-box use-cyan shadow knob-container">
                    <div class="h3">فضای دیسک</div>
                    <input class="knob-animate" value="35" data-linecap="round" data-thickness=".1" data-width="75%" data-bgcolor="rgba(64, 189, 187, 0.15)" data-fgColor="#13a2a6" readonly>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-2 -->
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-box use-blue shadow knob-container">
                    <div class="h3">پهنای باند</div>
                    <input class="knob-animate" value="45" data-linecap="round" data-thickness=".1" data-width="75%" data-bgcolor="rgba(20, 185, 214, 0.15)" data-fgColor="#14B9D6" readonly>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-2 -->
        <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-box use-lime shadow knob-container">
                    <div class="h3">مصرف رم</div>
                    <input class="knob-animate" value="55" data-linecap="round" data-thickness=".1" data-width="75%" data-bgcolor="rgba(144, 202, 75, 0.15)" data-fgColor="#90ca4b" readonly>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-2 -->
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-box use-green shadow knob-container">
                    <div class="h3">مصرف پردازنده</div>
                    <input class="knob-animate" value="65" data-linecap="round" data-thickness=".1" data-width="75%" data-bgcolor="rgba(83, 169, 107, 0.15)" data-fgColor="#0abb87" readonly>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-2 -->
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-box use-rose shadow knob-container">
                    <div class="h3">مصرف شبکه</div>
                    <input class="knob-animate" value="75" data-linecap="round" data-thickness=".1" data-width="75%" data-bgcolor="rgba(233, 30, 99, 0.15)" data-fgColor="#e91e63" readonly>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-2 -->
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-box use-purple shadow knob-container">
                    <div class="h3">فایل ها</div>
                    <input class="knob-animate" value="9000" data-min="0" data-max="10000" data-linecap="round" data-thickness=".1" data-width="75%" data-bgcolor="rgba(69, 39, 160, 0.15)" data-fgColor="#4527a0" readonly>
                </div><!-- /.stat-box -->
            </div><!-- /.col-lg-2 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="portlet box shadow">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">
                                <i class="icon-pie-chart"></i>
                                میانگین بازدید
                            </h3>
                        </div><!-- /.portlet-title -->
                        <div class="buttons-box">
                            <a class="btn btn-sm btn-default btn-round btn-code" rel="tooltip" title="کدها" href="#">
                                <i class="icon-arrow-left"></i><span>/</span><i class="icon-arrow-right"></i>
                            </a>
                            <div class="code-modal hide">

                            </div>
                            <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" title="تمام صفحه" href="#">
                                <i class="icon-size-fullscreen"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-round btn-close" rel="tooltip" title="بستن" href="#">
                                <i class="icon-trash"></i>
                            </a>
                        </div><!-- /.buttons-box -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body">
                        <div id="donut" class="morris-chart"></div>
                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div><!-- /.col-md-6 -->
            <div class="col-md-6 col-xs-12">
                <div class="portlet box shadow">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">
                                <i class="icon-graph"></i>
                                تعداد کلیکها
                            </h3>
                        </div><!-- /.portlet-title -->
                        <div class="buttons-box">
                            <a class="btn btn-sm btn-default btn-round btn-code" rel="tooltip" title="کدها" href="#">
                                <i class="icon-arrow-left"></i><span>/</span><i class="icon-arrow-right"></i>
                            </a>
                            <div class="code-modal hide">

                            </div>
                            <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" title="تمام صفحه" href="#">
                                <i class="icon-size-fullscreen"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-round btn-close" rel="tooltip" title="بستن" href="#">
                                <i class="icon-trash"></i>
                            </a>
                        </div><!-- /.buttons-box -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body">
                        <div id="realtime" class="morris-chart"></div>
                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div><!-- /.col-md-6 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="portlet box shadow min-height-600">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">
                                <i class="icon-speech"></i>
                                دیدگاه ها
                            </h3>
                        </div><!-- /.portlet-title -->
                        <div class="buttons-box">
                            <a class="btn btn-sm btn-default btn-round btn-code" rel="tooltip" title="کدها" href="#">
                                <i class="icon-arrow-left"></i><span>/</span><i class="icon-arrow-right"></i>
                            </a>
                            <div class="code-modal hide">
                                <!--

                                -->
                            </div>
                            <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" title="تمام صفحه" href="#">
                                <i class="icon-size-fullscreen"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-round btn-close" rel="tooltip" title="بستن" href="#">
                                <i class="icon-trash"></i>
                            </a>
                        </div><!-- /.buttons-box -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab1">خوانده نشده</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab2">تائید شده</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab3">رد شده</a>
                            </li>
                            <li class="float-end">
                                <a class="float-end p-b-0" href="#">همه دیدگاه ها</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active fade show">
                                <div class="comments-box">
                                    <div class="comment-box">
                                        <div class="comment">
                                            <a href="#">
                                                <img src="{{asset('assets/back/images/user/32.png')}}" class="img-circle" alt="">
                                                <span class="user">
                                                    حمید آفرینش فر
                                                </span>
                                            </a>
                                            <span class="float-end text-muted">
                                                15:50 ، 3 تیر
                                                <i class="icon-clock"></i>
                                            </span>
                                            <p>
                                                قالب مدیران یک قالب کاملا ایرانی و بومی است که تمام پروسه طراحی و پیاده سازی آن توسط متخصصان داخلی انجام شده است.
                                            </p>
                                        </div><!-- /.comment -->
                                        <div class="actions">
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-primary" rel="tooltip" title="مشاهده">
                                                <i class="icon-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-info" rel="tooltip" title="پذیرش">
                                                <i class="icon-check"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-warning" rel="tooltip" title="عدم پذیرش">
                                                <i class="icon-close"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-danger" rel="tooltip" title="حذف">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div><!-- /.actions -->
                                    </div><!-- /.comment-box -->
                                    <div class="comment-box">
                                        <div class="comment">
                                            <a href="#">
                                                <img src="{{asset('assets/back/images/user/customer.png')}}" class="img-circle" alt="">
                                                <span class="user">
                                                    بهزاد
                                                </span>
                                            </a>
                                            <span class="float-end text-muted">
                                                15:55 ، 3 تیر
                                                <i class="icon-clock"></i>
                                            </span>
                                            <p>
                                                با سلام. آیا پلاگین های انتخاب تاریخ، شمسی شده اند؟
                                            </p>
                                        </div><!-- /.comment -->
                                        <div class="actions">
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-primary" rel="tooltip" title="مشاهده">
                                                <i class="icon-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-info" rel="tooltip" title="پذیرش">
                                                <i class="icon-check"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-warning" rel="tooltip" title="عدم پذیرش">
                                                <i class="icon-close"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-danger" rel="tooltip" title="حذف">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div><!-- /.actions -->
                                    </div><!-- /.comment-box -->
                                    <div class="comment-box">
                                        <div class="comment">
                                            <a href="#">
                                                <img src="{{asset('assets/back/images/user/32.png')}}" class="img-circle" alt="">
                                                <span class="user">
                                                    حمید آفرینش فر
                                                </span>
                                            </a>
                                            <span class="float-end text-muted">
                                                16:10 ، 3 تیر
                                                <i class="icon-clock"></i>
                                            </span>
                                            <p>
                                                سلام. بله حتما. علاوه بر آن پلاگین ویرایش متن، نمایش نقشه ایران، نمودار ها و... هم فارسی و راستچین هستند.
                                            </p>
                                        </div><!-- /.comment -->
                                        <div class="actions">
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-primary" rel="tooltip" title="مشاهده">
                                                <i class="icon-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-info" rel="tooltip" title="پذیرش">
                                                <i class="icon-check"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-warning" rel="tooltip" title="عدم پذیرش">
                                                <i class="icon-close"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-danger" rel="tooltip" title="حذف">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div><!-- /.actions -->
                                    </div><!-- /.comment-box -->
                                </div><!-- /.comments-box -->
                            </div><!-- /.tab-pane -->
                            <div id="tab2" class="tab-pane fade">
                                <div class="comments-box">
                                    <div class="comment-box">
                                        <div class="comment">
                                            <a href="#">
                                                <img src="{{asset('assets/back/images/user/32.png')}}" class="img-circle" alt="">
                                                <span class="user">
                                                    حمید آفرینش فر
                                                </span>
                                            </a>
                                            <span class="float-end text-muted">
                                                15:50 ، 3 تیر
                                                <i class="icon-clock"></i>
                                            </span>
                                            <p>
                                                قالب مدیران یک قالب کاملا ایرانی و بومی است که تمام پروسه طراحی و پیاده سازی آن توسط متخصصان داخلی انجام شده است.
                                            </p>
                                        </div><!-- /.comment -->
                                        <div class="actions">
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-primary" rel="tooltip" title="مشاهده">
                                                <i class="icon-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-warning" rel="tooltip" title="عدم پذیرش">
                                                <i class="icon-close"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-danger" rel="tooltip" title="حذف">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div><!-- /.actions -->
                                    </div><!-- /.comment-box -->
                                    <div class="comment-box">
                                        <div class="comment">
                                            <a href="#">
                                                <img src="{{asset('assets/back/images/user/customer.png')}}" class="img-circle" alt="">
                                                <span class="user">
                                                    بهزاد
                                                </span>
                                            </a>
                                            <span class="float-end text-muted">
                                                15:55 ، 3 تیر
                                                <i class="icon-clock"></i>
                                            </span>
                                            <p>
                                                با سلام. آیا پلاگین های انتخاب تاریخ، شمسی شده اند؟
                                            </p>
                                        </div><!-- /.comment -->
                                        <div class="actions">
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-primary" rel="tooltip" title="مشاهده">
                                                <i class="icon-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-warning" rel="tooltip" title="عدم پذیرش">
                                                <i class="icon-close"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-danger" rel="tooltip" title="حذف">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div><!-- /.actions -->
                                    </div><!-- /.comment-box -->
                                    <div class="comment-box">
                                        <div class="comment">
                                            <a href="#">
                                                <img src="{{asset('assets/back/images/user/32.png')}}" class="img-circle" alt="">
                                                <span class="user">
                                                    حمید آفرینش فر
                                                </span>
                                            </a>
                                            <span class="float-end text-muted">
                                                16:10 ، 3 تیر
                                                <i class="icon-clock"></i>
                                            </span>
                                            <p>
                                                سلام. بله حتما. علاوه بر آن پلاگین ویرایش متن، نمایش نقشه ایران، نمودار ها و... هم فارسی و راستچین هستند.
                                            </p>
                                        </div><!-- /.comment -->
                                        <div class="actions">
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-primary" rel="tooltip" title="مشاهده">
                                                <i class="icon-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-warning" rel="tooltip" title="عدم پذیرش">
                                                <i class="icon-close"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-danger" rel="tooltip" title="حذف">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div><!-- /.actions -->
                                    </div><!-- /.comment-box -->
                                </div><!-- /.comments-box -->
                            </div><!-- /.tab-pane -->
                            <div id="tab3" class="tab-pane fade">
                                <div class="comments-box">
                                    <div class="comment-box">
                                        <div class="comment">
                                            <a href="#">
                                                <span class="user">
                                                    کاربر ناشناس
                                                </span>
                                            </a>
                                            <span class="float-end text-muted">
                                                15:30 ، 3 تیر
                                                <i class="icon-clock"></i>
                                            </span>
                                            <p>
                                                سلام. لطفا به سایت من هم سر بزنید...
                                            </p>
                                        </div><!-- /.comment -->
                                        <div class="actions">
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-primary" rel="tooltip" title="مشاهده">
                                                <i class="icon-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-info" rel="tooltip" title="پذیرش">
                                                <i class="icon-check"></i>
                                            </a>
                                            <a href="#" class="btn btn-round btn-icon btn-sm btn-danger" rel="tooltip" title="حذف">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div><!-- /.actions -->
                                    </div><!-- /.comment-box -->
                                </div><!-- /.comments-box -->
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->

                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div><!-- /.col-md-6 -->
            <div class="col-md-6 col-xs-12">
                <div class="portlet box shadow min-height-600">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">
                                <i class="icon-location-pin"></i>
                                فروش نمایندگی ها
                            </h3>
                        </div><!-- /.portlet-title -->
                        <div class="buttons-box">
                            <a class="btn btn-sm btn-default btn-round btn-code" rel="tooltip" title="کدها" href="#">
                                <i class="icon-arrow-left"></i><span>/</span><i class="icon-arrow-right"></i>
                            </a>
                            <div class="code-modal hide">

                            </div>
                            <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" title="تمام صفحه" href="#">
                                <i class="icon-size-fullscreen"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-round btn-close" rel="tooltip" title="بستن" href="#">
                                <i class="icon-trash"></i>
                            </a>
                        </div><!-- /.buttons-box -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body">
                        <div id="map" class="ammap-box"></div>
                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div><!-- /.col-md-6 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="portlet box shadow">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">
                                <i class="icon-picture"></i>
                                دو نمونه افکت و تصویر
                            </h3>
                        </div><!-- /.portlet-title -->
                        <div class="buttons-box toggle toggle-mobile">
                            <a class="btn btn-sm btn-default btn-round btn-toggle" href="#">
                                <i class="icon-options"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-round btn-code"  rel="tooltip" title="کدها" href="#">
                                <i class="icon-arrow-left"></i><span>/</span><i class="icon-arrow-right"></i>
                            </a>
                            <div class="code-modal hide">

                            </div>
                            <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" title="کوچک کردن" href="#">
                                <i class="icon-arrow-up"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-round btn-close" rel="tooltip" title="بستن" href="#">
                                <i class="icon-trash"></i>
                            </a>
                        </div><!-- /.buttons-box -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body min-height-650">
                        <div class="row">
                            <div class="col-sm-6 col-md-12 m-t-10">
                                <div class="effect bottom-to-top-effect">
                                    <div class="info-hover">
                                        <h2>
                                            <span class="title">حافظیه</span>
                                        </h2>
                                        <a href="#" class="url">
                                            مشاهده و ویرایش
                                        </a>
                                    </div><!-- /.info-hover -->
                                    <img src="{{asset('assets/back/images/other/hafez-tomb.jpg')}}" class="img-center img-responsive" alt="">
                                </div><!-- /.effect -->
                            </div><!-- /.col -->
                            <div class="col-sm-6 col-md-12">
                                <div class="effect effect-border">
                                    <a href="#">
                                        <div class="desc">
                                            <img src="{{asset('assets/back/images/other/birds.jpg')}}" class="img-responsive img-center">
                                            <div class="desc-in">
                                                <h3>غذای پرندگان</h3>
                                                <div class="btn btn-primary btn-more">مشاهده و ویرایش</div>
                                            </div>
                                        </div><!-- /.desc -->
                                    </a>
                                </div><!-- /.effect -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div><!-- /.col-xl-4 -->
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="portlet box shadow">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">
                                <i class="icon-frame"></i>
                                نمونه فرم
                            </h3>
                        </div><!-- /.portlet-title -->
                        <div class="buttons-box">
                            <a class="btn btn-sm btn-default btn-round btn-code"  rel="tooltip" title="کدها" href="#">
                                <i class="icon-arrow-left"></i><span>/</span><i class="icon-arrow-right"></i>
                            </a>
                            <div class="code-modal hide">

                            </div>
                            <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" title="کوچک کردن" href="#">
                                <i class="icon-arrow-up"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-round btn-close" rel="tooltip" title="بستن" href="#">
                                <i class="icon-trash"></i>
                            </a>
                        </div><!-- /.buttons-box -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body min-height-650">
                        <form role="form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label>نام</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="نام">
                                    </div><!-- /.input-group -->
                                </div><!-- /.form-group -->
                                <div class="form-group">
                                    <label>رمز عبور</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-key"></i>
                                        </span>
                                        <input type="password" class="form-control ltr text-left">
                                    </div><!-- /.input-group -->
                                </div><!-- /.form-group -->
                                <div class="form-group">
                                    <p>
                                        <label>
                                            <input name="radio" type="radio" >
                                            آقا
                                        </label>
                                        <label>
                                            <input name="radio" type="radio" >
                                            بانو
                                        </label>
                                    </p>
                                </div><!-- /.form-group -->
                                <div class="form-group">
                                    <label>ایمیل به صورت چپ چین</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control ltr text-left" placeholder="email@site.com">
                                    </div><!-- /.input-group -->
                                </div><!-- /.form-group -->
                                <div class="form-group">
                                    <label>تاریخ تولد(شمسی)</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control" id="kama-datepicker" placeholder="تاریخ تولد">
                                    </div><!-- /.input-group -->
                                </div><!-- /.form-group -->
                                <div class="form-group">
                                    <label>نشانی</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-location-pin"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" placeholder="نشانی"></textarea>
                                    </div><!-- /.input-group -->
                                </div><!-- /.form-group -->
                            </div><!-- /.form-body -->

                            <div class="form-actions m-t-20">
                                <button type="button" class="btn btn-success btn-block">
                                    <i class="icon-check"></i>
                                    تائید و ذخیره
                                </button>
                            </div><!-- /.form-actions -->
                        </form>
                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div><!-- /.col-xl-4 -->
            <div class="col-xl-4 col-12">
                <div class="portlet box shadow">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">
                                <i class="icon-bubbles"></i>
                                گفتگو با کاربر
                            </h3>
                        </div><!-- /.portlet-title -->
                        <div class="buttons-box">
                            <a class="btn btn-sm btn-default btn-round btn-code" rel="tooltip" title="کدها" href="#">
                                <i class="icon-arrow-left"></i><span>/</span><i class="icon-arrow-right"></i>
                            </a>
                            <div class="code-modal hide">

                            </div>
                            <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" title="کوچک کردن" href="#">
                                <i class="icon-arrow-up"></i>
                            </a>
                            <a class="btn btn-sm btn-default btn-round btn-close" rel="tooltip" title="بستن" href="#">
                                <i class="icon-trash"></i>
                            </a>
                        </div><!-- /.buttons-box -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body min-height-650">
                        <ul class="chat">
                            <li class="self">
                                <div class="avatar">
                                    <img src="{{asset('assets/back/images/user/customer.png')}}" alt="">
                                </div>
                                <div class="message">
                                    <div class="content">
                                        با سلام. آیا صفحات بطور کامل فارسی، راستچین و بهینه می باشد؟
                                    </div>
                                    <span class="sender-name">
                                        بهزاد
                                    </span>
                                    <time>، 10:20 </time>
                                </div>
                            </li>
                            <li class="other">
                                <div class="avatar">
                                    <img src="{{asset('assets/back/images/user/64.png')}}" alt="">
                                </div>
                                <div class="message">
                                    <div class="content">
                                        سلام. بله، صفحات را می توانید در دموی محصول ببینید.
                                    </div>
                                    <span class="sender-name">
                                        پشتیبان قالب
                                    </span>
                                    <time>، 10:21</time>
                                </div>
                            </li>
                            <li class="self">
                                <div class="avatar">
                                    <img src="{{asset('assets/back/images/user/customer.png')}}" alt="">
                                </div>
                                <div class="message">
                                    <div class="content">
                                        پلاگین ها چطور؟
                                    </div>
                                    <span class="sender-name">
                                        بهزاد
                                    </span>
                                    <time>، 10:23</time>
                                </div>
                            </li>
                            <li class="other">
                                <div class="avatar">
                                    <img src="{{asset('assets/back/images/user/64.png')}}" alt="">
                                </div>
                                <div class="message">
                                    <div class="content">
                                        بله، کلیه پلاگین ها هم با زبان فارسی و راستچین هستند و تقویم و نقشه ها هم بومی شده هستند.
                                    </div>
                                    <span class="sender-name">
                                        پشتیبان قالب
                                    </span>
                                    <time>، 10:24</time>
                                </div>
                            </li>
                        </ul>
                        <div class="input-group round m-t-20">
                            <input type="text" class="form-control" placeholder="پیام جدید">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button">ارسال</button>
                            </span>
                        </div><!-- /.input-group -->
                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div><!-- /.col-xl-4 -->
        </div><!-- /.row -->
    </div>

 </div>

 @endsection