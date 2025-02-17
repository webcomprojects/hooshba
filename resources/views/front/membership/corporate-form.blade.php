 {{-- مشخصات فردی --}}
 <div class="row mt-5">
     <h4 class="title "> مشخصات شرکت </h4>
     <hr>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">نام شرکت </label>
             <input type="text" class="form-control   @error('company_name') is-invalid @enderror"
                 name="company_name" value="{{ old('company_name') }}" autofocus=""
                 placeholder="نام شرکت  ">
             @error('company_name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2"> نام شرکت به انگلیسی </label>
             <input type="text" name="company_name_en"
                 class="form-control    @error('company_name_en') is-invalid @enderror"
                 placeholder="نام شرکت به انگلیسی " value="{{ old('company_name_en') }}">
             @error('company_name_en')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">شناسه ملی شرکت <span class="gfield_required">*</span></label>
             <input type="text" class="form-control   @error('company_national_id') is-invalid @enderror"
                 name="company_national_id" value="{{ old('company_national_id') }}" required="" autofocus=""
                 placeholder="شناسه ملی شرکت  ">
             @error('company_national_id')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">شماره ثبت شرکت <span class="gfield_required">*</span></label>
             <input type="text" name="company_registration_number"
                 class="form-control  @error('company_registration_number') is-invalid @enderror"
                 placeholder="شماره ثبت شرکت " required="" value="{{ old('company_registration_number') }}">
             @error('company_registration_number')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-12">
         <div class="row">
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="text-16-semibold pb-2"> تاریخ ثبت شرکت <span class="gfield_required">*</span></label>
                     <input type="text" name="company_established_date"
                         class="form-control  publish_date_picker  @error('company_established_date') is-invalid @enderror" required=""
                         placeholder="  تاریخ ثبت شرکت" value="{{ old('company_established_date') }}">
                     @error('company_established_date')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>
             </div>
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2"> نام و سمت نماینده شرکت در ارتباط با انجمن </label>
             <input type="text" class="form-control    @error('representative_name') is-invalid @enderror"
                 name="representative_name" value="{{ old('representative_name') }}" autofocus=""
                 placeholder="نام و سمت نماینده شرکت در ارتباط با انجمن">

             @error('representative_name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2"> کد ملی نماینده شرکت</label>
             <input type="text" class="form-control    @error('representative_national_id') is-invalid @enderror"
                 name="representative_national_id" value="{{ old('representative_national_id') }}" autofocus=""
                 placeholder=" کد ملی نماینده شرکت ">

             @error('representative_national_id')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
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
             <label class="text-16-semibold pb-2">پست الکترونیکی شرکت <span class="gfield_required">*</span></label>
             <input type="email" class="form-control   @error('email_company') is-invalid @enderror"
                 name="email_company" value="{{ old('email_company') }}" required="" autofocus=""
                 placeholder="پست الکترونیکی شرکت  ">
             @error('email_company')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2">پست الکترونیکی نماینده <span
                     class="gfield_required">*</span></label>
             <input type="email" class="form-control   @error('representative_email') is-invalid @enderror"
                 name="representative_email" value="{{ old('representative_email') }}" required=""
                 autofocus="" placeholder="پست الکترونیکی نماینده  ">
             @error('representative_email')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>
     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2"> وب سایت شرکت </label>
             <input type="text" class="form-control ltr @error('website') is-invalid @enderror" name="website"
                 value="{{ old('website') }}" autofocus="" placeholder="وب سایت شرکت">
             @error('website')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
         </div>
     </div>

     <div class="col-md-6">
         <div class="form-group">
             <label class="text-16-semibold pb-2"> شماره همراه نماینده <span class="gfield_required">*</span></label>
             <input type="text" class="form-control   @error('representative_phone') is-invalid @enderror"
                 name="representative_phone" value="{{ old('representative_phone') }}" required=""
                 autofocus="" placeholder=" شماره همراه نماینده  ">
             @error('representative_phone')
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
         <div id="add_corporate_experiencesAi_item" class="btn btn-no-arrow">افزودن تجربه جدید
             <i class="fa fa-solid fa-plus"></i>
         </div>
     </div>
     <hr class="mt-2">



     <div id="corporateExperiencesAi">
         @php
             $corporate_experience_ai = old('corporate_experience_ai', []);
         @endphp
         @if (count($corporate_experience_ai))
             @foreach ($corporate_experience_ai as $index => $exp)
                 <div class="corporate_experiencesAi_item" data-index="{{ $index }}">

                     @if ($index != 0)
                         <hr>
                         <button class="remove_btn_corporate_experiencesAi_item btn btn-no-arrow"><i
                                 class="fa fa-solid fa-trash"></i></button>
                     @endif
                     <div class="row">
                         <div class="col-md-11">
                             <div class="form-group">
                                 <label class="text-16-semibold pb-2">شرح تجربیات</label>
                                 <input type="text"
                                     class="form-control @error('corporate_experience_ai.' . $index) is-invalid @enderror"
                                     name="corporate_experience_ai[{{ $index }}]" value="{{ $exp }}"
                                     placeholder="شرح تجربیات">
                                 @error('corporate_experience_ai.' . $index)
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
             <div class="corporate_experiencesAi_item" data-index="0">

                 <div class="row">
                     <div class="col-md-11">
                         <div class="form-group">
                             <label class="text-16-semibold pb-2">شرح تجربیات</label>
                             <input type="text"
                                 class="form-control"
                                 name="corporate_experience_ai[]" value="" placeholder="شرح تجربیات">

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
                 <label class="text-16-semibold pb-2"> تصویر آگهی تاسیس شرکت <span
                         class="gfield_required">*</span></label>
                 <input type="file" class="form-control   @error('resume_file') is-invalid @enderror"
                     name="resume_file" value="{{ old('resume_file') }}" required="" autofocus="">
                 @error('resume_file')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror

                 <p class="mt-2">حداکثر اندازه فایل: 1 MB.</p>

                 <p>
                     لطفا تصویر آگهی تاسیس شرکت در روزنامه رسمی کشور را در قالب pdf بار‌گذاری کنید.
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
             اینجانب به عنوان نماینده شرکت صحت مشخصات و اطلاعات مندرج در فرم عضویت را تأیید نموده و درخواست عضویت حقوقی
             درانجمن هوش مصنوعی ایران را دارم.
         </span>
     </label>
 </div>
