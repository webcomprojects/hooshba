@extends('front.layouts.master')
@push('styles')
@endpush
@section('content')
    <section class="pb-0 breadcrumb__area breadcrumb__bg" data-background="{{ asset('assets/front/img/bg/breadcrumb_bg.jpg') }}"
        style="background-image: url(&quot;{{ asset('assets/front/img/bg/breadcrumb_bg.jpg') }}&quot;);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="title"> چارت سازمانی </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">خانه</a></li>
                            <li class="breadcrumb-item active" aria-current="page">چارت سازمانی </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

    </section>


    <div id="tree">

    </div>
@endsection
@push('scripts')
<script src="https://balkan.app/js/orgchart.js"></script>
<script>
    var items = @json($items);


    var nodes = [];

    // پردازش داده‌ها و تبدیل آنها به فرمت مورد نیاز چارت
    items.forEach(function(item) {
        nodes.push({
            id: item.id,
            pid: item.parent_id ? item.parent_id : null, // مقدار null برای ریشه
            name: item.name,
            description: item.description // افزودن توضیحات
        });
    });

    var chart = new OrgChart(document.getElementById("tree"), {
        nodeBinding: {
            field_0: "name",       // نمایش نام
            field_1: "description" // نمایش توضیحات
        },
        nodes: nodes,
        enableSearch: false,
        min: false
    });
</script>
@endpush
