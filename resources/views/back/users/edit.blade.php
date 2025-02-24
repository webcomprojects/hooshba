@extends('back.layouts.master')

@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{ route('back.dashboard') }}">داشبورد</a></li>
                    <li><a href="{{ route('back.users.index') }}">لیست کاربران</a></li>
                    <li><a>ورایش کاربر </a></li>
                </ul>
            </div>

        </div><!-- /.col-md-12 -->
        <!-- END BREADCRUMB -->
        <div class="col-12">
            <div class="portlet box shadow">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h3 class="title">
                            <i class="icon-note"></i>
                            ویرایش کاربر
                        </h3>
                    </div><!-- /.portlet-title -->
                    <div class="buttons-box">
                        <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" title="کوچک کردن"
                            href="#">
                            <i class="icon-arrow-up"></i>
                        </a>
                    </div><!-- /.buttons-box -->
                </div><!-- /.portlet-heading -->

                <div class="portlet-body edit-form">
                    <div class="row">
                        <div class="col-lg-6 col-md-10 m-auto m-b-30">

                            <form action="{{ route('back.users.update',$user) }}" role="form" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                {{-- <div class="form-group relative mt-3 mb-4">
                                    <input type="file" class="form-control">
                                    <div class="input-group round">
                                        <input type="text" name="avatar" class="form-control file-input" placeholder="{{__('container.Click to upload')}}">
                                        <span class="input-group-btn">
                                                        <button type="button" class="btn btn-success">
                                                            <i class="icon-picture"></i>
                                                            {{__('container.Upload Photo')}}
                                                        </button>
                                                    </span>
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                                <hr> --}}


                                <div class="form-group">
                                    <label>نام و نام خانوادگی</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </span>
                                        <input type="text" name="fullName" class="form-control"
                                            value="{{ old('fullName') ? old('fullName') : $user->fullName }}">
                                    </div>
                                    @error('fullName')
                                        <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>موبایل</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-phone"></i>
                                        </span>
                                        <input type="text" name="mobile" class="form-control ltr text-left"
                                            value="{{ old('mobile') ? old('mobile') : $user->mobile }}">
                                    </div>
                                    @error('mobile')
                                        <em id="mobile-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>




                                <div class="form-group">
                                    <label>ایمیل</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control ltr text-left"
                                            value="{{ old('email') ? old('email') : $user->email }}">
                                    </div>
                                    @error('email')
                                        <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label> کد ملی</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </span>
                                        <input type="text" name="nationalCode" class="form-control ltr text-left"
                                            value="{{ old('nationalCode') ? old('nationalCode') : $user->nationalCode }}">
                                    </div>
                                    @error('nationalCode')
                                        <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>استان</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-city"></i>
                                        </span>
                                        <select id="province" name="province_id" class="form-control ">
                                            @foreach ($provinces as $province)
                                                <option {{ old('province_id') == $province->id ? 'selected' : '' }}
                                                    value="{{ $province->id }}" data-title="{{ $province->name }}">
                                                    {{ $province->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @error('province_id')
                                        <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label> مدرک تحصیلی </label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </span>
                                        <select name="education" id="" class="form-control account @error('provieducationnce_id') is-invalid @enderror">
                                            <option value="">مدرک تحصیلی (انتخاب کنید)</option>
                                            @php
                                                $education=old('education') ? old('education') : $user->education
                                            @endphp
                                                 <option value="diploma" {{$education=="diploma" ? 'selected' : ''}}>دیپلم</option>
                                                 <option value="baccalaureate" {{$education=="baccalaureate" ? 'selected' : ''}}>کارشناسی</option>
                                                 <option value="masterDegree" {{$education=="masterDegree" ? 'selected' : ''}}>کارشناسی ارشد</option>
                                                 <option value="phd" {{$education=="phd" ? 'selected' : ''}}>دکترا</option>
                                                 <option value="other" {{$education=="other" ? 'selected' : ''}}>سایر</option>
                                         </select>
                                    </div>
                                    @error('education')
                                        <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label> عنوان شغل </label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </span>
                                        <input type="text" name="jobTitle" class="form-control"
                                            value="{{ old('jobTitle') ? old('jobTitle') : $user->jobTitle }}">
                                    </div>
                                    @error('jobTitle')
                                        <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>


                                <div class="portlet-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label>
                                                @php
                                                $mobile_verified_at=old('mobile_verified_at') ? old('mobile_verified_at') : $user->mobile_verified_at
                                            @endphp
                                       
                                                <input name="mobile_verified_at"
                                                    {{ $mobile_verified_at ? 'checked' : '' }} value="yes"
                                                    type="checkbox">
                                                <label>تایید شماره موبایل</label>

                                            </label>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>پسورد</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fas fa-key"></i>
                                                </span>
                                                <input type="password" name="password" class="form-control">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>تکرار پسورد</label>
                                            <div class="input-group round">
                                                <span class="input-group-addon">
                                                    <i class=" fas fa-key"></i>
                                                </span>
                                                <input type="password" name="password_confirmation" class="form-control">
                                            </div>

                                        </div>
                                    </div>
                                    @error('password')
                                        <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>نوع کاربر</label>
                                    <div class="input-group round">
                                        <span class="input-group-addon">
                                            <i class="icon-city"></i>
                                        </span>
                                        <select id="level" name="level" class="form-control ">
                                            @php
                                                $level_user=old('level') ? old('level') : $user->level;
                                            @endphp
                                            <option {{ $level_user == 'user' ? 'selected' : '' }} value="user">
                                                کاربر عادی</option>

                                                <option {{ $level_user == 'admin' ? 'selected' : '' }} value="admin">
                                                     مدیر</option>
                                        </select>
                                    </div>
                                    @error('level')
                                        <em id="firstname-error" class="error help-block">{{ $message }}</em>
                                    @enderror
                                </div>


                                <div id="userRoles" class="row">
                                    <div class="col-sm-12">
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label>مقام </label>
                                                <select name="roles[]" class="form-control select2 select-user-type" multiple>
                                                    @foreach ($roles as $item)
                                                        @php
                                                            // بررسی مقادیر قبلی برای فرم و در غیر این صورت استفاده از نقش‌های کاربر
                                                            $roles_user = old('roles', $user->roles->pluck('id')->toArray());
                                                        @endphp
                                                        <option value="{{ $item->id }}"
                                                            {{ in_array($item->id, $roles_user) ? 'selected' : '' }}>
                                                            {{ $item->title }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div><!-- /.form-group -->
                                        </div>

                                    </div><!-- /.col -->
                                </div><!-- /.row -->


                        </div><!-- /.form-body -->

                        <div class="form-group">
                            <button class="btn btn-success btn-block">
                                <i class="icon-check"></i>
                                ویرایش
                                <div class="paper-ripple">
                                    <div class="paper-ripple__background" style="opacity: 0;"></div>
                                    <div class="paper-ripple__waves"></div>
                                </div>
                            </button>
                        </div>
                        </form>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.portlet-body -->
        </div><!-- /.portlet -->
    </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/back/js/pages/pages/users/app.js') }}"></script>
@endpush
