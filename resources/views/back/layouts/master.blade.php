<!DOCTYPE html>
<html lang="fa" dir="rtl" class="rtl">
    <head>
        <title>
            قالب مدیریتی

        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="قالب مدیریت ایرانی مدیران ">
        <meta name="keywords" content="قالب مدیریت, قالب داشبورد, قالب ادمین, قالب مدیران, قالب مدیریت راستچین , قالب ایرانی مدیریت, پوسته مدیریت, قالب ادمین داشبورد سایت, قالب مدیریتی, مدیران, قالب مدیریت مدیران, پنل مدیریت, پنل مدیریت مدرن, قالب ادمین متریال, قالب مدیریت بوت استرپ, قالب ادمین بوتسترپ, قالب ادمین سایت, پوسته مدیریتی ایرانی, قالب مدیرتی مدیران ایرانی, بهترین قالب مدیریت, قالب مدیریت ریسپانسیو, قالب مدیریت ارزان, قالب admin">
        <meta name="fontiran.com:license" content="NE29X">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets\front\img\favicon.ico')}}">

        @stack('befor-styles')

        <!-- BEGIN CSS -->


        <link href="{{asset('assets/back/plugins/bootstrap/bootstrap5/css/bootstrap.rtl.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/simple-line-icons/css/simple-line-icons.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/font-awesome/css/all.min.cs')}}s" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/switchery/dist/switchery.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/paper-ripple/dist/paper-ripple.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/iCheck/skins/square/_all.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/plugins/noty/css/flat.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('assets/back/css/colors.css')}}" rel="stylesheet">
               <link href="{{asset('assets/back/css/new-style.css')}}" rel="stylesheet">
        @stack('styles')

    </head>
    <body class="active-ripple theme-darkpurple fix-header sidebar-extra bg-1">
        <!-- BEGIN LOEADING -->
        <div id="loader">
            <div class="spinner"></div>
        </div><!-- /loader -->
        <!-- END LOEADING -->

        <!-- BEGIN HEADER -->
      @include('back.partials.header')
        <!-- /.navbar -->
        <!-- END HEADER -->

        <!-- BEGIN WRAPPER -->
        <div id="wrapper">

            <!-- BEGIN SIDEBAR -->
            @include('back.partials.sidebar')
            <!-- /#sidebar -->

            <!-- END SIDEBAR -->
            <!-- BEGIN PAGE CONTENT -->
            <div id="page-content">
                <div id="inner-content">
                    @yield('content')
                </div>
                <!-- /#inner-content -->
            </div><!-- /#page-content -->
            <!-- END PAGE CONTENT -->

        </div><!-- /#wrapper -->
        <!-- END WRAPPER -->

       @include('back.partials.footer')
        <!-- /.row -->

        <!-- BEGIN SETTING -->
      @include('back.partials.design-setting')
        <!-- /.settings -->
        <!-- END SETTING -->

        <!-- BEGIN JS -->
        <script>
            BASE_URL = '{{asset('')}}';
        </script>
        <script src="{{asset('assets/back/plugins/jquery/dist/jquery-3.6.1.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/bootstrap/bootstrap5/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/metisMenu/dist/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/paper-ripple/dist/PaperRipple.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/sweetalert2/dist/sweetalert2.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/screenfull/dist/screenfull.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/iCheck/icheck.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/switchery/dist/switchery.js')}}"></script>

        @stack('plugin-scripts')


        <script src="{{asset('assets/back/js/core.js')}}"></script>
        <script src="{{asset('assets/back/plugins/jquery-blockUI/jquery.blockUI.js')}}"></script>


        <script src="{{asset('assets/back/plugins/noty/js/noty/packaged/jquery.noty.packaged.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/select2/dist/js/select2.full.min.js')}}"></script>
        <script src="{{asset('assets/back/plugins/select2/dist/js/i18n/fa.js')}}"></script>
        <script src="{{asset('assets/back/js/pages/select2.js')}}"></script>
        <script src="{{asset('assets/back/js/script.js')}}"></script>
        <!-- END PAGE JAVASCRIPT -->

        @stack('scripts')

    </body>
</html>