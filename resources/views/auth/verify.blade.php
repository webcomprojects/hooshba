@extends('front.layouts.master')

@section('content')

<section class="login__area-one">
    <div class="container">

        <div class="box-form-login">
            <div class="head-login">
                <h3> تایید شماره موبایل</h3>
                <p>کد ارسال شده به شماره
                    {{Cache::get(session('verifyCodeSended'));}}
                    را وارد کنید
                </p>

                <form method="POST" action="{{route('verifyCodeCheck')}}">
                            @csrf
                    <div class="form-login">
                    <div class="form-group">
                        <input type="text" minlength="6" maxlength="6" class="form-control account  @error('code') is-invalid @enderror" name="code" value="{{old('code')}}" required="" autofocus="" placeholder=" کد تایید">
                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-login" value="برسی کد ">
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</section>


@endsection
