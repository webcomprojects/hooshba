@extends('front.layouts.master')

@section('content')
<section class="login__area-one">
    <div class="container">
        <div class="text-center mb-55">
            <h1 class="text-48-bold">خوش آمدید !</h1>
        </div>
        <div class="box-form-login">
            <div class="head-login">
                <h3>ثبت نام</h3>
                <p>با وارد کردن شماره موبایل ثبت نام خود را شروع کنید</p>

                <form method="POST" action="{{route('sendVerificationCode')}}">
                    @csrf
                    <div class="form-login">
                    <div class="form-group">
                        <input type="text" class="form-control account @error('mobile') is-invalid @enderror" name="mobile" value="{{old('mobile')}}" required="" autofocus="" placeholder=" شماره موبایل">
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-login" value="ارسال کد تایید">
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</section>



@endsection
