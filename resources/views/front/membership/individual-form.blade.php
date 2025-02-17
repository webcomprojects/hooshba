 {{-- مشخصات فردی --}}
 <div class="row mt-5">
     <h4 class="title "> مشخصات فردی</h4>
     <hr>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">نام <span class="gfield_required">*</span></label>
             <input type="text" class="form-control   @error('first_name') is-invalid @enderror" name="first_name"
                 value="{{ old('first_name') }}" required="" autofocus="" placeholder="نام‌  ">
             @error('first_name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">نام خانوادگی <span class="gfield_required">*</span></label>
             <input type="text" name="last_name" class="form-control    @error('last_name') is-invalid @enderror"
                 required="" placeholder="نام خانوادگی" value="{{ old('last_name') }}">
             @error('last_name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">کدملی <span class="gfield_required">*</span></label>
             <input type="text" class="form-control   @error('national_id') is-invalid @enderror" name="national_id"
                 value="{{ old('national_id') }}" required="" autofocus="" placeholder="کدملی  ">
             @error('national_id')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">نام معرف </label>
             <input type="text" name="referral_name"
                 class="form-control  @error('referral_name') is-invalid @enderror" placeholder="نام معرف"
                 value="{{ old('referral_name') }}">
             @error('referral_name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">تاریخ تولد <span class="gfield_required">*</span></label>
             <input type="text"  name="birth_date"
                 class="form-control  publish_date_picker  @error('birth_date') is-invalid @enderror" required=""
                 placeholder=" تاریخ تولد" value="{{ old('birth_date') }}">
             @error('birth_date')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">شماره شناسنامه <span class="gfield_required">*</span></label>
             <input type="text" class="form-control    @error('birth_certificate_number') is-invalid @enderror"
                 name="birth_certificate_number" value="{{ old('birth_certificate_number') }}" required=""
                 autofocus="" placeholder="شماره شناسنامه  ">

             @error('birth_certificate_number')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>



 </div>


 {{-- سوابق تحصیلی --}}
 <div class="row mt-5">

     <div class="d-flex justify-content-sm-between">
         <h4 class="title ">سوابق تحصیلی</h4>
         <div id="Add_educational_background" class="btn btn-no-arrow">افزودن سابقه جدید
             <i class="fa fa-solid fa-plus"></i>
         </div>
     </div>

     <hr class="mt-2">

     <div id="Educational_background">
         @php
             $educationHistories = old('education_histories', []);
         @endphp

         @if (count($educationHistories))
             @foreach ($educationHistories as $index => $history)
                 <div class="Educational_background_item">

                     @if ($index != 0)
                         <hr>

                         <button class="remove_btn_Educational_background_item btn btn-no-arrow"><i
                                 class="fa fa-solid fa-trash"></i></button>
                     @endif
                     <div class="row">

                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">مدرک تحصیلی </label>
                                 <input type="text"
                                     class="form-control @error('education_histories.' . $index . '.degree') is-invalid @enderror"
                                     name="education_histories[{{ $index }}][degree]"
                                     value="{{ old("education_histories.$index.degree") }}" placeholder="مدرک تحصیلی">

                                 @error("education_histories.$index.degree")
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">کشور اخذ مدرک </label>
                                 <input type="text"
                                     class="form-control @error("education_histories.$index.country_degree") is-invalid @enderror"
                                     name="education_histories[{{ $index }}][country_degree]"
                                     value="{{ old("education_histories.$index.country_degree") }}"
                                     placeholder="کشور اخذ مدرک">

                                 @error("education_histories.$index.country_degree")
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">نام موسسه </label>
                                 <input type="text"
                                     class="form-control @error("education_histories.$index.university") is-invalid @enderror"
                                     name="education_histories[{{ $index }}][university]"
                                     value="{{ old("education_histories.$index.university") }}"
                                     placeholder="نام موسسه">

                                 @error("education_histories.$index.university")
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">نام رشته </label>
                                 <input type="text"
                                     class="form-control @error("education_histories.$index.field_of_study") is-invalid @enderror"
                                     name="education_histories[{{ $index }}][field_of_study]"
                                     value="{{ old("education_histories.$index.field_of_study") }}"
                                     placeholder="نام رشته">

                                 @error("education_histories.$index.field_of_study")
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">نام گرایش </label>
                                 <input type="text"
                                     class="form-control @error("education_histories.$index.specialization") is-invalid @enderror"
                                     name="education_histories[{{ $index }}][specialization]"
                                     value="{{ old("education_histories.$index.specialization") }}"
                                     placeholder="نام گرایش">

                                 @error("education_histories.$index.specialization")
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-4">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">سال اخذ مدرک</label>
                                 <input type="text"
                                     class="form-control @error("education_histories.$index.graduation_year") is-invalid @enderror"
                                     name="education_histories[{{ $index }}][graduation_year]"
                                     value="{{ old("education_histories.$index.graduation_year") }}"
                                     placeholder="سال اخذ مدرک">

                                 @error("education_histories.$index.graduation_year")
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                     </div>
                 </div>
             @endforeach
         @else
             <div class="Educational_background_item">
                 <div class="row">

                     <div class="col-md-4">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">مدرک تحصیلی </label>
                             <input type="text"
                                 class="form-control @error('education_histories.' . 0 . '.degree') is-invalid @enderror"
                                 name="education_histories[0][degree]"
                                 value="{{ old('education_histories.0.degree') }}" placeholder="مدرک تحصیلی">

                             @error('education_histories.0.degree')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                         </div>
                     </div>

                     <div class="col-md-4">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">کشور اخذ مدرک </label>
                             <input type="text"
                                 class="form-control @error('education_histories.0.country_degree') is-invalid @enderror"
                                 name="education_histories[0][country_degree]"
                                 value="{{ old('education_histories.0.country_degree') }}"
                                 placeholder="کشور اخذ مدرک">

                             @error('education_histories.0.country_degree')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                         </div>
                     </div>

                     <div class="col-md-4">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">نام موسسه </label>
                             <input type="text"
                                 class="form-control @error('education_histories.0.university') is-invalid @enderror"
                                 name="education_histories[0][university]"
                                 value="{{ old('education_histories.0.university') }}" placeholder="نام موسسه">

                             @error('education_histories.0.university')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                         </div>
                     </div>

                     <div class="col-md-4">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">نام رشته </label>
                             <input type="text"
                                 class="form-control @error('education_histories.0.field_of_study') is-invalid @enderror"
                                 name="education_histories[0][field_of_study]"
                                 value="{{ old('education_histories.0.field_of_study') }}" placeholder="نام رشته">

                             @error('education_histories.0.field_of_study')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                         </div>
                     </div>

                     <div class="col-md-4">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">نام گرایش </label>
                             <input type="text"
                                 class="form-control @error('education_histories.0.specialization') is-invalid @enderror"
                                 name="education_histories[0][specialization]"
                                 value="{{ old('education_histories.0.specialization') }}" placeholder="نام گرایش">

                             @error('education_histories.0.specialization')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                         </div>
                     </div>

                     <div class="col-md-4">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">سال اخذ مدرک</label>
                             <input type="text"
                                 class="form-control @error('education_histories.0.graduation_year') is-invalid @enderror"
                                 name="education_histories[0][graduation_year]"
                                 value="{{ old('education_histories.0.graduation_year') }}"
                                 placeholder="سال اخذ مدرک">

                             @error('education_histories.0.graduation_year')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                         </div>
                     </div>

                 </div>
             </div>
         @endif

     </div>



 </div>



 {{-- سوابق شغلی  --}}
 <div class="row mt-5">

     <div class="d-flex justify-content-sm-between">
         <h4 class="title "> سوابق شغلی </h4>
         <div id="add_career_history_item" class="btn btn-no-arrow">افزودن سابقه جدید
             <i class="fa fa-solid fa-plus"></i>
         </div>
     </div>
     <hr class="mt-2">

     <label class="text-16-semibold pb-2">(۳ تجربه آخر) <span class="gfield_required">*</span></label>

     <div id="career_histories">
         @php
             $jobHistories = old('job_histories', []);
         @endphp

         @if (count($jobHistories))
             @foreach ($jobHistories as $index => $history)
                 <div class="career_history_item">
                     @if ($index != 0)
                         <hr>
                         <button class="remove_btn_career_history_item btn btn-no-arrow"><i
                                 class="fa fa-solid fa-trash"></i></button>
                     @endif

                     <div class="row">
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">نام موسسه</label>
                                 <input type="text"
                                     class="form-control @error("job_histories.{$index}.company") is-invalid @enderror"
                                     name="job_histories[{{ $index }}][company]"
                                     value="{{ old("job_histories.{$index}.company") }}" required
                                     placeholder="نام موسسه">
                                 @error("job_histories.{$index}.company")
                                     <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">سمت</label>
                                 <input type="text"
                                     class="form-control @error("job_histories.{$index}.position") is-invalid @enderror"
                                     name="job_histories[{{ $index }}][position]"
                                     value="{{ old("job_histories.{$index}.position") }}" required placeholder="سمت">
                                 @error("job_histories.{$index}.position")
                                     <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">سال شروع</label>
                                 <input type="text"
                                     class="form-control @error("job_histories.{$index}.start_year") is-invalid @enderror"
                                     name="job_histories[{{ $index }}][start_year]"
                                     value="{{ old("job_histories.{$index}.start_year") }}" required
                                     placeholder="سال شروع">
                                 @error("job_histories.{$index}.start_year")
                                     <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">سال پایان</label>
                                 <input type="text"
                                     class="form-control @error("job_histories.{$index}.end_year") is-invalid @enderror"
                                     name="job_histories[{{ $index }}][end_year]"
                                     value="{{ old("job_histories.{$index}.end_year") }}" placeholder="سال پایان">
                                 @error("job_histories.{$index}.end_year")
                                     <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                 @enderror
                             </div>
                         </div>
                     </div>
                 </div>
             @endforeach
         @else
             <div class="career_history_item">
                 <div class="row">
                     <div class="col-md-3">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">نام موسسه</label>
                             <input type="text"
                                 class="form-control @error('job_histories.0.company') is-invalid @enderror"
                                 name="job_histories[0][company]" value="{{ old('job_histories.0.company') }}"
                                 required placeholder="نام موسسه">
                             @error('job_histories.0.company')
                                 <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                             @enderror
                         </div>
                     </div>

                     <div class="col-md-3">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">سمت</label>
                             <input type="text"
                                 class="form-control @error('job_histories.0.position') is-invalid @enderror"
                                 name="job_histories[0][position]" value="{{ old('job_histories.0.position') }}"
                                 required placeholder="سمت">
                             @error('job_histories.0.position')
                                 <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                             @enderror
                         </div>
                     </div>

                     <div class="col-md-3">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">سال شروع</label>
                             <input type="text"
                                 class="form-control @error('job_histories.0.start_year') is-invalid @enderror"
                                 name="job_histories[0][start_year]" value="{{ old('job_histories.0.start_year') }}"
                                 required placeholder="سال شروع">
                             @error('job_histories.0.start_year')
                                 <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                             @enderror
                         </div>
                     </div>

                     <div class="col-md-3">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">سال پایان</label>
                             <input type="text"
                                 class="form-control @error('job_histories.0.end_year') is-invalid @enderror"
                                 name="job_histories[0][end_year]" value="{{ old('job_histories.0.end_year') }}"
                                 placeholder="سال پایان">
                             @error('job_histories.0.end_year')
                                 <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                             @enderror
                         </div>
                     </div>
                 </div>
             </div>
         @endif


     </div>



 </div>

 {{-- اطلاعات تماس --}}
 <div class="row mt-5">
     <h4 class="title ">اطلاعات تماس </h4>
     <hr>
     <label class="text-16-semibold pb-2">آدرس <span class="gfield_required">*</span></label>

     <div class="col-md-12">
         <div class="form-group">
             <label class="text-16-semibold pb-2">آدرس خیابان </label>
             <input type="text" class="form-control   @error('address') is-invalid @enderror" name="address"
                 value="{{ old('address') }}" required="" autofocus="" placeholder="آدرس خیابان  ">
             @error('address')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-12">
         <div class="form-group">
             <label class="text-16-semibold pb-2">آدرس 2 </label>
             <input type="text" class="form-control   @error('address2') is-invalid @enderror" name="address2"
                 value="{{ old('address2') }}"autofocus="" placeholder="آدرس 2  ">
             @error('address2')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">شهر </label>
             <input type="text" class="form-control   @error('city') is-invalid @enderror" name="city"
                 value="{{ old('city') }}" required="" autofocus="" placeholder="شهر  ">
             @error('city')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">استان </label>
             <input type="text" class="form-control   @error('state') is-invalid @enderror" name="state"
                 value="{{ old('state') }}" required="" autofocus="" placeholder="استان  ">
             @error('state')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">کد پستی </label>
             <input type="text" class="form-control   @error('postal_code') is-invalid @enderror"
                 name="postal_code" value="{{ old('postal_code') }}" required="" autofocus=""
                 placeholder="کد پستی  ">
             @error('postal_code')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">کشور </label>
             <input type="text" class="form-control   @error('country') is-invalid @enderror" name="country"
                 value="{{ old('country') }}" required="" autofocus="" placeholder="کشور  ">
             @error('country')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">ایمیل <span class="gfield_required">*</span></label>
             <input type="email" class="form-control   @error('email') is-invalid @enderror" name="email"
                 value="{{ old('email') }}" required="" autofocus="" placeholder="ایمیل  ">
             @error('email')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">تلفن همراه <span class="gfield_required">*</span></label>
             <input type="text" class="form-control   @error('phone') is-invalid @enderror" name="phone"
                 value="{{ old('phone') }}" required="" autofocus="" placeholder="تلفن همراه  ">
             @error('phone')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

 </div>

 {{-- تجارب مرتبط با هوش مصنوعی --}}
 <div class="row mt-5">

     <div class="d-flex justify-content-sm-between">
         <h4 class="title ">تجارب مرتبط با هوش مصنوعی </h4>
         <div id="add_experiencesAi_item" class="btn btn-no-arrow">افزودن تجربه جدید
             <i class="fa fa-solid fa-plus"></i>
         </div>
     </div>
     <hr class="mt-2">



     <div id="experiencesAi">
         @php
             $experience_ai = old('experience_ai', []);
         @endphp
         @if (count($experience_ai))
             @foreach ($experience_ai as $index => $exp)
                 <div class="experiencesAi_item" data-index="{{ $index }}">

                     @if ($index != 0)
                         <hr>
                         <button class="remove_btn_experiencesAi_item btn btn-no-arrow"><i
                                 class="fa fa-solid fa-trash"></i></button>
                     @endif
                     <div class="row">
                         <div class="col-md-11">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">شرح تجربیات</label>
                                 <input type="text"
                                     class="form-control @error('experience_ai.' . $index) is-invalid @enderror"
                                     name="experience_ai[{{ $index }}]" value="{{ $exp }}"
                                     placeholder="شرح تجربیات">
                                 @error('experience_ai.' . $index)
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                     </div>
                 </div>
             @endforeach
         @else
             <div class="experiencesAi_item">
                 <div class="row">
                     <div class="col-md-11">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2"> شرح تجربیات </label>
                             <input type="text"
                                 class="form-control   @error('experience_ai.*') is-invalid @enderror"
                                 name="experience_ai[]" value="" autofocus="" placeholder="شرح تجربیات">
                             @error('experience_ai.*')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                         </div>
                     </div>
                 </div>
             </div>
         @endif

     </div>



     <div class="col-md-12">
         <div class="form-group">
             <label class="text-16-semibold pb-2">لطفاً در حداکثر ۱۰۰ کلمه، تخصص، تجربه‌ها و
                 حوزه کاری فعلی خود را ارسال بفرمایید تا در بخش معرفی اعضای سایت انجمن درج شود.
                 توجه داشته باشید که این اطلاعات برای مشاهده عموم در دسترس خواهد بود. </label>

             <textarea name="experience_ai_description" id="" maxlength="550"
                 class="form-control @error('experience_ai_description') is-invalid @enderror" cols="30" rows="10"></textarea>
             <label class="text-16-semibold pb-2">
                 <span id="experience_ai_description_length">0</span> از 550 کلمه حداکثر
             </label>

             @error('experience_ai_description')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

 </div>

 {{-- مدارک --}}
 <div class="row mt-5">
     <h4 class="title "> مدارک</h4>
     <hr>

     <div class="row">
         <div class="col-md-6">
             <div class="form-group">
                 <label class="text-16-semibold pb-2">فایل رزومه <span class="gfield_required">*</span></label>
                 <input type="file" class="form-control   @error('resume_file') is-invalid @enderror"
                     name="resume_file" value="{{ old('resume_file') }}" required="" autofocus="">
                 @error('resume_file')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror

                 <p class="mt-2">حداکثر اندازه فایل: 1 MB.</p>

                 <p>
                     لطفا فایل رزومه خود را در قالب pdf بار‌گذاری کنید.
                 </p>

             </div>
         </div>
     </div>


     <div class="row">
         <div class="col-md-6">
             <div class="form-group">
                 <label class="text-16-semibold pb-2"> تصویر آخرین مدرک تحصیلی <span
                         class="gfield_required">*</span></label>
                 <input type="file" class="form-control   @error('degree_certificate_image') is-invalid @enderror"
                     name="degree_certificate_image" value="{{ old('degree_certificate_image') }}" required=""
                     autofocus="">
                 @error('degree_certificate_image')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror

                 <p class="mt-2">حداکثر اندازه فایل: 1 MB.</p>

                 <p>
                     لطفا فایل آخرین مدرک تحصیلی را در قالب pdf بار‌گذاری کنید.
                 </p>

             </div>
         </div>

     </div>

     {{-- <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="text-16-semibold pb-2">تصویر فیش واریزی <span
                        class="gfield_required">*</span></label>
                <input type="file"
                    class="form-control   @error('deposit_slip_image') is-invalid @enderror"
                    name="deposit_slip_image" value="{{ old('deposit_slip_image') }}"
                    required="" autofocus="">
                @error('deposit_slip_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <p class="mt-2">حداکثر اندازه فایل: 1 MB.</p>

                <p>
                    لطفا تصویر فیش واریزی حق عضویت را در قالب pdf بار‌گذاری کنید.
                </p>

            </div>
        </div>
    </div> --}}



 </div>

 <hr>
 <div class="box-forgot-pass">
     <label>
         <input type="checkbox" class="cb-remember" name="final_approval" value="1" required
             {{ old('final_approval') == 1 ? 'checked' : '' }}> <span>
             اینجانب صحت مشخصات و اطلاعات مندرج در فرم عضویت را تأیید نموده و درخواست عضویت حقیقی
             در انجمن هوش مصنوعی ایران را دارم.
         </span>
     </label>
 </div>
