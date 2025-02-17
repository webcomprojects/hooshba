@extends('front.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets\front\plugins\persian-date\persian-datepicker.min.css') }}">
@endpush
@section('content')
    <section class="register__area-one">
        <div class="container">
            <div class="text-center mb-55">
                <h1 class="text-48-bold"> عضویت در انجمن هوش مصنوعی ایران
                </h1>

            </div>
            <div class="box-form-login box-form-membership">
                <p>
                    فیلد های "*" اجباری هستند
                </p>
                <div class="head-login">
                    <form method="POST" action="{{ route('front.membership.store') }}" enctype="multipart/form-data">
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

                        <div class="form-login">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-16-semibold pb-2">نوع عضویت<span
                                                class="gfield_required">*</span></label>
                                        <select name="user_type" id=""
                                            class="form-control  @error('user_type') is-invalid @enderror" required>
                                            <option value="individual"
                                                {{ old('user_type') == 'individual' ? 'selected' : '' }}>حقیقی</option>
                                            <option value="corporate"
                                                {{ old('user_type') == 'corporate' ? 'selected' : '' }}>
                                                حقوقی </option>
                                        </select>
                                        @error('user_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div id="individualForm">
                                @include('front.membership.individual-form')
                            </div>

                            <div id="corporateForm" class="d-none">
                                @include('front.membership.corporate-form')
                            </div>



                            <div class="form-group">
                                <input type="submit" class="btn btn-login" value="ارسال ">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets\front\plugins\persian-date\persian-date.min.js') }}"></script>
    <script src="{{ asset('assets\front\plugins\persian-date\persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets\front\js\pages\membership\register.js') }}"></script>
@endpush
