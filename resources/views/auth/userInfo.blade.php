@extends('front.layouts.master')

@section('content')
    <section class="register__area-one">
        <div class="container">
            <div class="text-center mb-55">
                <h1 class="text-48-bold">تکمیل حساب کاربری</h1>
            </div>
            <div class="box-form-login">
                <div class="head-login">
                    <form method="POST" action="{{ route('registerUserInfoStore') }}">
                        @csrf
                        <div class="form-login">
                            <div class="form-group">
                                <input type="text" class="form-control account  @error('fullName') is-invalid @enderror"
                                    name="fullName" value="{{ old('fullName') }}" required="" autofocus=""
                                    placeholder="نام‌ و‌ نام خانوادگی" value="{{ old('fullName') }}">
                                @error('fullName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" name="email"
                                    class="form-control email-address   @error('email') is-invalid @enderror" required=""
                                    placeholder="ایمیل" value="{{old('email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" name="nationalCode"
                                    class="form-control account  @error('nationalCode') is-invalid @enderror" required=""
                                    placeholder="کد ملی" value="{{old('nationalCode')}}">
                                @error('nationalCode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <select name="education" id="" class="form-control account @error('provieducationnce_id') is-invalid @enderror">
                                   <option value="">مدرک تحصیلی (انتخاب کنید)</option>
                                        <option value="diploma" {{old('education')=="diploma" ? 'selected' : ''}}>دیپلم</option>
                                        <option value="baccalaureate" {{old('education')=="baccalaureate" ? 'selected' : ''}}>کارشناسی</option>
                                        <option value="masterDegree" {{old('education')=="masterDegree" ? 'selected' : ''}}>کارشناسی ارشد</option>
                                        <option value="phd" {{old('education')=="phd" ? 'selected' : ''}}>دکترا</option>
                                        <option value="other" {{old('education')=="other" ? 'selected' : ''}}>سایر</option>
                                </select>
                                @error('education')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            </div>



                            <div class="form-group">
                                <input type="text" name="jobTitle"
                                    class="form-control account  @error('jobTitle') is-invalid @enderror"
                                    placeholder="عنوان شغلی" required="" value="{{old('jobTitle')}}">
                                @error('jobTitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <select name="province_id" id="" class="form-control account @error('province_id') is-invalid @enderror">
                                   <option value="">شهر (انتخاب کنید)</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{$province->id}}" {{old('province_id')==$province->id ? 'selected' : ''}}>{{$province->name}}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            </div>

                            <div class="form-group">
                                <input type="password" name="password"
                                    class="form-control  @error('password') is-invalid @enderror" placeholder="رمزعبور">
                                <span class="view-password"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation"
                                    class="form-control  @error('password_confirmation') is-invalid @enderror"
                                    placeholder="تکرار رمز عبور">
                                <span class="view-password"></span>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="box-forgot-pass">
                                <label>
                                    <input type="checkbox" class="cb-remember" value="1"> <span>من شرایط و ضوابط و خط
                                        مشی رازداری این وب سایت را خوانده و موافقم.</span>
                                </label>
                            </div> --}}
                            <div class="form-group">
                                <input type="submit" class="btn btn-login" value="ثبت نام">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
