@extends('front.layouts.master')

@section('content')

<section class="login__area-one">
    <div class="container">
        <div class="text-center mb-55">
            <h1 class="text-48-bold">خوش آمدید !</h1>
        </div>
        <div class="box-form-login">
            <div class="head-login">
                <h3>ورود</h3>
                <p>با شماره موبایل و رمز ورود خود وارد شوید</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                <div class="form-login">
                    <div class="form-group">
                        <input type="text" class="form-control account @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autofocus placeholder=" شماره موبایل">
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور" required autocomplete="current-password">
                        <span class="view-password"></span>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="box-forgot-pass">
                        <label>
                            <input type="checkbox" class="cb-remember" name="remember" {{ old('remember') ? 'checked' : '' }}> یادآوری
                        </label>
                        {{-- <a href="forgot-password.html">رمز عبور خود را فراموش کردید؟</a> --}}
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-login" value="ورود">
                    </div>
                    <p>حساب کاربری ندارید! <a class="link-bold" href="/register">ثبت نام</a> کنید</p>
                </div>

                </form>
            </div>
        </div>
    </div>
</section>


@endsection
